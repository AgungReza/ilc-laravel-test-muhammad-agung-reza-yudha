<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">Detail Barang</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Informasi barang beserta supplier yang memasok barang.
                </p>
            </div>

            <a href="{{ route('items.index') }}"
               class="rounded-lg border border-slate-300 dark:border-slate-600 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 dark:bg-emerald-900/30 px-4 py-3 text-sm font-medium text-emerald-700 dark:text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">

                <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Informasi Barang</h3>

                    <div class="mt-6 space-y-5">
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Kode Barang</p>
                            <p class="font-semibold dark:text-white">{{ $item->code }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Nama Barang</p>
                            <p class="font-semibold dark:text-white">{{ $item->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Kategori</p>
                            <span class="rounded-full bg-indigo-100 dark:bg-indigo-900/40 px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-300">
                                {{ $item->category?->name ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Satuan</p>
                            <p class="font-semibold dark:text-white">{{ $item->unit }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Harga Jual</p>
                            <p class="font-semibold dark:text-white">
                                Rp {{ number_format($item->price,0,',','.') }}
                            </p>
                        </div>

                        @if($item->description)
                            <div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Deskripsi</p>
                                <p class="text-sm text-slate-700 dark:text-slate-200">{{ $item->description }}</p>
                            </div>
                        @endif

                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Total Stok (semua supplier)</p>
                            @if(($item->total_stock ?? 0) > 0)
                                <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/40 px-3 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-300">
                                    {{ $item->total_stock }} {{ $item->unit }}
                                </span>
                            @else
                                <span class="rounded-full bg-red-100 dark:bg-red-900/40 px-3 py-1 text-xs font-semibold text-red-700 dark:text-red-300">
                                    Habis
                                </span>
                            @endif
                        </div>

                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Jumlah Supplier</p>
                            <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                {{ $item->itemSuppliers->count() }} Supplier
                            </span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 px-6 py-4">
                        <h3 class="font-semibold text-slate-800 dark:text-slate-100">
                            Supplier yang Memasok Barang Ini
                        </h3>

                        <a
                            href="{{ route('items.suppliers.create', $item) }}"
                            class="rounded-lg bg-indigo-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-indigo-700"
                        >
                            + Tambah Supplier
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-gray-900/40">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase dark:text-slate-400">Supplier</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase dark:text-slate-400">Harga Beli</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase dark:text-slate-400">Stok</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase dark:text-slate-400">Stok Minimum</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase dark:text-slate-400">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 dark:text-white">
                                @forelse($item->itemSuppliers as $itemSupplier)
                                    <tr>
                                        <td class="px-6 py-4 font-semibold">
                                            <a href="{{ route('suppliers.show', $itemSupplier->supplier) }}"
                                               class="text-indigo-600 hover:underline">
                                                {{ $itemSupplier->supplier->name }}
                                            </a>
                                        </td>

                                        <td class="px-6 py-4">
                                            Rp {{ number_format($itemSupplier->purchase_price, 0, ',', '.') }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if($itemSupplier->stock <= $itemSupplier->minimum_stock)
                                                <span class="rounded-full bg-amber-100 dark:bg-amber-900/40 px-3 py-1 text-xs font-semibold text-amber-700 dark:text-amber-300">
                                                    {{ $itemSupplier->stock }} (Menipis)
                                                </span>
                                            @else
                                                <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/40 px-3 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-300">
                                                    {{ $itemSupplier->stock }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4">{{ $itemSupplier->minimum_stock }}</td>

                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-2">
                                                <a
                                                    href="{{ route('items.suppliers.edit', [$item, $itemSupplier->supplier]) }}"
                                                    class="rounded-lg border border-amber-200 bg-amber-50 dark:bg-amber-900/30 px-3 py-2 text-xs font-semibold text-amber-700 dark:text-amber-300 transition hover:bg-amber-100"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('items.suppliers.destroy', [$item, $itemSupplier->supplier]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus supplier ini dari barang ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/30 px-3 py-2 text-xs font-semibold text-red-700 dark:text-red-300 transition hover:bg-red-100"
                                                    >
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                                            Belum ada supplier yang memasok barang ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
