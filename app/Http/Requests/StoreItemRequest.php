<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'supplier_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'supplier_ids.*' => [
                'required',
                'integer',
                'exists:suppliers,id',
                'distinct',
            ],
        ];
    }

    /**
     * Custom Validation Messages
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori barang wajib dipilih.',
            'category_id.integer' => 'Kategori barang tidak valid.',
            'category_id.exists' => 'Kategori yang dipilih tidak tersedia.',

            'name.required' => 'Nama barang wajib diisi.',
            'name.string' => 'Nama barang harus berupa teks.',
            'name.max' => 'Nama barang maksimal 150 karakter.',

            'price.required' => 'Harga barang wajib diisi.',
            'price.numeric' => 'Harga barang harus berupa angka.',
            'price.min' => 'Harga barang tidak boleh kurang dari 0.',

            'stock.required' => 'Stok barang wajib diisi.',
            'stock.integer' => 'Stok barang harus berupa angka bulat.',
            'stock.min' => 'Stok barang tidak boleh kurang dari 0.',

            'supplier_ids.required' => 'Supplier wajib dipilih.',
            'supplier_ids.array' => 'Data supplier tidak valid.',
            'supplier_ids.min' => 'Pilih minimal satu supplier.',

            'supplier_ids.*.required' => 'Supplier wajib dipilih.',
            'supplier_ids.*.integer' => 'Supplier tidak valid.',
            'supplier_ids.*.exists' => 'Supplier yang dipilih tidak ditemukan.',
            'supplier_ids.*.distinct' => 'Supplier tidak boleh dipilih lebih dari satu kali.',
        ];
    }
}
