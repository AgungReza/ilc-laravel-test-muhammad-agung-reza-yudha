<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                Catat Barang Keluar
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Nomor transaksi akan dibuat otomatis oleh sistem.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            @if($items->isEmpty())

                <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 p-6 shadow-sm sm:p-8">
                    <div class="rounded-xl border border-amber-200 bg-amber-50 dark:bg-amber-900/30 p-5">
                        <h3 class="font-semibold text-amber-800 dark:text-amber-300">
                            Data Belum Lengkap
                        </h3>

                        <p class="mt-2 text-sm text-amber-700 dark:text-amber-300">
                            Pastikan sudah ada minimal 1 Barang sebelum mencatat
                            Barang Keluar.
                        </p>
                    </div>
                </div>

            @else

                <div
                    x-data="goodsIssueForm({
                        items: @js($items->map(fn ($item) => [
                            'id' => $item->id,
                            'code' => $item->code,
                            'name' => $item->name,
                            'unit' => $item->unit,
                            'price' => $item->price,
                        ])),
                        itemSuppliers: @js($itemSuppliers),
                        initialLines: @js(old('items')),
                    })"
                >
                    <form action="{{ route('goods-issues.store') }}" method="POST">
                        @csrf

                        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 p-6 shadow-sm sm:p-8">

                            {{-- ================= TANGGAL & CATATAN ================= --}}
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                                <div>
                                    <label for="issue_date" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                        Tanggal Transaksi
                                    </label>

                                    <input
                                        id="issue_date"
                                        name="issue_date"
                                        type="date"
                                        required
                                        value="{{ old('issue_date', now()->toDateString()) }}"
                                        class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >

                                    @error('issue_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                        Catatan <span class="font-normal text-slate-400 dark:text-slate-500">(opsional)</span>
                                    </label>

                                    <input
                                        id="notes"
                                        name="notes"
                                        type="text"
                                        value="{{ old('notes') }}"
                                        placeholder="Contoh : Nama pelanggan / No. Nota"
                                        class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >

                                    @error('notes')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            {{-- ================= ERROR UMUM (mis. stok tidak cukup / duplikat baris) ================= --}}
                            @error('items')
                                <div class="mt-6 rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/30 px-4 py-3 text-sm font-medium text-red-700 dark:text-red-300">
                                    {{ $message }}
                                </div>
                            @enderror

                            {{-- ================= BARIS DETAIL BARANG ================= --}}
                            <div class="mt-8">

                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Daftar Barang Keluar
                                    </h3>

                                    <button
                                        type="button"
                                        @click="addLine()"
                                        class="inline-flex items-center gap-1 rounded-lg border border-indigo-200 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-2 text-xs font-semibold text-indigo-700 dark:text-indigo-300 transition hover:bg-indigo-100"
                                    >
                                        + Tambah Baris
                                    </button>
                                </div>

                                <div class="mt-4 space-y-4">

                                    <template x-for="(line, index) in lines" :key="line.key">
                                        <div class="rounded-xl border border-slate-200 dark:border-slate-700 p-4">

                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-12">

                                                {{-- Barang --}}
                                                <div class="sm:col-span-4">
                                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-300">Barang</label>

                                                    <select
                                                        :name="'items[' + index + '][item_id]'"
                                                        x-model="line.item_id"
                                                        @change="onItemChange(line)"
                                                        required
                                                        class="mt-1 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-sm text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    >
                                                        <option value="" class="text-slate-400 dark:bg-gray-800 dark:text-slate-300">-- Pilih Barang --</option>
                                                        <template x-for="item in items" :key="item.id">
                                                            <option :value="item.id" x-text="item.code + ' - ' + item.name" :selected="line.item_id == item.id" class="dark:bg-gray-800 dark:text-white"></option>
                                                        </template>
                                                    </select>
                                                </div>

                                                {{-- Supplier --}}
                                                <div class="sm:col-span-3">
                                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-300">
                                                        Supplier
                                                        <span
                                                            x-show="stockFor(line) !== null"
                                                            class="font-normal text-slate-400 dark:text-slate-500"
                                                        >
                                                            (stok: <span x-text="stockFor(line)"></span>)
                                                        </span>
                                                    </label>

                                                    <select
                                                        :name="'items[' + index + '][supplier_id]'"
                                                        x-model="line.supplier_id"
                                                        required
                                                        class="mt-1 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-sm text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    >
                                                        <option value="" class="text-slate-400 dark:bg-gray-800 dark:text-slate-300">-- Pilih Supplier --</option>
                                                        <template x-for="supplier in availableSuppliers(line)" :key="supplier.id">
                                                            <option
                                                                :value="supplier.id"
                                                                x-text="supplier.name + ' (stok: ' + supplier.stock + ')'"
                                                                :selected="line.supplier_id == supplier.id"
                                                                class="dark:bg-gray-800 dark:text-white"
                                                            ></option>
                                                        </template>
                                                    </select>

                                                    <p
                                                        x-show="line.item_id && availableSuppliers(line).length === 0"
                                                        class="mt-1 text-xs font-medium text-red-600"
                                                    >
                                                        Barang ini belum punya stok dari supplier manapun.
                                                    </p>
                                                </div>

                                                {{-- Qty --}}
                                                <div class="sm:col-span-2">
                                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-300">Qty</label>

                                                    <input
                                                        type="number"
                                                        min="1"
                                                        step="1"
                                                        :name="'items[' + index + '][quantity]'"
                                                        x-model.number="line.quantity"
                                                        required
                                                        class="mt-1 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-sm text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    >
                                                </div>

                                                {{-- Harga Jual --}}
                                                <div class="sm:col-span-2">
                                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-300">Harga Jual</label>

                                                    <input
                                                        type="number"
                                                        min="0"
                                                        step="0.01"
                                                        :name="'items[' + index + '][selling_price]'"
                                                        x-model.number="line.selling_price"
                                                        required
                                                        class="mt-1 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-sm text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    >
                                                </div>

                                                {{-- Hapus --}}
                                                <div class="flex items-end justify-end sm:col-span-1">
                                                    <button
                                                        type="button"
                                                        @click="removeLine(index)"
                                                        x-show="lines.length > 1"
                                                        class="rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/30 px-3 py-2 text-xs font-semibold text-red-700 dark:text-red-300 transition hover:bg-red-100"
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

                                            <p
                                                x-show="exceedsStock(line)"
                                                class="mt-2 text-xs font-medium text-red-600"
                                            >
                                                Jumlah melebihi stok yang tersedia dari supplier ini.
                                            </p>

                                        </div>
                                    </template>

                                </div>

                            </div>

                            {{-- ================= BUTTON ================= --}}
                            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 dark:border-slate-700 pt-6 sm:flex-row sm:justify-end">

                                <a
                                    href="{{ route('goods-issues.index') }}"
                                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-600 px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 transition hover:bg-slate-50"
                                >
                                    Batal
                                </a>

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                >
                                    Simpan Barang Keluar
                                </button>

                            </div>

                        </div>

                    </form>
                </div>

            @endif

        </div>
    </div>

    @once
        <script>
            function goodsIssueForm(config) {
                let lineKey = 0;

                const makeLine = (line = {}) => ({
                    key: lineKey++,
                    item_id: line.item_id ?? '',
                    supplier_id: line.supplier_id ?? '',
                    quantity: line.quantity ?? 1,
                    selling_price: line.selling_price ?? '',
                });

                return {
                    items: config.items ?? [],
                    itemSuppliers: config.itemSuppliers ?? {},
                    lines: (config.initialLines && config.initialLines.length)
                        ? config.initialLines.map(makeLine)
                        : [makeLine()],

                    addLine() {
                        this.lines.push(makeLine());
                    },

                    removeLine(index) {
                        this.lines.splice(index, 1);
                    },

                    onItemChange(line) {
                        line.supplier_id = '';

                        const item = this.items.find((i) => i.id == line.item_id);

                        if (item) {
                            line.selling_price = item.price;
                        }
                    },

                    availableSuppliers(line) {
                        if (!line.item_id) {
                            return [];
                        }

                        return this.itemSuppliers[line.item_id] ?? [];
                    },

                    stockFor(line) {
                        if (!line.item_id || !line.supplier_id) {
                            return null;
                        }

                        const supplier = this.availableSuppliers(line)
                            .find((s) => s.id == line.supplier_id);

                        return supplier ? supplier.stock : null;
                    },

                    exceedsStock(line) {
                        const stock = this.stockFor(line);

                        return stock !== null && Number(line.quantity) > stock;
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