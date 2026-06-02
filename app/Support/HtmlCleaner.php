<?php

namespace App\Support;

final class HtmlCleaner
{
    private const ALLOWED_TAGS = '<p><br><strong><b><em><i><u><ul><ol><li><h2><h3><h4><h5><a><img><blockquote><table><thead><tbody><tr><th><td><div><span><hr>';

    public static function clean(?string $html): ?string
    {
        if ($html === null || trim($html) === '') {
            return null;
        }

        $cleaned = strip_tags($html, self::ALLOWED_TAGS);

        return trim($cleaned) !== '' ? $cleaned : null;
    }

    public static function plainText(?string $html): string
    {
        if (! $html) {
            return '';
        }

        return trim(preg_replace('/\s+/', ' ', strip_tags($html)));
    }
}
