<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                Tambah Barang
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Masukkan informasi barang baru.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 p-6 shadow-sm sm:p-8">

                {{-- Cek Kategori --}}
                @if ($categories->isEmpty())
                    <div class="rounded-xl border border-amber-200 bg-amber-50 dark:bg-amber-900/30 p-5">
                        <h3 class="font-semibold text-amber-800 dark:text-amber-300">
                            Belum Ada Kategori
                        </h3>

                        <p class="mt-2 text-sm text-amber-700 dark:text-amber-300">
                            Tambahkan kategori terlebih dahulu sebelum menambahkan barang.
                        </p>

                        <a
                            href="{{ route('categories.create') }}"
                            class="mt-4 inline-flex rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-700"
                        >
                            Tambah Kategori
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
                                class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                            >
                                Kategori
                            </label>

                            <select
                                id="category_id"
                                name="category_id"
                                required
                                class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="" class="text-slate-400 dark:bg-gray-800 dark:text-slate-300">
                                    -- Pilih Kategori --
                                </option>

                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        @selected(old('category_id') == $category->id)
                                        class="dark:bg-gray-800 dark:text-white"
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

                        {{-- ================= KODE BARANG ================= --}}
                        <div class="mt-6">
                            <label
                                for="code"
                                class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                            >
                                Kode Barang
                            </label>

                            <input
                                id="code"
                                name="code"
                                type="text"
                                required
                                autocomplete="off"
                                value="{{ old('code') }}"
                                placeholder="Contoh : BRG-001"
                                class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('code')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ================= NAMA BARANG ================= --}}
                        <div class="mt-6">
                            <label
                                for="name"
                                class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
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
                                class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                                class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                            >
                                Harga
                            </label>

                            <div class="mt-2 flex rounded-lg shadow-sm">
                                <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-gray-900/40 px-4 text-sm font-semibold text-slate-600 dark:text-slate-300">
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
                                    class="block w-full rounded-r-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            @error('price')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ================= SATUAN ================= --}}
                        <div class="mt-6">
                            <label
                                for="unit"
                                class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                            >
                                Satuan
                            </label>

                            <input
                                id="unit"
                                name="unit"
                                type="text"
                                required
                                autocomplete="off"
                                value="{{ old('unit') }}"
                                placeholder="Contoh : Kg, Pcs, Karung"
                                class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('unit')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ================= DESKRIPSI ================= --}}
                        <div class="mt-6">
                            <label
                                for="description"
                                class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                            >
                                Deskripsi <span class="font-normal text-slate-400 dark:text-slate-500">(opsional)</span>
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                autocomplete="off"
                                placeholder="Catatan tambahan mengenai barang ini"
                                class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mt-6 rounded-xl border border-sky-200 dark:border-sky-800 bg-sky-50 dark:bg-sky-900/30 p-4 text-sm text-sky-800 dark:text-sky-300">
                            Supplier, harga beli, dan stok awal dapat ditambahkan
                            setelah barang ini tersimpan, melalui halaman detail barang.
                        </div>

                        {{-- ================= BUTTON ================= --}}
                        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                            <a
                                href="{{ route('items.index') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-600 px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 transition hover:bg-slate-50"
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