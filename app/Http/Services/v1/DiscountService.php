<?php

namespace App\Http\Services\v1;

use App\Http\Repositories\v1\DiscountRepository;
use App\Models\Discount;

class DiscountService
{
    /**
     * Create a new class instance.
     */
    protected DiscountRepository $discount_repository;

    public function __construct(DiscountRepository $discount_repository)
    {
        $this->discount_repository = $discount_repository;
    }

    public function index()
    {
        return $this->discount_repository->index();
    }

    public function store(array $data): Discount
    {
        return $this->discount_repository->store($data);
    }

    public function show(int $id): Discount
    {
        return $this->discount_repository->show($id);
    }

    public function update(array $data, int $id): Discount
    {
        return $this->discount_repository->update($data, $id);
    }

    public function destroy(array $ids): bool
    {
        return $this->discount_repository->destroy($ids);
    }
}
