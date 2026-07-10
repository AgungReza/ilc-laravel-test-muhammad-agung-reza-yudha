<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'unit',
        'price',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Supplier-supplier yang memasok barang ini, lengkap dengan
     * data pivot: harga beli, stok, dan stok minimum milik masing-masing supplier.
     */
    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class)
            ->using(ItemSupplier::class)
            ->withPivot(['purchase_price', 'stock', 'minimum_stock'])
            ->withTimestamps();
    }

    /**
     * Akses langsung ke baris pivot item_supplier milik barang ini.
     * Berguna untuk agregasi (mis. total stok lintas supplier).
     */
    public function itemSuppliers(): HasMany
    {
        return $this->hasMany(ItemSupplier::class);
    }
}
