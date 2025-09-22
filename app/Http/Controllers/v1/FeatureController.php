<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\v1\FeatureRepository;
use App\Http\Resources\FeatureResource;

class FeatureController extends Controller
{
    public function __construct(protected FeatureRepository $featureRepository)
    {

    }
    public function index()
    {
        $features = $this->featureRepository->index();

        return FeatureResource::collection($features)->response()->setStatusCode(200);
    }
}
