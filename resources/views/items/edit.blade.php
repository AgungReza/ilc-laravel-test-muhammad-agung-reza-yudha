<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Edit Barang
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Perbarui informasi barang.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                <form
                    action="{{ route('items.update', $item) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

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
                                    @selected(old('category_id', $item->category_id) == $category->id)
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
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Kode Barang
                        </label>

                        <input
                            id="code"
                            name="code"
                            type="text"
                            required
                            autocomplete="off"
                            value="{{ old('code', $item->code) }}"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Nama Barang
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            autocomplete="off"
                            value="{{ old('name', $item->name) }}"
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
                            <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-4 text-sm font-semibold text-slate-500">
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
                                value="{{ old('price', $item->price) }}"
                                class="block w-full rounded-r-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
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
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Satuan
                        </label>

                        <input
                            id="unit"
                            name="unit"
                            type="text"
                            required
                            autocomplete="off"
                            value="{{ old('unit', $item->unit) }}"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Deskripsi <span class="font-normal text-slate-400">(opsional)</span>
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            autocomplete="off"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('description', $item->description) }}</textarea>

                        @error('description')
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
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>