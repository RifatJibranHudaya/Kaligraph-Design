<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'        => 'required|string|max:150',
            'category_id' => 'nullable|integer|exists:categories,id',
            'deskripsi'   => 'nullable|string|max:5000',
            'client'      => 'nullable|string|max:150',
            'lokasi'      => 'nullable|string|max:150',
            'tahun'       => 'nullable|string|max:10',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'urutan'      => 'nullable|integer|min:0|max:9999',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama portofolio wajib diisi.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus JPEG, PNG, atau WebP.',
            'foto.max'      => 'Ukuran foto maksimal 3 MB.',
        ];
    }
}
