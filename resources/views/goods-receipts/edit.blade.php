<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Edit Barang Masuk
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ $goodsReceipt->transaction_number }}
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div
                x-data="goodsReceiptForm({
                    items: @js($items->map(fn ($item) => [
                        'id' => $item->id,
                        'code' => $item->code,
                        'name' => $item->name,
                        'unit' => $item->unit,
                    ])),
                    suppliers: @js($suppliers->map(fn ($supplier) => [
                        'id' => $supplier->id,
                        'name' => $supplier->name,
                    ])),
                    existingPrices: @js($existingPrices),
                    initialLines: @js(old('items', $goodsReceipt->items->map(fn ($line) => [
                        'item_id' => $line->item_id,
                        'supplier_id' => $line->supplier_id,
                        'quantity' => $line->quantity,
                        'purchase_price' => $line->purchase_price,
                    ])->all())),
                })"
            >
                <form action="{{ route('goods-receipts.update', $goodsReceipt) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                        {{-- ================= TANGGAL & CATATAN ================= --}}
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            <div>
                                <label for="receipt_date" class="block text-sm font-semibold text-slate-700">
                                    Tanggal Transaksi
                                </label>

                                <input
                                    id="receipt_date"
                                    name="receipt_date"
                                    type="date"
                                    required
                                    value="{{ old('receipt_date', $goodsReceipt->receipt_date->toDateString()) }}"
                                    class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                @error('receipt_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-semibold text-slate-700">
                                    Catatan <span class="font-normal text-slate-400">(opsional)</span>
                                </label>

                                <input
                                    id="notes"
                                    name="notes"
                                    type="text"
                                    value="{{ old('notes', $goodsReceipt->notes) }}"
                                    placeholder="Contoh : No. Surat Jalan"
                                    class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                @error('notes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- ================= ERROR UMUM (mis. duplikat baris / stok negatif) ================= --}}
                        @error('items')
                            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                                {{ $message }}
                            </div>
                        @enderror

                        {{-- ================= BARIS DETAIL BARANG ================= --}}
                        <div class="mt-8">

                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">
                                    Daftar Barang Diterima
                                </h3>

                                <button
                                    type="button"
                                    @click="addLine()"
                                    class="inline-flex items-center gap-1 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100"
                                >
                                    + Tambah Baris
                                </button>
                            </div>

                            <div class="mt-4 space-y-4">

                                <template x-for="(line, index) in lines" :key="line.key">
                                    <div class="rounded-xl border border-slate-200 p-4">

                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-12">

                                            {{-- Barang --}}
                                            <div class="sm:col-span-4">
                                                <label class="block text-xs font-semibold text-slate-600">Barang</label>

                                                <select
                                                    :name="'items[' + index + '][item_id]'"
                                                    x-model="line.item_id"
                                                    @change="autofillPrice(line)"
                                                    required
                                                    class="mt-1 block w-full rounded-lg border-slate-300 bg-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                >
                                                    <option value="">-- Pilih Barang --</option>
                                                    <template x-for="item in items" :key="item.id">
                                                        <option :value="item.id" x-text="item.code + ' - ' + item.name" :selected="line.item_id == item.id"></option>
                                                    </template>
                                                </select>
                                            </div>

                                            {{-- Supplier --}}
                                            <div class="sm:col-span-3">
                                                <label class="block text-xs font-semibold text-slate-600">Supplier</label>

                                                <select
                                                    :name="'items[' + index + '][supplier_id]'"
                                                    x-model="line.supplier_id"
                                                    @change="autofillPrice(line)"
                                                    required
                                                    class="mt-1 block w-full rounded-lg border-slate-300 bg-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                >
                                                    <option value="">-- Pilih Supplier --</option>
                                                    <template x-for="supplier in suppliers" :key="supplier.id">
                                                        <option :value="supplier.id" x-text="supplier.name" :selected="line.supplier_id == supplier.id"></option>
                                                    </template>
                                                </select>
                                            </div>

                                            {{-- Qty --}}
                                            <div class="sm:col-span-2">
                                                <label class="block text-xs font-semibold text-slate-600">Qty</label>

                                                <input
                                                    type="number"
                                                    min="1"
                                                    step="1"
                                                    :name="'items[' + index + '][quantity]'"
                                                    x-model.number="line.quantity"
                                                    required
                                                    class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                >
                                            </div>

                                            {{-- Harga Beli --}}
                                            <div class="sm:col-span-2">
                                                <label class="block text-xs font-semibold text-slate-600">Harga Beli</label>

                                                <input
                                                    type="number"
                                                    min="0"
                                                    step="0.01"
                                                    :name="'items[' + index + '][purchase_price]'"
                                                    x-model.number="line.purchase_price"
                                                    required
                                                    class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                >
                                            </div>

                                            {{-- Hapus --}}
                                            <div class="flex items-end justify-end sm:col-span-1">
                                                <button
                                                    type="button"
                                                    @click="removeLine(index)"
                                                    x-show="lines.length > 1"
                                                    class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100"
                                                >
                                                    Hapus
                                                </button>
                                            </div>

                                        </div>

                                        <p
                                            x-show="isDuplicate(line)"
                                            class="mt-2 text-xs font-medium text-red-600"
                                        >
                                            Kombinasi barang &amp; supplier ini sudah dipakai di baris lain.
                                        </p>

                                    </div>
                                </template>

                            </div>

                        </div>

                        {{-- ================= INFO PERINGATAN ================= --}}
                        <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                            Mengubah baris di sini akan membatalkan stok lama dan menerapkan
                            stok baru. Kalau stok dari transaksi ini sudah terlanjur
                            dipakai di Barang Keluar, perubahan yang membuat stok jadi
                            negatif akan ditolak.
                        </div>

                        {{-- ================= BUTTON ================= --}}
                        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                            <a
                                href="{{ route('goods-receipts.index') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                            >
                                Simpan Perubahan
                            </button>

                        </div>

                    </div>

                </form>
            </div>

        </div>
    </div>

    @once
        <script>
            function goodsReceiptForm(config) {
                let lineKey = 0;

                const makeLine = (line = {}) => ({
                    key: lineKey++,
                    item_id: line.item_id ?? '',
                    supplier_id: line.supplier_id ?? '',
                    quantity: line.quantity ?? 1,
                    purchase_price: line.purchase_price ?? '',
                });

                return {
                    items: config.items ?? [],
                    suppliers: config.suppliers ?? [],
                    existingPrices: config.existingPrices ?? {},
                    lines: (config.initialLines && config.initialLines.length)
                        ? config.initialLines.map(makeLine)
                        : [makeLine()],

                    addLine() {
                        this.lines.push(makeLine());
                    },

                    removeLine(index) {
                        this.lines.splice(index, 1);
                    },

                    autofillPrice(line) {
                        if (!line.item_id || !line.supplier_id) {
                            return;
                        }

                        const price = this.existingPrices[line.item_id + '-' + line.supplier_id];

                        if (price !== undefined) {
                            line.purchase_price = price;
                        }
                    },

                    isDuplicate(line) {
                        if (!line.item_id || !line.supplier_id) {
                            return false;
                        }

                        return this.lines.filter(
                            (other) => other.item_id == line.item_id && other.supplier_id == line.supplier_id
                        ).length > 1;
                    },
                };
            }
        </script>
    @endonce
</x-app-layout>
