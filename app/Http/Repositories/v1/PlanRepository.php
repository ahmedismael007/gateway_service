<?php

namespace App\Http\Repositories\v1;

use App\Models\Plan;
use Illuminate\Pagination\LengthAwarePaginator;

class PlanRepository
{
    public function index():LengthAwarePaginator {
        return Plan::with('features')->latest()->paginate(25);
    }

    public function create(array $data):Plan {
        unset($data['features']);

        return Plan::create($data);
    }

    public function show(int $id):Plan
    {
        return Plan::findOrFail($id);
    }

    public function update(int $id, array $data):Plan {
        $plan = Plan::findOrFail($id);

        return $plan->update($data);
    }

    public function destroy(array $ids):int {
        return Plan::destroy($ids);
    }
}
