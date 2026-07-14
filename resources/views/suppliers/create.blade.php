<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                    Tambah Supplier
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Lengkapi data supplier baru.
                </p>
            </div>

            <a href="{{ route('suppliers.index') }}"
               class="rounded-lg border border-slate-300 dark:border-slate-600 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 p-6 shadow-sm sm:p-8">

                <form
                    action="{{ route('suppliers.store') }}"
                    method="POST"
                >
                    @csrf

                    {{-- ================= NAMA SUPPLIER ================= --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Nama Supplier
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            maxlength="50"
                            autofocus
                            autocomplete="off"
                            value="{{ old('name') }}"
                            placeholder="Contoh: CV Sumber Makmur"
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ================= ALAMAT ================= --}}
                    <div class="mt-6">
                        <label for="address" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Alamat
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            required
                            placeholder="Alamat lengkap supplier"
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('address') }}</textarea>

                        @error('address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ================= TELEPON ================= --}}
                    <div class="mt-6">
                        <label for="phone" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Nomor Telepon
                        </label>

                        <input
                                id="phone"
                                name="phone"
                                type="text"
                                required
                                autocomplete="off"
                                inputmode="numeric"
                                pattern="[0-9]{10,15}"
                                minlength="10"
                                maxlength="15"
                                value="{{ old('phone') }}"
                                placeholder="081234567890"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ================= BUTTON ================= --}}
                    <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <a
                            href="{{ route('suppliers.index') }}"
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

            </div>
        </div>
    </div>
</x-app-layout>
