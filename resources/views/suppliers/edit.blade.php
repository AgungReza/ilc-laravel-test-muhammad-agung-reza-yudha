<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Edit Supplier {{ $supplier->name }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Perbarui data supplier.
                </p>
            </div>

            <a href="{{ route('suppliers.index') }}"
               class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                <form
                    action="{{ route('suppliers.update', $supplier) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    {{-- ================= NAMA SUPPLIER ================= --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700">
                            Nama Supplier
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            autofocus
                            autocomplete="off"
                            value="{{ old('name', $supplier->name) }}"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ================= ALAMAT ================= --}}
                    <div class="mt-6">
                        <label for="address" class="block text-sm font-semibold text-slate-700">
                            Alamat
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            required
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('address', $supplier->address) }}</textarea>

                        @error('address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ================= TELEPON ================= --}}
                    <div class="mt-6">
                        <label for="phone" class="block text-sm font-semibold text-slate-700">
                            Nomor Telepon
                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            required
                            autocomplete="off"
                            value="{{ old('phone', $supplier->phone) }}"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ================= BUTTON ================= --}}
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
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
