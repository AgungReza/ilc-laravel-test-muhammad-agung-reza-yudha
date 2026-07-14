<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                    Manajemen Barang
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Kelola seluruh barang ritel yang tersedia.
                </p>
            </div>

            <a
                href="{{ route('items.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
            >
                + Tambah Barang
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

            <div class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 shadow-sm">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">

                        <thead class="bg-slate-50 dark:bg-gray-900/40">
                            <tr>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    No
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Nama Barang
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Kategori
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Supplier
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Harga
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Stok
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Aksi
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-gray-800">

                            @forelse($items as $item)

                                <tr class="transition hover:bg-slate-900">

                                    {{-- Nomor --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                        {{ $items->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Nama --}}
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-800 dark:text-slate-100">
                                            {{ $item->name }}
                                        </div>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="rounded-full bg-indigo-100 dark:bg-indigo-900/40 px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-300">
                                            {{ $item->category?->name ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Supplier --}}
                                    <td class="px-6 py-4">

                                        @forelse($item->suppliers as $supplier)

                                            <span class="mb-1 mr-1 inline-flex rounded-full bg-emerald-100 dark:bg-emerald-900/40 px-3 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-300">
                                                {{ $supplier->name }}
                                            </span>

                                        @empty

                                            <span class="text-sm italic text-slate-400 dark:text-slate-500">
                                                Tidak ada supplier
                                            </span>

                                        @endforelse

                                    </td>

                                    {{-- Harga --}}
                                    <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-700 dark:text-slate-200">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>

                                    {{-- Stok (total lintas supplier) --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @if(($item->total_stock ?? 0) == 0)

                                            <span class="rounded-full bg-red-100 dark:bg-red-900/40 px-3 py-1 text-xs font-semibold text-red-700 dark:text-red-300">
                                                Habis
                                            </span>

                                        @elseif($item->total_stock <= 10)

                                            <span class="rounded-full bg-yellow-100 dark:bg-yellow-900/40 px-3 py-1 text-xs font-semibold text-yellow-700 dark:text-yellow-300">
                                                {{ $item->total_stock }} (Menipis)
                                            </span>

                                        @else

                                            <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/40 px-3 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-300">
                                                {{ $item->total_stock }}
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Aksi --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('items.show', $item) }}"
                                                class="rounded-lg border border-sky-200 bg-sky-50 px-3 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-100"
                                            >
                                                Detail
                                            </a>

                                            <a
                                                href="{{ route('items.edit', $item) }}"
                                                class="rounded-lg border border-amber-200 bg-amber-50 dark:bg-amber-900/30 px-3 py-2 text-xs font-semibold text-amber-700 dark:text-amber-300 transition hover:bg-amber-100"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('items.destroy', $item) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus barang ini?')"
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

                                    <td colspan="7" class="px-6 py-16 text-center">

                                        <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-200">
                                            Belum Ada Barang
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                            Tambahkan barang pertama untuk mulai mengelola data barang.
                                        </p>

                                        <a
                                            href="{{ route('items.create') }}"
                                            class="mt-6 inline-flex rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                        >
                                            + Tambah Barang
                                        </a>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

                @if($items->hasPages())

                    <div class="border-t border-slate-200 dark:border-slate-700 px-6 py-4">
                        {{ $items->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>