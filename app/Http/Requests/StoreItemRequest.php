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
     *
     * Hanya berisi data Master Barang. Supplier, harga beli, dan stok
     * dikelola terpisah melalui ItemSupplierController.
     */
    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:items,code',
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'unit' => [
                'required',
                'string',
                'max:20',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'description' => [
                'nullable',
                'string',
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

            'code.required' => 'Kode barang wajib diisi.',
            'code.string' => 'Kode barang harus berupa teks.',
            'code.max' => 'Kode barang maksimal 50 karakter.',
            'code.unique' => 'Kode barang sudah digunakan oleh barang lain.',

            'name.required' => 'Nama barang wajib diisi.',
            'name.string' => 'Nama barang harus berupa teks.',
            'name.max' => 'Nama barang maksimal 150 karakter.',

            'unit.required' => 'Satuan barang wajib diisi.',
            'unit.string' => 'Satuan barang harus berupa teks.',
            'unit.max' => 'Satuan barang maksimal 20 karakter.',

            'price.required' => 'Harga jual wajib diisi.',
            'price.numeric' => 'Harga jual harus berupa angka.',
            'price.min' => 'Harga jual tidak boleh kurang dari 0.',

            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
