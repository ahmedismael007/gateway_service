<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DeleteMultipleRequest;
use App\Http\Requests\Plan\CreatePlanRequest;
use App\Http\Requests\Plan\UpdatePlanRequest;
use App\Http\Resources\PlanResource;
use App\Http\Services\v1\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(protected PlanService $plan_service) {}

    public function index() {
        $plans = $this->plan_service->index();

        return (PlanResource::collection($plans))->response()->setStatusCode(200);
    }

    public function store(CreatePlanRequest $request)
    {
        $data = $request->validated();

        $plan = $this->plan_service->create($data);

        $features = $data['features'] ?? [];

        if (!empty($features)) {
            $plan->features()->sync($features);
        }

        return (new PlanResource($plan))->additional(['message' => trans('tenant.plan.created')])->response()->setStatusCode(201);
    }

    public function show(int $id) {
        $plan = $this->plan_service->show($id);

        return (PlanResource::make($plan))->response()->setStatusCode(200);
    }

    public function update(int $id, UpdatePlanRequest $request) {

        $data = $request->validated();

        $plan = $this->plan_service->update($id, $data);

        return (PlanResource::make($plan))->additional(['message' => trans('tenant.plan.updated')])->response()->setStatusCode(202);
    }

    public function destroy(DeleteMultipleRequest $request)
    {
        $validated = $request->validated();

         $this->plan_service->destroy($validated['ids']);

         return response()->json(['message' => trans('tenant.plan.deleted')]);
    }

}
