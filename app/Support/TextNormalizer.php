<?php

declare(strict_types=1);

namespace App\Support;

class TextNormalizer
{
    /**
     * Normalize Persian text (Arabic characters, redundant spaces, ZWNJ).
     */
    public static function clean(string $text): string
    {
        // 1. Arabic Yeh and Kaf to Persian
        $text = str_replace(
            ['ي', 'ك', 'ى', 'ة', 'ۀ', 'ؤ', 'إ', 'أ', 'ء'],
            ['ی', 'ک', 'ی', 'ه', 'ه', 'و', 'ا', 'ا', ''],
            $text
        );

        // 2. Remove multiple spaces and normalize ZWNJ
        $text = preg_replace('/[ \t]+/u', ' ', $text) ?? $text;
        $text = preg_replace('/(\x{200C})+/u', "\u{200C}", $text) ?? $text;

        return trim($text);
    }

    /**
     * Convert Persian and Arabic digits to English digits.
     */
    public static function toEnglishDigits(string $text): string
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic  = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($arabic, $english, str_replace($persian, $english, $text));
    }

    /**
     * Convert English digits to Persian digits for display.
     */
    public static function toPersianDigits(string|int|float $text): string
    {
        $text = (string) $text;
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        return str_replace($english, $persian, $text);
    }
}
