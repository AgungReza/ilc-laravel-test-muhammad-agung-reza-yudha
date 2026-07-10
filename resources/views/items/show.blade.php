<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Detail Barang</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Informasi barang beserta supplier yang memasok barang.
                </p>
            </div>

            <a href="{{ route('items.index') }}"
               class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800">Informasi Barang</h3>

                    <div class="mt-6 space-y-5">
                        <div>
                            <p class="text-sm text-slate-500">Kode Barang</p>
                            <p class="font-semibold">{{ $item->code }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Nama Barang</p>
                            <p class="font-semibold">{{ $item->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Kategori</p>
                            <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                {{ $item->category?->name ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Satuan</p>
                            <p class="font-semibold">{{ $item->unit }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Harga Jual</p>
                            <p class="font-semibold">
                                Rp {{ number_format($item->price,0,',','.') }}
                            </p>
                        </div>

                        @if($item->description)
                            <div>
                                <p class="text-sm text-slate-500">Deskripsi</p>
                                <p class="text-sm text-slate-700">{{ $item->description }}</p>
                            </div>
                        @endif

                        <div>
                            <p class="text-sm text-slate-500">Total Stok (semua supplier)</p>
                            @if(($item->total_stock ?? 0) > 0)
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    {{ $item->total_stock }} {{ $item->unit }}
                                </span>
                            @else
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                    Habis
                                </span>
                            @endif
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Jumlah Supplier</p>
                            <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                {{ $item->itemSuppliers->count() }} Supplier
                            </span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                        <h3 class="font-semibold text-slate-800">
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
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Supplier</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Harga Beli</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Stok</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Stok Minimum</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
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
                                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                                    {{ $itemSupplier->stock }} (Menipis)
                                                </span>
                                            @else
                                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                    {{ $itemSupplier->stock }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4">{{ $itemSupplier->minimum_stock }}</td>

                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-2">
                                                <a
                                                    href="{{ route('items.suppliers.edit', [$item, $itemSupplier->supplier]) }}"
                                                    class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100"
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
                                                        class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100"
                                                    >
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-slate-500">
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
