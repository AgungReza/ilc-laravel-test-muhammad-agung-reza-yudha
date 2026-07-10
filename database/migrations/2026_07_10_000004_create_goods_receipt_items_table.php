<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel detail Barang Masuk. Setiap baris mewakili satu barang yang
     * diterima dari satu supplier tertentu, sehingga stok yang bertambah
     * di `item_supplier` benar-benar milik supplier yang dipilih di baris ini.
     *
     * `purchase_price` adalah snapshot harga beli SAAT transaksi ini terjadi
     * (riwayat), dan sengaja tidak otomatis menimpa `item_supplier.purchase_price`.
     */
    public function up(): void
    {
        Schema::create('goods_receipt_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('goods_receipt_id')
                ->constrained()
                ->cascadeOnDelete();

            // Barang & supplier tidak boleh dihapus selama masih punya
            // riwayat transaksi, supaya data historis tetap valid.
            $table->foreignId('item_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('supplier_id')
                ->constrained()
                ->restrictOnDelete();

            $table->unsignedInteger('quantity');
            $table->decimal('purchase_price', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_items');
    }
};
