<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Dashboard
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Ringkasan informasi sistem manajemen barang.
                </p>
            </div>

            <span
                class="inline-flex w-fit rounded-full px-3 py-1.5 text-xs font-semibold
                    {{ auth()->user()->role === 'admin'
                        ? 'bg-purple-100 text-purple-700'
                        : 'bg-indigo-100 text-indigo-700' }}"
            >
                {{ auth()->user()->role === 'admin' ? 'Administrator' : 'User' }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- Sambutan --}}
            <section
                class="relative overflow-hidden rounded-3xl bg-slate-900 px-6 py-8 text-white shadow-xl sm:px-8"
            >
                <div class="absolute -right-16 -top-20 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl"></div>
                <div class="absolute -bottom-24 left-1/3 h-56 w-56 rounded-full bg-purple-500/20 blur-3xl"></div>

                <div class="relative">
                    <p class="text-sm font-semibold text-indigo-300">
                        Selamat datang kembali
                    </p>

                    <h1 class="mt-2 text-2xl font-bold sm:text-3xl">
                        {{ auth()->user()->name }}
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                        Pantau kategori, data barang, stok, dan aktivitas
                        pengelolaan sistem melalui halaman dashboard ini.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a
                            href="{{ route('items.create') }}"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-400"
                        >
                            + Tambah Barang
                        </a>

                        <a
                            href="{{ route('categories.create') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/15"
                        >
                            + Tambah Kategori
                        </a>

                        @if (auth()->user()->role === 'admin')
                            <a
                                href="{{ route('users.create') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/15"
                            >
                                + Tambah User
                            </a>
                        @endif
                    </div>
                </div>
            </section>

            {{-- Kartu statistik --}}
            <section>
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-slate-800">
                        Ringkasan Data
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Informasi terbaru berdasarkan data di dalam sistem.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-5">

                    {{-- Total kategori --}}
                    <a
                        href="{{ route('categories.index') }}"
                        class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-md"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Total Kategori
                                </p>

                                <p class="mt-3 text-3xl font-black text-slate-800">
                                    {{ number_format($totalCategories) }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M3 7h18M5 7l1 13h12l1-13M9 11v5m6-5v5M9 4h6l1 3H8l1-3Z"
                                    />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs font-semibold text-indigo-600">
                            Lihat seluruh kategori →
                        </p>
                    </a>

                    {{-- Total barang --}}
                    <a
                        href="{{ route('items.index') }}"
                        class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-md"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Total Barang
                                </p>

                                <p class="mt-3 text-3xl font-black text-slate-800">
                                    {{ number_format($totalItems) }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="m21 8-9-5-9 5 9 5 9-5Zm-18 4 9 5 9-5M3 16l9 5 9-5"
                                    />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs font-semibold text-blue-600">
                            Lihat seluruh barang →
                        </p>
                    </a>

                    {{-- Total stok --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Total Stok
                                </p>

                                <p class="mt-3 text-3xl font-black text-slate-800">
                                    {{ number_format($totalStock) }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M4 6h16v14H4V6Zm3-3h10v3H7V3Zm2 8h6m-6 4h4"
                                    />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs font-medium text-slate-400">
                            Jumlah seluruh stok barang
                        </p>
                    </div>

                    {{-- Stok menipis --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Stok Menipis
                                </p>

                                <p class="mt-3 text-3xl font-black text-slate-800">
                                    {{ number_format($lowStockCount) }}
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 9v4m0 4h.01M10.3 3.9 2.5 17.4A2 2 0 0 0 4.2 20h15.6a2 2 0 0 0 1.7-2.6L13.7 3.9a2 2 0 0 0-3.4 0Z"
                                    />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-4 text-xs font-medium text-amber-600">
                            Kombinasi barang-supplier di bawah stok minimum
                        </p>
                    </div>

                    {{-- Total user khusus admin --}}
                    @if (auth()->user()->role === 'admin')
                        <a
                            href="{{ route('users.index') }}"
                            class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-purple-200 hover:shadow-md"
                        >
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-500">
                                        Total User
                                    </p>

                                    <p class="mt-3 text-3xl font-black text-slate-800">
                                        {{ number_format($totalUsers ?? 0) }}
                                    </p>
                                </div>

                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-100 text-purple-600">
                                    <svg
                                        class="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm13 10v-2a4 4 0 0 0-3-3.87m-2-11.96a4 4 0 0 1 0 7.75"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <p class="mt-4 text-xs font-semibold text-purple-600">
                                Kelola seluruh user →
                            </p>
                        </a>
                    @endif

                </div>
            </section>

            {{-- Bagian tabel dan stok rendah --}}
            <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                {{-- Barang terbaru --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-2">
                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                        <div>
                            <h3 class="font-bold text-slate-800">
                                Barang Terbaru
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Lima barang yang terakhir ditambahkan.
                            </p>
                        </div>

                        <a
                            href="{{ route('items.index') }}"
                            class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-700"
                        >
                            Lihat Semua
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Barang
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Kategori
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Harga
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Stok
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($latestItems as $item)
                                    <tr class="transition hover:bg-slate-50">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-slate-800">
                                                {{ $item->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                Ditambahkan
                                                {{ $item->created_at->diffForHumans() }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                                {{ $item->category?->name ?? '-' }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-slate-700">
                                            Rp {{ number_format((float) $item->price, 0, ',', '.') }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span
                                                class="rounded-full px-3 py-1 text-xs font-semibold
                                                    {{ ($item->total_stock ?? 0) <= 0
                                                        ? 'bg-red-100 text-red-700'
                                                        : ($item->total_stock <= 5
                                                            ? 'bg-amber-100 text-amber-700'
                                                            : 'bg-emerald-100 text-emerald-700') }}"
                                            >
                                                {{ $item->total_stock ?? 0 }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td
                                            colspan="4"
                                            class="px-6 py-12 text-center"
                                        >
                                            <p class="font-semibold text-slate-600">
                                                Belum ada barang
                                            </p>

                                            <a
                                                href="{{ route('items.create') }}"
                                                class="mt-3 inline-flex text-sm font-semibold text-indigo-600"
                                            >
                                                Tambahkan barang pertama
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Peringatan stok --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-6 py-5">
                        <h3 class="font-bold text-slate-800">
                            Peringatan Stok
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Barang yang perlu segera ditambah.
                        </p>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse ($lowStockItems as $itemSupplier)
                            <div class="flex items-center justify-between gap-4 px-6 py-4">
                                <div class="min-w-0">
                                    <p class="truncate font-semibold text-slate-800">
                                        {{ $itemSupplier->item->name }}
                                    </p>

                                    <p class="mt-1 truncate text-xs text-slate-500">
                                        {{ $itemSupplier->item->category?->name ?? '-' }}
                                        &middot; Supplier: {{ $itemSupplier->supplier->name }}
                                    </p>
                                </div>

                                <div class="shrink-0 text-right">
                                    @if ($itemSupplier->stock <= 0)
                                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                                            Habis
                                        </span>
                                    @else
                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">
                                            Sisa {{ $itemSupplier->stock }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                    <svg
                                        class="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m5 13 4 4L19 7"
                                        />
                                    </svg>
                                </div>

                                <p class="mt-4 font-semibold text-slate-700">
                                    Stok aman
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Tidak ada barang dengan stok menipis.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    @if ($lowStockItems->isNotEmpty())
                        <div class="border-t border-slate-200 px-6 py-4">
                            <a
                                href="{{ route('items.index') }}"
                                class="block rounded-lg bg-slate-100 px-4 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                            >
                                Kelola Stok Barang
                            </a>
                        </div>
                    @endif
                </div>

            </section>

        </div>
    </div>
</x-app-layout>