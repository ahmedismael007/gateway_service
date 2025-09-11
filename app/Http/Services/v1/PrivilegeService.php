<?php

namespace App\Http\Services\v1;

use App\Http\Repositories\v1\PrivilegeRepository;

class PrivilegeService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected PrivilegeRepository $privilege_repository)
    {
        //
    }

    public function index()
    {
        return $this->privilege_repository->index();
    }
}
