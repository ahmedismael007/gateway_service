<?php

namespace App\Http\Repositories\v1;

use App\Models\Theme;

class ThemeRepository
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
        return Theme::latest()->paginate(25);
    }

    public function store(array $data)
    {
        $image = $data['image'] ?? null;
        unset($data['image']);

        $theme = Theme::create($data);

        if ($image) {
            $theme->addMedia($image)->toMediaCollection('images');
        }

        return $theme;
    }


    public function show($id)
    {
        return Theme::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $theme = $this->show($id);

        $image = $data['image'] ?? null;
        unset($data['image']);

        $theme->update($data);

        if ($image) {
            $theme->clearMediaCollection('images');
            $theme->addMedia($image)->toMediaCollection('images');
        }

        return $theme;
    }

    public function destroy(array $ids)

    {
        $themes = Theme::whereIn('id', $ids)->get();

        foreach ($themes as $theme) {
            $theme->clearMediaCollection('images');
            $theme->delete();
        }

        return true;
    }
}
