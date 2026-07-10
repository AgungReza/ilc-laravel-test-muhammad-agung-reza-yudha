<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    /**
     * Barang-barang yang dipasok oleh supplier ini, lengkap dengan
     * data pivot: harga beli, stok, dan stok minimum untuk barang tersebut.
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)
            ->using(ItemSupplier::class)
            ->withPivot(['purchase_price', 'stock', 'minimum_stock'])
            ->withTimestamps();
    }

    /**
     * Akses langsung ke baris pivot item_supplier milik supplier ini.
     */
    public function itemSupplies(): HasMany
    {
        return $this->hasMany(ItemSupplier::class);
    }
}
