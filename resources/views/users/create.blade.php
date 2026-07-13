<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                Tambah User
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Buat akun pengguna baru dan tentukan hak aksesnya.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-gray-800 p-6 shadow-sm sm:p-8">

                <form
                    action="{{ route('users.store') }}"
                    method="POST"
                >
                    @csrf

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
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama user"
                            autocomplete="name"
                            autofocus
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                            value="{{ old('email') }}"
                            placeholder="nama@example.com"
                            autocomplete="email"
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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

                        <select
                            id="role"
                            name="role"
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">
                                Pilih role
                            </option>

                            <option
                                value="user"
                                @selected(old('role') === 'user')
                            >
                                User
                            </option>

                            <option
                                value="admin"
                                @selected(old('role') === 'admin')
                            >
                                Admin
                            </option>
                        </select>

                        @error('role')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mt-5">
                        <label
                            for="password"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                        >
                            Password
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password"
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            Gunakan minimal 8 karakter, huruf besar, huruf kecil, dan angka.
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
                            Konfirmasi Password
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="Ulangi password"
                            autocomplete="new-password"
                            class="mt-2 block w-full rounded-lg border-slate-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                            Simpan User
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
