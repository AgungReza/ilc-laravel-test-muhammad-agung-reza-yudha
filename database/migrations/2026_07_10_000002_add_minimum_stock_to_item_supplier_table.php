<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan ambang batas stok minimum per kombinasi barang-supplier,
     * dipakai untuk peringatan "stok menipis" di dashboard.
     */
    public function up(): void
    {
        Schema::table('item_supplier', function (Blueprint $table) {
            $table->unsignedInteger('minimum_stock')->default(0)->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_supplier', function (Blueprint $table) {
            $table->dropColumn('minimum_stock');
        });
    }
};
