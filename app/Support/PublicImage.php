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
        self::ensureDirectory($directory);

        return $file->store($directory, 'public');
    }

    /**
     * Store under stores/{userId}/ (creates folder if missing).
     */
    public static function storeForUser(UploadedFile $file, int|string $userId, string $base = 'stores'): string
    {
        $directory = trim($base, '/') . '/' . $userId;

        return self::store($file, $directory);
    }

    public static function ensureDirectory(string $directory): void
    {
        $path = trim($directory, '/');

        if ($path !== '' && ! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }
    }

    public static function delete(?string $path): void
    {
        if (self::isStored($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
