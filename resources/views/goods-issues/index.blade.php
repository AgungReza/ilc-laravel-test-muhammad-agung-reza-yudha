<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Barang Keluar
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Riwayat pengeluaran barang ke pelanggan.
                </p>
            </div>

            <a
                href="{{ route('goods-issues.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
            >
                + Catat Barang Keluar
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
                                    No. Transaksi
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Tanggal
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Jumlah Baris
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Total Qty
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Diinput Oleh
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Aksi
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white">

                            @forelse($goodsIssues as $goodsIssue)

                                <tr class="transition hover:bg-slate-50">

                                    {{-- No. Transaksi --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="font-mono text-sm font-semibold text-slate-800">
                                            {{ $goodsIssue->transaction_number }}
                                        </span>
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                        {{ $goodsIssue->issue_date->format('d M Y') }}
                                    </td>

                                    {{-- Jumlah Baris --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                        {{ $goodsIssue->items->count() }} barang
                                    </td>

                                    {{-- Total Qty --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                        {{ $goodsIssue->items->sum('quantity') }}
                                    </td>

                                    {{-- Diinput Oleh --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                        {{ $goodsIssue->user?->name ?? '-' }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('goods-issues.edit', $goodsIssue) }}"
                                                class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('goods-issues.destroy', $goodsIssue) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok yang sudah dikurangi akan dikembalikan.')"
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

                                    <td colspan="6" class="px-6 py-16 text-center">

                                        <h3 class="text-lg font-semibold text-slate-700">
                                            Belum Ada Transaksi Barang Keluar
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Catat pengeluaran barang pertama ke pelanggan.
                                        </p>

                                        <a
                                            href="{{ route('goods-issues.create') }}"
                                            class="mt-6 inline-flex rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                        >
                                            + Catat Barang Keluar
                                        </a>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

                @if($goodsIssues->hasPages())

                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $goodsIssues->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>
