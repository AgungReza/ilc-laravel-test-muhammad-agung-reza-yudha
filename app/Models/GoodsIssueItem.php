<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoodsIssueItem extends Model
{
    protected $fillable = [
        'goods_issue_id',
        'item_id',
        'supplier_id',
        'quantity',
        'selling_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'selling_price' => 'decimal:2',
        ];
    }

    public function goodsIssue(): BelongsTo
    {
        return $this->belongsTo(GoodsIssue::class);
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
     * Subtotal baris ini (quantity x selling_price), dihitung on-the-fly,
     * tidak disimpan sebagai kolom supaya tidak ada data yang bisa
     * out-of-sync.
     */
    public function getSubtotalAttribute(): string
    {
        return bcmul((string) $this->quantity, (string) $this->selling_price, 2);
    }
}
