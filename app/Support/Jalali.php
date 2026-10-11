<?php

declare(strict_types=1);

namespace App\Support;

use DateTimeInterface;

class Jalali
{
    private static array $monthNames = [
        1 => 'فروردین', 2 => 'اردیبهشت', 3 => 'خرداد',
        4 => 'تیر',     5 => 'مرداد',   6 => 'شهریور',
        7 => 'مهر',     8 => 'آبان',     9 => 'آذر',
        10 => 'دی',     11 => 'بهمن',    12 => 'اسفند'
    ];

    /**
     * Convert Gregorian date to Jalali array [year, month, day].
     */
    public static function fromGregorian(int $gy, int $gm, int $gd): array
    {
        $g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = 355666 + (365 * $gy) + (int)(($gy2 + 3) / 4) - (int)(($gy2 + 99) / 100) + (int)(($gy2 + 399) / 400) + $gd + $g_d_m[$gm - 1];
        $jy = -1595 + (33 * (int)($days / 12053));
        $days %= 12053;
        $jy += 4 * (int)($days / 1461);
        $days %= 1461;

        if ($days > 365) {
            $jy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }

        if ($days < 186) {
            $jm = 1 + (int)($days / 31);
            $jd = 1 + ($days % 31);
        } else {
            $jm = 7 + (int)(($days - 186) / 30);
            $jd = 1 + (($days - 186) % 30);
        }

        return [$jy, $jm, $jd];
    }

    /**
     * Format a DateTime object as Jalali string.
     */
    public static function format(?DateTimeInterface $date, string $format = 'Y/m/d'): string
    {
        if (!$date) return '';

        [$jy, $jm, $jd] = self::fromGregorian(
            (int)$date->format('Y'),
            (int)$date->format('n'),
            (int)$date->format('j')
        );

        if ($format === 'human') {
            $month = self::$monthNames[$jm] ?? '';
            return TextNormalizer::toPersianDigits("{$jd} {$month} {$jy}");
        }

        $formatted = sprintf('%04d/%02d/%02d', $jy, $jm, $jd);
        return TextNormalizer::toPersianDigits($formatted);
    }

    /**
     * Alias for formatting DateTime.
     */
    public static function fromDateTime(?DateTimeInterface $date, string $format = 'Y/m/d'): string
    {
        return self::format($date, $format);
    }
}
