<?php

namespace App\Http\Controllers;

use App\Helpers\FormatHelper;
use App\Models\Setting;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show WhatsApp Contact Settings page.
     */
    public function whatsapp()
    {
        $waNumber = Setting::get('whatsapp_number', '6281234567890');
        $waDefaultMsg = Setting::get('whatsapp_default_message', 'Halo Kaligraph Design, saya ingin konsultasi pesanan neon box & signage.');
        $formattedWa = FormatHelper::whatsappNumber();

        return view('settings.whatsapp', compact('waNumber', 'waDefaultMsg', 'formattedWa'));
    }

    /**
     * Update WhatsApp Contact Settings.
     */
    public function updateWhatsapp(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_number'          => 'required|string|max:30',
            'whatsapp_default_message' => 'nullable|string|max:500',
        ], [
            'whatsapp_number.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        $cleanNumber = FormatHelper::cleanWhatsappNumber($validated['whatsapp_number']);

        Setting::set('whatsapp_number', $cleanNumber, 'contact', 'Nomor WhatsApp Utama untuk seluruh tombol kontak & konsultasi');

        if (isset($validated['whatsapp_default_message'])) {
            Setting::set('whatsapp_default_message', $validated['whatsapp_default_message'], 'contact', 'Pesan default konsultasi WhatsApp');
        }

        ActivityLogService::log(
            'update_whatsapp_setting',
            'settings',
            "Nomor WhatsApp diperbarui menjadi {$cleanNumber}"
        );

        return back()->with('success', "Nomor WhatsApp berhasil diperbarui menjadi {$cleanNumber} untuk seluruh tombol modul.");
    }
}
