<nav
    x-data="{ open: false }"
    class="border-b border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900"
>
    {{-- Navigasi Desktop --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">

            {{-- Bagian kiri --}}
            <div class="flex">

                {{-- Logo --}}
                <div class="flex shrink-0 items-center">
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center gap-3"
                    >
                        <x-application-logo
                            class="block h-9 w-auto fill-current text-indigo-600"
                        />

                        <span class="hidden text-sm font-bold text-slate-800 dark:text-slate-100 lg:block">
                            Manajemen Barang
                        </span>
                    </a>
                </div>

                {{-- Menu Desktop --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')"
                    >
                        Dashboard
                    </x-nav-link>

                    <x-nav-link
                        :href="route('categories.index')"
                        :active="request()->routeIs('categories.*')"
                    >
                        Kategori
                    </x-nav-link>

                    <x-nav-link
                        :href="route('items.index')"
                        :active="request()->routeIs('items.*')"
                    >
                        Barang
                    </x-nav-link>

                    <x-nav-link
                        :href="route('suppliers.index')"
                        :active="request()->routeIs('suppliers.*')"
                    >
                        Supplier
                    </x-nav-link>

                    <x-nav-link
                        :href="route('goods-receipts.index')"
                        :active="request()->routeIs('goods-receipts.*')"
                    >
                        Barang Masuk
                    </x-nav-link>

                    <x-nav-link
                        :href="route('goods-issues.index')"
                        :active="request()->routeIs('goods-issues.*')"
                    >
                        Barang Keluar
                    </x-nav-link>

                    @if (auth()->user()->role === 'admin')
                        <x-nav-link
                            :href="route('users.index')"
                            :active="request()->routeIs('users.*')"
                        >
                            Manajemen User
                        </x-nav-link>
                    @endif

                </div>
            </div>

            {{-- Bagian kanan desktop --}}
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                {{-- Toggle Dark Mode --}}
                <button
                    id="theme-toggle"
                    class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-yellow-400"
                >
                    {{-- Icon Matahari --}}
                    <svg
                        id="theme-light-icon"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 hidden dark:block"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0L16.95 7.05M7.05 16.95l-1.414 1.414M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>

                    {{-- Icon Bulan --}}
                    <svg
                        id="theme-dark-icon"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 block dark:hidden"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3c0 .34.02.67.05 1A7 7 0 0020 12.74c.34.03.67.05 1 .05z"/>
                    </svg>
                </button>

                {{-- Role --}}
                <span
                    class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                        {{ auth()->user()->role === 'admin'
                            ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300'
                            : 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200' }}"
                >
                    {{ auth()->user()->role === 'admin' ? 'Admin' : 'User' }}
                </span>

                {{-- Dropdown pengguna --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            type="button"
                            class="inline-flex items-center rounded-lg border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-slate-600 transition duration-150 ease-in-out hover:bg-slate-50 hover:text-slate-800 focus:outline-none dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-slate-100"
                        >
                            <div class="max-w-40 truncate">
                                {{ auth()->user()->name }}
                            </div>

                            <div class="ms-1">
                                <svg
                                    class="h-4 w-4 fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="border-b border-slate-100 px-4 py-3 dark:border-slate-700">
                            <p class="truncate text-sm font-semibold text-slate-800 dark:text-slate-100">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="mt-1 truncate text-xs text-slate-500 dark:text-slate-400">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            Profil
                        </x-dropdown-link>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="
                                    event.preventDefault();
                                    this.closest('form').submit();
                                "
                            >
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Tombol hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    type="button"
                    @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 focus:bg-slate-100 focus:text-slate-600 focus:outline-none dark:text-slate-500 dark:hover:bg-slate-800 dark:hover:text-slate-300 dark:focus:bg-slate-800 dark:focus:text-slate-300"
                    aria-label="Buka menu navigasi"
                >
                    {{-- Ikon menu --}}
                    <svg
                        :class="{ 'hidden': open, 'inline-flex': ! open }"
                        class="inline-flex h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>

                    {{-- Ikon tutup --}}
                    <svg
                        :class="{ 'hidden': ! open, 'inline-flex': open }"
                        class="hidden h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Navigasi Mobile --}}
    <div
        :class="{ 'block': open, 'hidden': ! open }"
        class="hidden border-t border-slate-100 sm:hidden dark:border-slate-700 dark:bg-slate-900"
    >
        {{-- Menu --}}
        <div class="space-y-1 pb-3 pt-2">

            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')"
            >
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('categories.index')"
                :active="request()->routeIs('categories.*')"
            >
                Kategori
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('items.index')"
                :active="request()->routeIs('items.*')"
            >
                Barang
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('suppliers.index')"
                :active="request()->routeIs('suppliers.*')"
            >
                Supplier
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('goods-receipts.index')"
                :active="request()->routeIs('goods-receipts.*')"
            >
                Barang Masuk
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('goods-issues.index')"
                :active="request()->routeIs('goods-issues.*')"
            >
                Barang Keluar
            </x-responsive-nav-link>

            @if (auth()->user()->role === 'admin')
                <x-responsive-nav-link
                    :href="route('users.index')"
                    :active="request()->routeIs('users.*')"
                >
                    Manajemen User
                </x-responsive-nav-link>
            @endif

        </div>

        {{-- Informasi pengguna --}}
        <div class="border-t border-slate-200 pb-1 pt-4 dark:border-slate-700">
            <div class="px-4">
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <div class="truncate text-base font-semibold text-slate-800 dark:text-slate-100">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="truncate text-sm text-slate-500 dark:text-slate-400">
                            {{ auth()->user()->email }}
                        </div>
                    </div>

                    <span
                        class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold
                            {{ auth()->user()->role === 'admin'
                                ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300'
                                : 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200' }}"
                    >
                        {{ auth()->user()->role === 'admin' ? 'Admin' : 'User' }}
                    </span>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil
                </x-responsive-nav-link>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="
                            event.preventDefault();
                            this.closest('form').submit();
                        "
                    >
                        Keluar
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
