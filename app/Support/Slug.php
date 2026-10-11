<?php

declare(strict_types=1);

namespace App\Support;

class Slug
{
    /**
     * Generate an SEO-friendly slug supporting Persian, English, and digits.
     */
    public static function create(string $title, string $separator = '-'): string
    {
        $title = TextNormalizer::clean($title);
        $title = mb_strtolower($title, 'UTF-8');

        // Replace whitespace and unwanted punctuation with separator
        $title = preg_replace('/[^\p{L}\p{Nd}\d]+/u', $separator, $title) ?? $title;

        // Trim separators
        return trim($title, $separator);
    }
}
