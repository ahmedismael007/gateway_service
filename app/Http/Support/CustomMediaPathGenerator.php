<?php
namespace App\Http\Support;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;

class CustomMediaPathGenerator extends DefaultPathGenerator
{
    /**
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPath(Media $media): string
    {
        $tenantId = $this->getTenantId();
        $collectionName = $media->collection_name;

        // Ensure the filename is unique by appending media ID
        return "{$tenantId}/{$collectionName}/{$media->id}/";
    }

    /**
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string
    {
        $tenantId = $this->getTenantId();
        $collectionName = $media->collection_name;

        return "{$tenantId}/{$collectionName}/{$media->id}/conversions/";
    }

    /**
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        $tenantId = $this->getTenantId();
        $collectionName = $media->collection_name;

        return "{$tenantId}/{$collectionName}/{$media->id}/responsive-images/";
    }

    /**
     * Get the current tenant ID or return 'central' if no tenant is identified.
     */
    private function getTenantId(): string
    {
        $tenant = tenant();
        return $tenant ? $tenant->id : 'ceo';
    }
}