<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'plan_id'         => $this->plan_id,
            'discount_amount' => $this->discount_amount,
            'discount_type'   => $this->discount_type,
            'start_date'      => $this->start_date,
            'end_date'        => $this->end_date,
        ];
    }
}
