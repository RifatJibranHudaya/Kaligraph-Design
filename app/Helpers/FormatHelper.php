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

    /**
     * Clean and format phone number for WhatsApp international standard (e.g. 6281234567890).
     */
    public static function cleanWhatsappNumber(?string $phone): string
    {
        if (empty($phone)) {
            return '6281234567890';
        }

        $clean = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        } elseif (str_starts_with($clean, '8')) {
            $clean = '62' . $clean;
        }

        return $clean ?: '6281234567890';
    }

    /**
     * Get the active WhatsApp number from dynamic settings.
     */
    public static function whatsappNumber(): string
    {
        $saved = \App\Models\Setting::get('whatsapp_number', '6281234567890');
        return self::cleanWhatsappNumber($saved);
    }

    /**
     * Generate dynamic WhatsApp chat link with optional prefilled message.
     */
    public static function whatsappUrl(?string $message = null): string
    {
        $number = self::whatsappNumber();
        $defaultMsg = \App\Models\Setting::get('whatsapp_default_message', 'Halo Kaligraph Design, saya ingin konsultasi pesanan neon box & signage.');
        $text = $message !== null ? $message : $defaultMsg;

        return 'https://wa.me/' . $number . '?text=' . urlencode($text);
    }
}
