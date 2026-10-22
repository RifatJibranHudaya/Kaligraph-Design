<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bukti' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ];
    }

    public function messages(): array
    {
        return [
            'bukti.required' => 'File bukti pembayaran wajib diunggah.',
            'bukti.image'    => 'File bukti harus berupa gambar.',
            'bukti.mimes'    => 'Format bukti harus JPEG, PNG, atau WebP.',
            'bukti.max'      => 'Ukuran gambar maksimal 3 MB.',
        ];
    }
}
