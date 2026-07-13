<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                    Barang Masuk
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Riwayat penerimaan barang dari supplier.
                </p>
            </div>

            <a
                href="{{ route('goods-receipts.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
            >
                + Catat Barang Masuk
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
                                    No. Transaksi
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Tanggal
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Jumlah Baris
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Total Qty
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Diinput Oleh
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Aksi
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-gray-800">

                            @forelse($goodsReceipts as $goodsReceipt)

                                <tr class="transition hover:bg-slate-50">

                                    {{-- No. Transaksi --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="font-mono text-sm font-semibold text-slate-800 dark:text-slate-100">
                                            {{ $goodsReceipt->transaction_number }}
                                        </span>
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                        {{ $goodsReceipt->receipt_date->format('d M Y') }}
                                    </td>

                                    {{-- Jumlah Baris --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                        {{ $goodsReceipt->items->count() }} barang
                                    </td>

                                    {{-- Total Qty --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                        {{ $goodsReceipt->items->sum('quantity') }}
                                    </td>

                                    {{-- Diinput Oleh --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                        {{ $goodsReceipt->user?->name ?? '-' }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('goods-receipts.edit', $goodsReceipt) }}"
                                                class="rounded-lg border border-amber-200 bg-amber-50 dark:bg-amber-900/30 px-3 py-2 text-xs font-semibold text-amber-700 dark:text-amber-300 transition hover:bg-amber-100"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('goods-receipts.destroy', $goodsReceipt) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok yang sudah ditambahkan akan dibatalkan.')"
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

                                    <td colspan="6" class="px-6 py-16 text-center">

                                        <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-200">
                                            Belum Ada Transaksi Barang Masuk
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                            Catat penerimaan barang pertama dari supplier.
                                        </p>

                                        <a
                                            href="{{ route('goods-receipts.create') }}"
                                            class="mt-6 inline-flex rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                        >
                                            + Catat Barang Masuk
                                        </a>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

                @if($goodsReceipts->hasPages())

                    <div class="border-t border-slate-200 dark:border-slate-700 px-6 py-4">
                        {{ $goodsReceipts->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>
