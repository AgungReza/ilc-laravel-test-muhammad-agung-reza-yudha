<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                    Manajemen User
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Kelola akun dan hak akses pengguna.
                </p>
            </div>

            <a
                href="{{ route('users.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
            >
                + Tambah User
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
                                    Nama
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Email
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Role
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Dibuat
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-gray-800">
                            @forelse ($users as $user)
                                <tr class="transition hover:bg-slate-50">

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                        {{ $users->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/40 font-bold text-indigo-700 dark:text-indigo-300">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="font-semibold text-slate-800 dark:text-slate-100">
                                                    {{ $user->name }}
                                                </p>

                                                @if (auth()->id() === $user->id)
                                                    <p class="mt-1 text-xs font-medium text-indigo-600">
                                                        Akun Anda
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                        {{ $user->email }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($user->role === 'admin')
                                            <span class="inline-flex rounded-full bg-purple-100 dark:bg-purple-900/40 px-3 py-1 text-xs font-semibold text-purple-700 dark:text-purple-300">
                                                Admin
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-slate-100 dark:bg-slate-700 px-3 py-1 text-xs font-semibold text-slate-700 dark:text-slate-200">
                                                User
                                            </span>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('users.edit', $user) }}"
                                                class="rounded-lg border border-amber-200 bg-amber-50 dark:bg-amber-900/30 px-3 py-2 text-xs font-semibold text-amber-700 dark:text-amber-300 transition hover:bg-amber-100"
                                            >
                                                Edit
                                            </a>

                                            @if (auth()->id() !== $user->id)
                                                <form
                                                    action="{{ route('users.destroy', $user) }}"
                                                    method="POST"
                                                    class="delete-form"
                                                    data-name="User {{ $user->name }}"
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
                                            @else
                                                <span class="rounded-lg bg-slate-100 dark:bg-slate-700 px-3 py-2 text-xs font-semibold text-slate-400 dark:text-slate-500">
                                                    Tidak dapat dihapus
                                                </span>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700">
                                            <span class="text-2xl">👤</span>
                                        </div>

                                        <p class="mt-4 font-semibold text-slate-700 dark:text-slate-200">
                                            Belum ada user
                                        </p>

                                        <p class="mt-1 text-sm text-slate-400 dark:text-slate-500">
                                            Tambahkan akun pengguna baru.
                                        </p>

                                        <a
                                            href="{{ route('users.create') }}"
                                            class="mt-5 inline-flex rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                        >
                                            Tambah User
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="border-t border-slate-200 dark:border-slate-700 px-6 py-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
