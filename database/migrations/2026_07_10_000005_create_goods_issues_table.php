<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel header untuk transaksi Barang Keluar. Sama seperti
     * `goods_receipts`, supplier TIDAK disimpan di sini karena supplier
     * dipilih per baris detail (lihat `goods_issue_items`) -- satu
     * transaksi Barang Keluar bisa mengeluarkan barang dari beberapa
     * supplier berbeda sekaligus.
     */
    public function up(): void
    {
        Schema::create('goods_issues', function (Blueprint $table) {
            $table->id();

            // Format: BK-YYYYMMDD-NNN, dibuat otomatis oleh sistem.
            $table->string('transaction_number')->unique();

            $table->date('issue_date');
            $table->text('notes')->nullable();

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
        Schema::dropIfExists('goods_issues');
    }
};
