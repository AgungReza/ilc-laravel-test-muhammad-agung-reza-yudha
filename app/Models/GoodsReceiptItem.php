<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoodsReceiptItem extends Model
{
    protected $fillable = [
        'goods_receipt_id',
        'item_id',
        'supplier_id',
        'quantity',
        'purchase_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'purchase_price' => 'decimal:2',
        ];
    }

    public function goodsReceipt(): BelongsTo
    {
        return $this->belongsTo(GoodsReceipt::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Subtotal baris ini (quantity x purchase_price), dihitung on-the-fly,
     * tidak disimpan sebagai kolom supaya tidak ada data yang bisa
     * out-of-sync.
     */
    public function getSubtotalAttribute(): string
    {
        return bcmul((string) $this->quantity, (string) $this->purchase_price, 2);
    }
}
