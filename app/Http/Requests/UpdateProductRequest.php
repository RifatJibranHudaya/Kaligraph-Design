<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            'nama'        => 'required|string|max:100',
            'category_id' => 'nullable|integer|exists:categories,id',
            'harga_min'   => 'required|numeric|min:0|max:999999999999',
            'harga_max'   => 'nullable|numeric|min:0|max:999999999999',
            'deskripsi'   => 'nullable|string|max:5000',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'urutan'      => 'nullable|integer|min:0|max:9999',
            'stock'       => 'nullable|integer|min:0|max:999999',
            'sku'         => 'nullable|string|max:50|unique:products,sku,' . $productId,
            'tipe_produk' => 'nullable|string|in:custom_wa,ecommerce',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'      => 'Nama produk wajib diisi.',
            'harga_min.required' => 'Harga minimum wajib diisi.',
            'foto.image'         => 'File yang diupload harus berupa gambar.',
            'foto.mimes'         => 'Format foto harus JPEG, PNG, atau WebP.',
            'foto.max'           => 'Ukuran foto maksimal 3 MB.',
            'sku.unique'         => 'SKU sudah digunakan produk lain.',
        ];
    }
}
