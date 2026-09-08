<?php

namespace App\Helpers;

class FormatHelper
{
    /**
     * Format currency value as Rupiah (e.g. Rp 50.000).
     */
    public static function rupiah(mixed $amount, bool $withSymbol = true): string
    {
        $num = (float)($amount ?? 0);
        $formatted = number_format($num, 0, ',', '.');
        return $withSymbol ? 'Rp ' . $formatted : $formatted;
    }

    /**
     * Format date into readable Indonesian format.
     */
    public static function dateIndo(mixed $date, bool $withTime = false): string
    {
        if (!$date) return '-';
        $timestamp = is_numeric($date) ? (int)$date : strtotime($date);
        if (!$timestamp) return '-';

        $months = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $d = date('d', $timestamp);
        $m = $months[(int)date('n', $timestamp)];
        $y = date('Y', $timestamp);

        $res = "$d $m $y";
        if ($withTime) {
            $res .= ' ' . date('H:i', $timestamp);
        }
        return $res;
    }

    /**
     * Return badge class based on role/level.
     */
    public static function levelBadgeClass(string $level): string
    {
        return match (strtolower($level)) {
            'superadmin' => 'bg-danger text-white',
            'owner'      => 'bg-purple text-white',
            'admin'      => 'bg-primary text-white',
            'kasir'      => 'bg-success text-white',
            'customer'   => 'bg-info text-white',
            default      => 'bg-secondary text-white',
        };
    }
}
