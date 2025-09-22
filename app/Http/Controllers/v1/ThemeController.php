<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DeleteMultipleRequest;
use App\Http\Requests\Theme\CreateThemeRequest;
use App\Http\Requests\Theme\UpdateThemeRequest;
use App\Http\Resources\ThemeResource;
use App\Http\Services\v1\ThemeService;
use Illuminate\Http\JsonResponse;

class ThemeController extends Controller
{
    public function __construct(protected ThemeService $theme_service) {}

    public function index(): JsonResponse
    {
        $themes = $this->theme_service->index();

        return ThemeResource::collection($themes)->response()->setStatusCode(200);
    }

    public function store(CreateThemeRequest $request): JsonResponse
    {
        $theme = $this->theme_service->store($request->validated());

        return (new ThemeResource($theme))
            ->additional(['message' => trans('theme.created')])
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id): JsonResponse
    {
        $theme = $this->theme_service->show($id);

        return (new ThemeResource($theme))->response()->setStatusCode(200);
    }

    public function update(UpdateThemeRequest $request, int $id): JsonResponse
    {
        $theme = $this->theme_service->update($request->validated(), $id);

        return (new ThemeResource($theme))
            ->additional(['message' => trans('theme.updated')])
            ->response()
            ->setStatusCode(202);
    }

    public function destroy_bulk(DeleteMultipleRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->theme_service->destroy($validated['ids']);

        return response()->json(['message' => trans('theme.deleted')]);
    }
}
