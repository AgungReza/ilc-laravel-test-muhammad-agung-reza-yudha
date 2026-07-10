@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Manajemen Supplier</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Kelola seluruh data supplier yang memasok barang.
                </p>
            </div>

            <a href="{{ route('suppliers.create') }}"
               class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                + Tambah Supplier
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total Supplier</p>
                    <p class="mt-2 text-3xl font-bold text-indigo-600">{{ $suppliers->total() }}</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm md:col-span-2">
                    <form method="GET" action="{{ route('suppliers.index') }}" class="flex gap-3">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama, alamat, atau telepon..."
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                        <button class="rounded-lg bg-indigo-600 px-5 py-2 text-white hover:bg-indigo-700">
                            Cari
                        </button>
                    </form>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase">Supplier</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase">Telepon</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase">Barang</th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase">Aksi</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                        @forelse($suppliers as $supplier)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">{{ $suppliers->firstItem() + $loop->index }}</td>

                                <td class="px-6 py-4">
                                    <div class="font-semibold">{{ $supplier->name }}</div>
                                    <div class="text-xs text-slate-500">
                                        {{ Str::limit($supplier->address,40) }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">{{ $supplier->phone }}</td>

                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                        📦 {{ $supplier->items_count }} Barang
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('suppliers.show',$supplier) }}"
                                           class="rounded-lg border border-sky-200 bg-sky-50 px-3 py-2 text-xs font-semibold text-sky-700 hover:bg-sky-100">
                                            Detail
                                        </a>

                                        <a href="{{ route('suppliers.edit',$supplier) }}"
                                           class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-100">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('suppliers.destroy',$supplier) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <h3 class="text-lg font-semibold text-slate-700">
                                        Belum Ada Supplier
                                    </h3>

                                    <p class="mt-2 text-sm text-slate-500">
                                        Tambahkan supplier pertama untuk mulai mengelola data supplier.
                                    </p>

                                    <a href="{{ route('suppliers.create') }}"
                                       class="mt-5 inline-flex rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                                        + Tambah Supplier
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($suppliers->hasPages())
                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $suppliers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
