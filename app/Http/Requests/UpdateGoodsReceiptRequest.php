<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateGoodsReceiptRequest extends FormRequest
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
     * transaction_number tidak bisa diubah lewat form ini -- nomor
     * transaksi bersifat permanen sejak dibuat.
     */
    public function rules(): array
    {
        return [
            'receipt_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.item_id' => [
                'required',
                'integer',
                'exists:items,id',
            ],

            'items.*.supplier_id' => [
                'required',
                'integer',
                'exists:suppliers,id',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }

    /**
     * Custom Validation Messages
     */
    public function messages(): array
    {
        return [
            'receipt_date.required' => 'Tanggal transaksi wajib diisi.',
            'receipt_date.date' => 'Tanggal transaksi tidak valid.',

            'notes.max' => 'Catatan maksimal 1000 karakter.',

            'items.required' => 'Minimal harus ada 1 baris barang.',
            'items.array' => 'Data barang tidak valid.',
            'items.min' => 'Minimal harus ada 1 baris barang.',

            'items.*.item_id.required' => 'Barang wajib dipilih.',
            'items.*.item_id.exists' => 'Barang yang dipilih tidak ditemukan.',

            'items.*.supplier_id.required' => 'Supplier wajib dipilih.',
            'items.*.supplier_id.exists' => 'Supplier yang dipilih tidak ditemukan.',

            'items.*.quantity.required' => 'Jumlah wajib diisi.',
            'items.*.quantity.integer' => 'Jumlah harus berupa angka bulat.',
            'items.*.quantity.min' => 'Jumlah minimal 1.',

            'items.*.purchase_price.required' => 'Harga beli wajib diisi.',
            'items.*.purchase_price.numeric' => 'Harga beli harus berupa angka.',
            'items.*.purchase_price.min' => 'Harga beli tidak boleh kurang dari 0.',
        ];
    }

    /**
     * Validasi tambahan: tidak boleh ada baris dengan kombinasi
     * barang + supplier yang sama dalam satu transaksi.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $lines = collect($this->input('items', []));

            $duplicates = $lines
                ->map(fn (array $line) => ($line['item_id'] ?? '') . '-' . ($line['supplier_id'] ?? ''))
                ->duplicates();

            if ($duplicates->isNotEmpty()) {
                $validator->errors()->add(
                    'items',
                    'Tidak boleh ada kombinasi barang dan supplier yang sama dalam satu transaksi. Gabungkan menjadi satu baris.'
                );
            }
        });
    }
}
