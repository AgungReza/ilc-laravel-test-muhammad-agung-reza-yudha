<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Edit Supplier {{ $supplier->name }} untuk {{ $item->name }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Perbarui harga beli, stok, dan stok minimum.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                <form
                    action="{{ route('items.suppliers.update', [$item, $supplier]) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    {{-- ================= HARGA BELI ================= --}}
                    <div>
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
                                value="{{ old('purchase_price', $itemSupplier->purchase_price) }}"
                                class="block w-full rounded-r-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        @error('purchase_price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ================= STOK ================= --}}
                    <div class="mt-6">
                        <label for="stock" class="block text-sm font-semibold text-slate-700">
                            Stok
                        </label>

                        <input
                            id="stock"
                            name="stock"
                            type="number"
                            min="0"
                            step="1"
                            required
                            autocomplete="off"
                            value="{{ old('stock', $itemSupplier->stock) }}"
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
                            value="{{ old('minimum_stock', $itemSupplier->minimum_stock) }}"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

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
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
