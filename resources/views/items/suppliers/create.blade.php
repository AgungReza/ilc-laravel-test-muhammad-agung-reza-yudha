<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Tambah Supplier untuk {{ $item->name }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Tentukan supplier, harga beli, stok awal, dan stok minimum.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                @if ($suppliers->isEmpty())
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-5">
                        <h3 class="font-semibold text-amber-800">
                            Tidak Ada Supplier Tersedia
                        </h3>

                        <p class="mt-2 text-sm text-amber-700">
                            Semua supplier yang ada sudah terhubung dengan barang ini,
                            atau Anda belum memiliki data supplier sama sekali.
                        </p>

                        <a
                            href="{{ route('suppliers.create') }}"
                            class="mt-4 inline-flex rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-700"
                        >
                            Tambah Supplier Baru
                        </a>
                    </div>
                @else
                    <form
                        action="{{ route('items.suppliers.store', $item) }}"
                        method="POST"
                    >
                        @csrf

                        {{-- ================= SUPPLIER ================= --}}
                        <div>
                            <label for="supplier_id" class="block text-sm font-semibold text-slate-700">
                                Supplier
                            </label>

                            <select
                                id="supplier_id"
                                name="supplier_id"
                                required
                                class="mt-2 block w-full rounded-lg border-slate-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">-- Pilih Supplier --</option>

                                @foreach ($suppliers as $supplier)
                                    <option
                                        value="{{ $supplier->id }}"
                                        @selected(old('supplier_id') == $supplier->id)
                                    >
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('supplier_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ================= HARGA BELI ================= --}}
                        <div class="mt-6">
                            <label for="purchase_price" class="block text-sm font-semibold text-slate-700">
                                Harga Beli
                            </label>

                            <div class="mt-2 flex rounded-lg shadow-sm">
                                <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-4 text-sm font-semibold text-slate-600">
                                    Rp
                                </span>

                                <input
                                    id="purchase_price"
                                    name="purchase_price"
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    required
                                    autocomplete="off"
                                    value="{{ old('purchase_price') }}"
                                    placeholder="65000"
                                    class="block w-full rounded-r-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            @error('purchase_price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ================= STOK AWAL ================= --}}
                        <div class="mt-6">
                            <label for="stock" class="block text-sm font-semibold text-slate-700">
                                Stok Awal
                            </label>

                            <input
                                id="stock"
                                name="stock"
                                type="number"
                                min="0"
                                step="1"
                                required
                                autocomplete="off"
                                value="{{ old('stock', 0) }}"
                                class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('stock')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ================= STOK MINIMUM ================= --}}
                        <div class="mt-6">
                            <label for="minimum_stock" class="block text-sm font-semibold text-slate-700">
                                Stok Minimum
                            </label>

                            <input
                                id="minimum_stock"
                                name="minimum_stock"
                                type="number"
                                min="0"
                                step="1"
                                required
                                autocomplete="off"
                                value="{{ old('minimum_stock', 0) }}"
                                class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            <p class="mt-2 text-xs text-slate-500">
                                Sistem akan menandai stok sebagai "menipis" saat stok
                                mencapai atau berada di bawah angka ini.
                            </p>

                            @error('minimum_stock')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ================= BUTTON ================= --}}
                        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                            <a
                                href="{{ route('items.show', $item) }}"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                            >
                                Simpan Supplier
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
