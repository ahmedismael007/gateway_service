<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrivilegeResource;
use App\Http\Services\v1\PrivilegeService;

class PrivilegeController extends Controller
{
    protected function __construct(protected PrivilegeService $privilege_service)
    {

    }

    public function index() {
        $privileges = $this->privilege_service->index();

        return PrivilegeResource::collection($privileges)->response()->setStatusCode(200);
    }
}
