<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Tambah Barang
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Masukkan informasi barang baru.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                {{-- Cek Kategori --}}
                @if ($categories->isEmpty())
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-5">
                        <h3 class="font-semibold text-amber-800">
                            Belum Ada Kategori
                        </h3>

                        <p class="mt-2 text-sm text-amber-700">
                            Tambahkan kategori terlebih dahulu sebelum menambahkan barang.
                        </p>

                        <a
                            href="{{ route('categories.create') }}"
                            class="mt-4 inline-flex rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-700"
                        >
                            Tambah Kategori
                        </a>
                    </div>

                {{-- Cek Supplier --}}
                @elseif ($suppliers->isEmpty())
                    <div class="rounded-xl border border-red-200 bg-red-50 p-5">
                        <h3 class="font-semibold text-red-800">
                            Belum Ada Supplier
                        </h3>

                        <p class="mt-2 text-sm text-red-700">
                            Tambahkan minimal satu supplier sebelum menambahkan barang.
                        </p>

                        <a
                            href="{{ route('suppliers.create') }}"
                            class="mt-4 inline-flex rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                        >
                            Tambah Supplier
                        </a>
                    </div>

                @else

                    <form
                        action="{{ route('items.store') }}"
                        method="POST"
                    >
                        @csrf

                        {{-- ================= KATEGORI ================= --}}
                        <div>
                            <label
                                for="category_id"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Kategori
                            </label>

                            <select
                                id="category_id"
                                name="category_id"
                                required
                                class="mt-2 block w-full rounded-lg border-slate-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        @selected(old('category_id') == $category->id)
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ================= SUPPLIER ================= --}}
                        <div class="mt-6">
                            <label
                                for="supplier_ids"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Supplier
                            </label>

                            <select
                                id="supplier_id"
                                name="supplier_id"
                                required
                                class="mt-2 block w-full rounded-lg border-slate-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">
                                    -- Pilih Supplier --
                                </option>

                                @foreach ($suppliers as $supplier)
                                    <option
                                        value="{{ $supplier->id }}"
                                        @selected(old('supplier_id') == $supplier->id)
                                    >
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>

                            <p class="mt-2 text-xs text-slate-500">
                                Tekan
                                <span class="font-semibold">Ctrl</span>
                                (Windows) atau
                                <span class="font-semibold">Command</span>
                                (Mac) untuk memilih lebih dari satu supplier.
                            </p>

                            @error('supplier_id')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                            @error('supplier_ids.*')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ================= NAMA BARANG ================= --}}
                        <div class="mt-6">
                            <label
                                for="name"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Nama Barang
                            </label>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                required
                                autofocus
                                autocomplete="off"
                                value="{{ old('name') }}"
                                placeholder="Contoh : Beras 5 Kg"
                                class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('name')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ================= HARGA ================= --}}
                        <div class="mt-6">
                            <label
                                for="price"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Harga
                            </label>

                            <div class="mt-2 flex rounded-lg shadow-sm">
                                <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-4 text-sm font-semibold text-slate-600">
                                    Rp
                                </span>

                                <input
                                    id="price"
                                    name="price"
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    required
                                    autocomplete="off"
                                    value="{{ old('price') }}"
                                    placeholder="75000"
                                    class="block w-full rounded-r-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            @error('price')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ================= STOK ================= --}}
                        <div class="mt-6">
                            <label
                                for="stock"
                                class="block text-sm font-semibold text-slate-700"
                            >
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
                                value="{{ old('stock', 0) }}"
                                class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('stock')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ================= BUTTON ================= --}}
                        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                            <a
                                href="{{ route('items.index') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                            >
                                Simpan Barang
                            </button>

                        </div>

                    </form>

                @endif

            </div>
        </div>
    </div>
</x-app-layout>