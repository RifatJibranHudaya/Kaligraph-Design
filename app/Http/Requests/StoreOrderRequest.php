<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     * Strip thousand separators from total before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('total')) {
            $raw = preg_replace('/[^\d]/', '', (string) $this->input('total'));
            $this->merge(['total' => $raw !== '' ? $raw : 0]);
        }
    }

    public function rules(): array
    {
        return [
            'nama_pelanggan' => 'required|string|max:150',
            'no_hp'          => 'nullable|string|max:20|regex:/^[0-9\+\-\s\(\)]*$/',
            'alamat'         => 'nullable|string|max:500',
            'kategori'       => 'nullable|string|max:100',
            'total'          => 'required|numeric|min:0|max:999999999999',
            'keterangan'     => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'nama_pelanggan.max'      => 'Nama pelanggan maksimal 150 karakter.',
            'no_hp.regex'             => 'Format nomor HP tidak valid.',
            'total.required'          => 'Total harga wajib diisi.',
            'total.numeric'           => 'Total harga harus berupa angka.',
            'total.max'               => 'Total harga melebihi batas maksimal.',
        ];
    }
}
