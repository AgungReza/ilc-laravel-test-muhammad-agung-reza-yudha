<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodsIssue extends Model
{
    protected $fillable = [
        'transaction_number',
        'issue_date',
        'notes',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
        ];
    }

    /**
     * User yang menginput transaksi Barang Keluar ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Baris-baris detail barang yang dikeluarkan pada transaksi ini.
     */
    public function items(): HasMany
    {
        return $this->hasMany(GoodsIssueItem::class);
    }
}
