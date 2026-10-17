<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Singleton service for managing media uploads and URL resolution.
 */
class MediaStorageService
{
    /**
     * Store an uploaded file in the specified directory.
     */
    public function store(UploadedFile $file, string $directory = 'uploads', string $disk = 'public'): string
    {
        $filename = time().'-'.Str::random(10).'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, $disk);

        return $path;
    }

    /**
     * Resolve the public URL for a stored asset path or existing external URL.
     */
    public function url(?string $path, string $disk = 'public'): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return Storage::disk($disk)->url($path);
    }

    /**
     * Delete a stored file.
     */
    public function delete(?string $path, string $disk = 'public'): bool
    {
        if (empty($path) || Str::startsWith($path, ['http://', 'https://'])) {
            return false;
        }

        return Storage::disk($disk)->delete($path);
    }
}
