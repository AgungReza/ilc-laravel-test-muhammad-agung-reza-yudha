<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
}
