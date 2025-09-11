<?php

namespace App\Http\Services\v1;

use App\Http\Repositories\v1\TenantRepository;
use App\Models\Tenant;
use Illuminate\Http\UploadedFile;

class TenantService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected  TenantRepository $tenantRepository)
    {

    }

    public function create(array $data): Tenant
    {
            $logo = $data['logo'] ?? null;

            unset($data['logo']);

            $tenant = $this->tenantRepository->create($data);

            if ($logo instanceof UploadedFile) {
                $tenant->addMedia($logo)->toMediaCollection('logo');
            }

            return $tenant;

    }

    public function update(int $id, array $data): Tenant
    {
            $logo = $data['logo'] ?? null;

            unset($data['logo']);

            $tenant = $this->tenantRepository->update($id, $data);

            if ($logo instanceof UploadedFile) {
                $tenant->clearMediaCollection('logo');
                $tenant->addMedia($logo)->toMediaCollection('logo');
            }

            return $tenant;
    }

    public function delete(array $ids)
    {

        return $this->tenantRepository->delete($ids);
    }
}
