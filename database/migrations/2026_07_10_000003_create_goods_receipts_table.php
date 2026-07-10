<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel header untuk transaksi Barang Masuk. Supplier TIDAK disimpan
     * di sini karena satu transaksi Barang Masuk bisa berisi barang dari
     * beberapa supplier berbeda (supplier dipilih per baris detail, lihat
     * tabel `goods_receipt_items`).
     */
    public function up(): void
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();

            // Format: BM-YYYYMMDD-NNN, dibuat otomatis oleh sistem.
            $table->string('transaction_number')->unique();

            $table->date('receipt_date');
            $table->text('notes')->nullable();

            // Siapa yang menginput transaksi ini. Nullable & set null saat
            // user dihapus, supaya riwayat transaksi tetap utuh.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
