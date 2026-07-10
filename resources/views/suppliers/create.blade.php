<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Tambah Supplier
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Masukkan informasi supplier baru.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                <form
                    action="{{ route('suppliers.store') }}"
                    method="POST"
                >
                    @csrf

                    {{-- ================= Nama Supplier ================= --}}
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Nama Supplier
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            autofocus
                            autocomplete="off"
                            value="{{ old('name') }}"
                            placeholder="Contoh: PT Sumber Makmur"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('name')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- ================= Alamat ================= --}}
                    <div class="mt-6">
                        <label
                            for="address"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Alamat
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="4"
                            required
                            autocomplete="off"
                            placeholder="Masukkan alamat supplier"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('address') }}</textarea>

                        @error('address')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- ================= Nomor Telepon ================= --}}
                    <div class="mt-6">
                        <label
                            for="phone"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Nomor Telepon
                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            required
                            autocomplete="off"
                            maxlength="20"
                            value="{{ old('phone') }}"
                            placeholder="Contoh: 081234567890"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('phone')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- ================= Tombol ================= --}}
                    <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('suppliers.index') }}"
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

            </div>

        </div>
    </div>
</x-app-layout>