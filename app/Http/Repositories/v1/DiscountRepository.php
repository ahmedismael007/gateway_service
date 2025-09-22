<?php

namespace App\Http\Repositories\v1;

use App\Models\Discount;

class DiscountRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return Discount::latest()->paginate(25);
    }

    public function store(array $data): Discount
    {
        return Discount::create($data);
    }

    public function show(int $id) : Discount {
        return Discount::findOrFail($id);
    }

    public function update(array $data, int $id): Discount
    {
        $discount = $this->show($id);

        $discount->update($data);

        return $discount;
    }

    public function destroy(array $ids): bool
    {
        Discount::destroy($ids);

        return true;
    }
}
