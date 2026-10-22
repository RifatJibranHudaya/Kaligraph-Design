<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     * Strip thousand separators from jumlah before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('jumlah') && is_string($this->jumlah)) {
            $cleaned = preg_replace('/[^\d]/', '', $this->jumlah);
            $this->merge(['jumlah' => $cleaned !== '' ? $cleaned : 0]);
        }
    }

    public function rules(): array
    {
        return [
            'order_id'      => 'required|integer|exists:orders,id',
            'jumlah'        => 'required|numeric|min:1|max:999999999999',
            'metode'        => 'required|string|in:cash,transfer,dp',
            'bukti'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'keterangan'    => 'nullable|string|max:1000',
            'tanggal_bayar' => 'required|date|before_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required'           => 'Pilih order terkait.',
            'order_id.exists'             => 'Order yang dipilih tidak ditemukan.',
            'jumlah.required'             => 'Jumlah pembayaran wajib diisi.',
            'jumlah.min'                  => 'Jumlah pembayaran minimal Rp 1.',
            'jumlah.max'                  => 'Jumlah pembayaran melebihi batas maksimal.',
            'metode.in'                   => 'Metode pembayaran tidak valid.',
            'tanggal_bayar.required'      => 'Tanggal bayar wajib diisi.',
            'tanggal_bayar.before_or_equal' => 'Tanggal bayar tidak boleh di masa depan.',
            'bukti.image'                 => 'File bukti harus berupa gambar.',
            'bukti.mimes'                 => 'Format bukti harus JPEG, PNG, atau WebP.',
            'bukti.max'                   => 'Ukuran gambar upload maksimal 3 MB.',
        ];
    }
}
