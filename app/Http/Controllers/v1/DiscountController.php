<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DeleteMultipleRequest;
use App\Http\Requests\Discount\CreateDiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;
use App\Http\Resources\DiscountResource;
use App\Http\Services\v1\DiscountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    protected DiscountService $discount_service;

    public function __construct(DiscountService $discount_service)
    {
        $this->discount_service = $discount_service;
    }

    public function index(): JsonResponse
    {
        $discounts = $this->discount_service->index();
        return DiscountResource::collection($discounts)->response()->setStatusCode(200);
    }

    public function store(CreateDiscountRequest $request): JsonResponse
    {
        $discount = $this->discount_service->store($request->validated());

        return (new DiscountResource($discount))->additional(['message' => trans('discount.created')])->response()->setStatusCode(201);
    }

    public function show(int $id): JsonResponse
    {
        $discount = $this->discount_service->show($id);

        return (new DiscountResource($discount))->response()->setStatusCode(200);
    }

    public function update(UpdateDiscountRequest $request, int $id): JsonResponse
    {
        $discount = $this->discount_service->update($request->validated(), $id);

        return (new DiscountResource($discount))->additional(['message' => trans('discount.updated')])->response()->setStatusCode(202);
    }

    public function destroy_bulk(DeleteMultipleRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->discount_service->destroy($validated['ids']);

        return response()->json(['message' => trans('discount.deleted')]);
    }
}
