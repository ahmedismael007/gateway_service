<?php

namespace App\Http\Repositories\v1;

use App\Models\Feature;

class FeatureRepository
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
        return Feature::with('privileges')->latest()->paginate(25);
    }
}
