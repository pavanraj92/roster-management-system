<?php

namespace App\Traits;

use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasMedia
{
    /**
     * Get all media for the model.
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    /**
     * Get a single specific media (like avatar).
     */
    public function singleMedia(string $collection = 'default'): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('collection_name', $collection);
    }

    /**
     * Upload and attach media to the model.
     */
    public function uploadMedia(UploadedFile $file, string $collection = 'default', string $disk = 'public', bool $clearExisting = true): Media
    {
        if ($clearExisting) {
            $this->clearMedia($collection);
        }

        $extension = $file->getClientOriginalExtension();
        $fileName = $file->getClientOriginalName();
        $path = $file->store($this->getMediaPath($collection), $disk);

        return $this->media()->create([
            'file_name' => $fileName,
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'disk' => $disk,
            'size' => $file->getSize(),
            'collection_name' => $collection,
        ]);
    }

    /**
     * Clear existing media for a specific collection.
     */
    public function clearMedia(string $collection = 'default'): void
    {
        $mediaHits = $this->media()->where('collection_name', $collection)->get();

        foreach ($mediaHits as $media) {
            Storage::disk($media->disk)->delete($media->file_path);
            $media->delete();
        }
    }

    /**
     * Define the storage path for specific collections.
     */
    protected function getMediaPath(string $collection): string
    {
        $folderName = strtolower(class_basename($this));
        return "media/{$folderName}/{$collection}";
    }
}
