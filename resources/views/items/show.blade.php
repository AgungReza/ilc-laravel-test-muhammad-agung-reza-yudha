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

            <div class="grid gap-6 lg:grid-cols-3">

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800">Informasi Barang</h3>

                    <div class="mt-6 space-y-5">
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
                            <p class="text-sm text-slate-500">Harga</p>
                            <p class="font-semibold">
                                Rp {{ number_format($item->price,0,',','.') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Stok</p>
                            @if($item->stock>0)
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    {{ $item->stock }}
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
                                {{ $item->suppliers->count() }} Supplier
                            </span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-6 py-4">
                        <h3 class="font-semibold text-slate-800">
                            Supplier yang Memasok Barang
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Nama Supplier</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Alamat</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Telepon</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse($item->suppliers as $supplier)
                                    <tr>
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 font-semibold">
                                            <a href="{{ route('suppliers.show',$supplier) }}"
                                               class="text-indigo-600 hover:underline">
                                                {{ $supplier->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">{{ $supplier->address }}</td>
                                        <td class="px-6 py-4">{{ $supplier->phone }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-slate-500">
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