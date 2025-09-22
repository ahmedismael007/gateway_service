<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DeleteMultipleRequest;
use App\Http\Requests\Tenant\CreateTenantRequest;
use App\Http\Requests\Tenant\UpdateTenantRequest;
use App\Http\Resources\TenantResource;
use App\Http\Services\v1\Kafka\KafkaProducerService;
use App\Http\Services\v1\TenantService;
use App\Models\User;

class TenantController extends Controller
{
    public function __construct(protected TenantService $tenantService, protected KafkaProducerService $kafka) {}
    public function store(CreateTenantRequest $request)
    {
        $data = $request->validated();

        $tenant = $this->tenantService->create($data);

        $user = auth()->user();

        $tenant->users()->attach($user->id);

        $tenant->run(function () use ($user) {
            User::create([
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'username'   => $user->username,
                'email'      => $user->email,
                'phone'      => $user->phone,
                'password'   => $user->password,
                'status'     => $user->status ?? 'active',
            ]);
        });

        $kafka_data = [
            'user' => $user->toArray(),
            'tenant' => $tenant->toArray()
        ];

        $this->kafka->publish('tenant_created', null, $kafka_data);

        $tenant_id = $tenant->id;

        return (new TenantResource($tenant))->additional(['message' => trans('tenant.create.success'), 'tenant_id' => $tenant_id])
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateTenantRequest $request, int $id)
    {
        $data = $request->validated();

        $tenant = $this->tenantService->update($id, $data);

        return (new TenantResource($tenant))
            ->additional(['message' => trans('tenant.update.success')])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy_bulk(DeleteMultipleRequest $request)
    {
        $validated = $request->validated();

        $this->tenantService->delete($validated['ids']);

        return response()->json(['message' => trans('tenant.delete.success')], 200);
    }
}
