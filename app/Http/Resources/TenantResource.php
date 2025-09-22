<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'commercial_number' => $this->commercial_number,
            'tax_number' => $this->tax_number,
            'logo' => $this->getFirstMediaUrl('logo'),
        ];
    }
}
