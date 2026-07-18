<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                Edit User
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Perbarui data dan hak akses pengguna.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 p-6 shadow-sm sm:p-8">

                <form
                    action="{{ route('users.update', $user) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                        >
                            Nama
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $user->name) }}"
                            autocomplete="name"
                            autofocus
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('name')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mt-5">
                        <label
                            for="email"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                        >
                            Email
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            autocomplete="email"
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('email')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mt-5">
                        <label
                            for="role"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                        >
                            Role
                        </label>

                        @if (auth()->id() === $user->id)
                            <input
                                type="hidden"
                                name="role"
                                value="admin"
                            >

                            <select
                                id="role"
                                disabled
                                class="mt-2 block w-full cursor-not-allowed rounded-lg border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 shadow-sm"
                            >
                                <option class="dark:bg-slate-700 dark:text-slate-400">Admin</option>
                            </select>

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                Role akun yang sedang digunakan tidak dapat diubah.
                            </p>
                        @else
                            <select
                                id="role"
                                name="role"
                                class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="" class="text-slate-400 dark:bg-gray-800 dark:text-slate-300">
                                    Pilih role
                                </option>

                                <option
                                    value="user"
                                    @selected(old('role', $user->role) === 'user')
                                    class="dark:bg-gray-800 dark:text-white"
                                >
                                    User
                                </option>

                                <option
                                    value="admin"
                                    @selected(old('role', $user->role) === 'admin')
                                    class="dark:bg-gray-800 dark:text-white"
                                >
                                    Admin
                                </option>
                            </select>
                        @endif

                        @error('role')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password Baru --}}
                    <div class="mt-5">
                        <label
                            for="password"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                        >
                            Password Baru
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Kosongkan jika tidak ingin mengganti"
                            autocomplete="new-password"
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            Minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka.
                        </p>

                        @error('password')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mt-5">
                        <label
                            for="password_confirmation"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                        >
                            Konfirmasi Password Baru
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="Ulangi password baru"
                            autocomplete="new-password"
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 text-slate-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    {{-- Tombol --}}
                    <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <a
                            href="{{ route('users.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-600 px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 transition hover:bg-slate-50"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>