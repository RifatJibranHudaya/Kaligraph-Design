<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'      => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:2000',
            'emoji'     => 'nullable|string|max:10',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'urutan'    => 'nullable|integer|min:0|max:9999',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kategori wajib diisi.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus JPEG, PNG, atau WebP.',
            'foto.max'      => 'Ukuran foto maksimal 3 MB.',
        ];
    }
}
