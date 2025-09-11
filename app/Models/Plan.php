<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Plan extends Model
{
    protected $fillable = [
        'name', 'description', 'status'
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];


    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class);
    }

    public function discount() : HasOne
    {
        return $this->hasOne(Discount::class);
    }
}
