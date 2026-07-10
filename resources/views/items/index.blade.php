<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Manajemen Barang
                </h2>

                <p class="mt-1 text-sm text-slate-500">
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
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">

                        <thead class="bg-slate-50">
                            <tr>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    No
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Nama Barang
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Kategori
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Supplier
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Harga
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Stok
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Aksi
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white">

                            @forelse($items as $item)

                                <tr class="transition hover:bg-slate-50">

                                    {{-- Nomor --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                        {{ $items->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Nama --}}
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-800">
                                            {{ $item->name }}
                                        </div>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                            {{ $item->category?->name ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Supplier --}}
                                    <td class="px-6 py-4">

                                        @forelse($item->suppliers as $supplier)

                                            <span class="mb-1 mr-1 inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                {{ $supplier->name }}
                                            </span>

                                        @empty

                                            <span class="text-sm italic text-slate-400">
                                                Tidak ada supplier
                                            </span>

                                        @endforelse

                                    </td>

                                    {{-- Harga --}}
                                    <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-700">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>

                                    {{-- Stok --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @if($item->stock == 0)

                                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                Habis
                                            </span>

                                        @elseif($item->stock <= 10)

                                            <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                                {{ $item->stock }} (Menipis)
                                            </span>

                                        @else

                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                {{ $item->stock }}
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
                                                class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100"
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

                                    <td colspan="7" class="px-6 py-16 text-center">

                                        <h3 class="text-lg font-semibold text-slate-700">
                                            Belum Ada Barang
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
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

                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $items->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>