<?php

declare(strict_types=1);

namespace App\Support;

class Sanitizer
{
    private static array $allowedTags = [
        'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'strong', 'b', 'em', 'i', 'u', 's', 'strike',
        'ul', 'ol', 'li', 'blockquote', 'code', 'pre',
        'a', 'img', 'table', 'thead', 'tbody', 'tr', 'th', 'td',
        'hr', 'br', 'span', 'div'
    ];

    /**
     * Clean HTML markup by stripping unsafe tags, scripts, and javascript: links.
     */
    public static function cleanHtml(string $html): string
    {
        // 1. Strip script, style, iframe, object, embed tags entirely
        $html = preg_replace('/<(script|style|iframe|object|embed)\b[^>]*>.*?<\/\1>/is', '', $html) ?? $html;

        // 2. Strip event handlers (onclick, onerror, onload, etc.)
        $html = preg_replace('/\s+on[a-z]+\s*=\s*(["\'][^"\']*["\']|[^\s>]+)/i', '', $html) ?? $html;

        // 3. Strip javascript: and vbscript: URIs
        $html = preg_replace('/\s+(href|src)\s*=\s*(["\']\s*(javascript|vbscript|data):[^"\']*["\'])/i', '', $html) ?? $html;

        // 4. Strip tags not in whitelist
        $tagList = '<' . implode('><', self::$allowedTags) . '>';
        return strip_tags($html, $tagList);
    }
}
