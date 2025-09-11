<?php

namespace App\Http\Services\v1;

use App\Http\Repositories\v1\ThemeRepository;

class ThemeService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected ThemeRepository $theme_repository)
    {
        //
    }

    public function index()
    {
        return $this->theme_repository->index();
    }

    public function store(array $data)
    {
        return $this->theme_repository->store($data);
    }

    public function show(int $id)
    {
        return $this->theme_repository->show($id);
    }

    public function update(array $data, int $id)
    {
        return $this->theme_repository->update($data, $id);
    }

    public function destroy(array $ids)
    {
        return $this->theme_repository->destroy($ids);
    }
}
