<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                    Manajemen Kategori
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Kelola kategori barang yang tersedia.
                </p>
            </div>

            <a
                href="{{ route('categories.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
            >
                + Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 shadow-sm">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">

                        <thead class="bg-slate-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    No
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Nama Kategori
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Jumlah Item
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-gray-800">
                            @forelse ($categories as $category)
                                <tr class="transition hover:bg-slate-50">

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                        {{ $categories->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-slate-800 dark:text-slate-100">
                                            {{ $category->name }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                                            Dibuat pada
                                            {{ $category->created_at->format('d M Y') }}
                                        </p>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-300">
                                            {{ $category->items_count }} item
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('categories.edit', $category) }}"
                                                class="rounded-lg border border-amber-200 bg-amber-50 dark:bg-amber-900/30 px-3 py-2 text-xs font-semibold text-amber-700 dark:text-amber-300 transition hover:bg-amber-100"
                                            >
                                                Edit
                                            </a>
                                            
                                            <form
                                                action="{{ route('categories.destroy', $category) }}"
                                                method="POST"
                                                class="delete-form"
                                                data-name="Kategori {{ $category->name }}"
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
                                    <td
                                        colspan="4"
                                        class="px-6 py-16 text-center"
                                    >
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700">
                                            <span class="text-2xl">📦</span>
                                        </div>

                                        <p class="mt-4 font-semibold text-slate-700 dark:text-slate-200">
                                            Belum ada kategori
                                        </p>

                                        <p class="mt-1 text-sm text-slate-400 dark:text-slate-500">
                                            Tambahkan kategori pertama untuk mulai mengelola barang.
                                        </p>

                                        <a
                                            href="{{ route('categories.create') }}"
                                            class="mt-5 inline-flex rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                        >
                                            Tambah Kategori
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                @if ($categories->hasPages())
                    <div class="border-t border-slate-200 dark:border-slate-700 px-6 py-4">
                        {{ $categories->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>