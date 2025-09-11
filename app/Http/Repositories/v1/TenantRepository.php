<?php

namespace App\Http\Repositories\v1;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TenantRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function create(array $data): Tenant
    {
        return Tenant::create($data);
    }

    public function find($id): Tenant
    {
        $tenant = Tenant::find($id);

        if (!$tenant) {
            Throw new ModelNotFoundException("Tenant {$id} not found!");
        }

        return $tenant;
    }

    public function update(int $id, array $data): Tenant
    {
        $tenant = $this->find($id);

        $tenant->update($data);

        return $tenant;
    }

    public function delete(array $ids): Bool {
        return DB::transaction(function () use ($ids) {
            return Tenant::whereIn('id', $ids)->delete() > 0;
        });
    }

}
