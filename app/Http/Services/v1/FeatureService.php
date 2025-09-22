<?php

namespace App\Http\Services\v1;

use App\Http\Repositories\v1\FeatureRepository;

class FeatureService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected FeatureRepository $feature_repository)
    {
        //
    }

    public function index()
    {
        return $this->feature_repository->index();
    }
}
