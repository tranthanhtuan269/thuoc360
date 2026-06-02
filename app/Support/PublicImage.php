<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class PublicImage
{
    public static function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (preg_match('#^https?://#i', $path) || str_starts_with($path, '//')) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public static function isStored(?string $path): bool
    {
        return $path
            && ! preg_match('#^https?://#i', $path)
            && ! str_starts_with($path, '//');
    }

    public static function store(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, 'public');
    }

    public static function delete(?string $path): void
    {
        if (self::isStored($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
