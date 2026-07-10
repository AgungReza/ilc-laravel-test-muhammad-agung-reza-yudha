<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel detail Barang Keluar. Setiap baris mewakili satu barang yang
     * dikeluarkan dari satu supplier tertentu -- supplier di sini menentukan
     * stok siapa (kombinasi item+supplier di `item_supplier`) yang berkurang.
     *
     * `selling_price` adalah snapshot harga jual SAAT transaksi ini terjadi
     * (riwayat), diambil dari harga jual master barang, tapi tidak mengikat
     * balik ke master supaya harga jual di transaksi lama tidak berubah
     * kalau harga jual master diperbarui di kemudian hari.
     */
    public function up(): void
    {
        Schema::create('goods_issue_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('goods_issue_id')
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
            $table->decimal('selling_price', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_issue_items');
    }
};
