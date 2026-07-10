<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menyesuaikan tabel `items` agar benar-benar menjadi Master Barang:
     * - Menambahkan kode barang, satuan, dan deskripsi.
     * - Menghapus kolom `stock`, karena stok adalah milik supplier
     *   (disimpan di tabel pivot `item_supplier`), bukan milik barang.
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('code')->after('id');
            $table->string('unit')->after('name');
            $table->text('description')->nullable()->after('price');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->unique('code');
            $table->dropColumn('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('stock')->default(0)->after('price');
            $table->dropUnique(['code']);
            $table->dropColumn(['code', 'unit', 'description']);
        });
    }
};
