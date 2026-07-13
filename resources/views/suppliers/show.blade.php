<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">Detail Supplier</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Informasi supplier beserta daftar barang yang disuplai.
                </p>
            </div>

            <a href="{{ route('suppliers.index') }}"
               class="rounded-lg border border-slate-300 dark:border-slate-600 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid gap-6 lg:grid-cols-3">

                <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">
                        Informasi Supplier
                    </h3>

                    <div class="mt-6 space-y-5">
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Nama Supplier</p>
                            <p class="font-semibold">{{ $supplier->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Alamat</p>
                            <p>{{ $supplier->address }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Nomor Telepon</p>
                            <p>{{ $supplier->phone }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Jumlah Barang</p>
                            <span class="rounded-full bg-indigo-100 dark:bg-indigo-900/40 px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-300">
                                {{ $supplier->items->count() }} Barang
                            </span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 shadow-sm">
                    <div class="border-b border-slate-200 dark:border-slate-700 px-6 py-4">
                        <h3 class="font-semibold text-slate-800 dark:text-slate-100">
                            Daftar Barang yang Disuplai
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-gray-900/40">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Harga Beli</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Stok</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($supplier->items as $item)
                                    <tr>
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 font-semibold">
                                            <a href="{{ route('items.show',$item) }}"
                                               class="text-indigo-600 hover:underline">
                                                {{ $item->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $item->category?->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            Rp {{ number_format($item->pivot->purchase_price,0,',','.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($item->pivot->stock > $item->pivot->minimum_stock)
                                                <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/40 px-3 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-300">
                                                    {{ $item->pivot->stock }}
                                                </span>
                                            @elseif($item->pivot->stock > 0)
                                                <span class="rounded-full bg-amber-100 dark:bg-amber-900/40 px-3 py-1 text-xs font-semibold text-amber-700 dark:text-amber-300">
                                                    {{ $item->pivot->stock }} (Menipis)
                                                </span>
                                            @else
                                                <span class="rounded-full bg-red-100 dark:bg-red-900/40 px-3 py-1 text-xs font-semibold text-red-700 dark:text-red-300">
                                                    Habis
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                                            Supplier ini belum memiliki barang.
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
