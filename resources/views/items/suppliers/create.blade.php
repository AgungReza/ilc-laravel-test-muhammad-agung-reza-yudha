<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                Tambah Supplier untuk {{ $item->name }}
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Tentukan supplier, harga beli, stok awal, dan stok minimum.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 p-6 shadow-sm sm:p-8">

                @if ($suppliers->isEmpty())
                    <div class="rounded-xl border border-amber-200 bg-amber-50 dark:bg-amber-900/30 p-5">
                        <h3 class="font-semibold text-amber-800 dark:text-amber-300">
                            Tidak Ada Supplier Tersedia
                        </h3>

                        <p class="mt-2 text-sm text-amber-700 dark:text-amber-300">
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

                        {{-- ================= SUPPLIER (Custom Dropdown Alpine.js) ================= --}}
                        <div
                            class="relative"
                            x-data="{
                                open: false,
                                selectedId: '{{ old('supplier_id') }}',
                                selectedName: '',
                                suppliers: {{ $suppliers->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->values() }},
                                init() {
                                    const found = this.suppliers.find(s => s.id == this.selectedId);
                                    this.selectedName = found ? found.name : '';
                                },
                                select(supplier) {
                                    this.selectedId = supplier.id;
                                    this.selectedName = supplier.name;
                                    this.open = false;
                                }
                            }"
                        >
                            <label for="supplier_id_button" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                Supplier
                            </label>

                            {{-- hidden input, ini yang dikirim ke server sebagai supplier_id --}}
                            <input type="hidden" name="supplier_id" :value="selectedId">

                            {{-- tombol trigger dropdown, menggantikan <select> native --}}
                            <button
                                id="supplier_id_button"
                                type="button"
                                @click="open = !open"
                                @click.outside="open = false"
                                class="mt-2 flex w-full items-center justify-between rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 px-3 py-2 text-left shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                            >
                                {{-- teks petunjuk "-- Pilih Supplier --" sekarang PASTI putih di dark mode --}}
                                <span
                                    x-text="selectedName || '-- Pilih Supplier --'"
                                    :class="selectedName ? 'text-slate-900 dark:text-white' : 'text-slate-400 dark:text-slate-300'"
                                ></span>

                                <svg
                                    class="h-4 w-4 text-slate-400 transition-transform"
                                    :class="{ 'rotate-180': open }"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- daftar pilihan supplier --}}
                            <div
                                x-show="open"
                                x-transition
                                class="absolute z-10 mt-1 w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-gray-800 shadow-lg"
                                style="display: none;"
                            >
                                <ul class="max-h-60 overflow-auto py-1 text-sm">
                                    <template x-for="supplier in suppliers" :key="supplier.id">
                                        <li
                                            @click="select(supplier)"
                                            class="cursor-pointer px-3 py-2 text-slate-900 dark:text-white hover:bg-indigo-50 dark:hover:bg-gray-700"
                                            x-text="supplier.name"
                                        ></li>
                                    </template>
                                </ul>
                            </div>

                            @error('supplier_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ================= HARGA BELI ================= --}}
                        <div class="mt-6">
                            <label for="purchase_price" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                Harga Beli
                            </label>

                            <div class="mt-2 flex rounded-lg shadow-sm">
                                <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-gray-900/40 px-4 text-sm font-semibold text-slate-600 dark:text-slate-300">
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
                                    class="block w-full rounded-r-lg border-slate-300 dark:border-slate-600 focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            @error('purchase_price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ================= STOK AWAL ================= --}}
                        <div class="mt-6">
                            <label for="stock" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
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
                                class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('stock')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ================= STOK MINIMUM ================= --}}
                        <div class="mt-6">
                            <label for="minimum_stock" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
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
                                class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
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
                                class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-600 px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 transition hover:bg-slate-50"
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