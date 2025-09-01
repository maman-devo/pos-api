<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RetailQ POS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">

    <!-- Navbar -->
    <nav
        class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow-sm">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24">
                        <img src="{{ asset('images/logo_icon.png') }}" class="block h-8 w-auto" alt="Logo Aplikasi">
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <button type="button"
                            class="relative inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:text-gray-400 dark:hover:bg-gray-700"
                            id="notification-button" data-dropdown-toggle="notification-dropdown">
                            <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <span class="sr-only">Notifications</span>
                            @if ($unreadNotificationsCount > 0)
                                <div id="notification-badge"
                                    class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                                    {{ $unreadNotificationsCount }}</div>
                            @endif
                        </button>
                        <!-- Dropdown menu -->
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600 max-w-sm"
                            id="notification-dropdown">
                            <div
                                class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-700 dark:text-white">
                                Notifikasi
                            </div>
                            <div class="divide-y divide-gray-100 dark:divide-gray-600">
                                @forelse($unreadNotifications as $notification)
                                    <a href="{{ route('admin.transactions.show', $notification->data['transaction_id']) }}"
                                        class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <div class="w-full ps-3">
                                            <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">
                                                Transaksi baru <span
                                                    class="font-semibold text-gray-900 dark:text-white">{{ $notification->data['transaction_code'] }}</span>
                                                dari kasir {{ $notification->data['cashier_name'] }}.
                                            </div>
                                            <div class="text-xs text-primary-600 dark:text-primary-500">
                                                {{ $notification->created_at->diffForHumans() }}</div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-3">
                                        <p class="text-sm text-center text-gray-500 dark:text-gray-400">Tidak ada
                                            notifikasi baru.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1d4ed8&color=fff"
                                    alt="user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="{{ route('profile.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Profile</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="menuitem">Sign out</a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-[#f5f7fa] border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-[#f5f7fa] dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 group rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white text-[#025863] shadow-md border border-gray-200' : 'text-gray-600 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-[#025863]' : 'text-gray-500 group-hover:text-gray-900' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>

                <!-- Menu Group: Manajemen -->
                <li class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                    <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Manajemen</span>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center p-2 group rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-white text-[#025863] shadow-md border border-gray-200' : 'text-gray-600 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 transition duration-75 {{ request()->routeIs('admin.products.*') ? 'text-[#025863]' : 'text-gray-500 group-hover:text-gray-900' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center p-2 group rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-white text-[#025863] shadow-md border border-gray-200' : 'text-gray-600 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 transition duration-75 {{ request()->routeIs('admin.categories.*') ? 'text-[#025863]' : 'text-gray-500 group-hover:text-gray-900' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Kategori</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center p-2 group rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-white text-[#025863] shadow-md border border-gray-200' : 'text-gray-600 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 transition duration-75 {{ request()->routeIs('admin.users.*') ? 'text-[#025863]' : 'text-gray-500 group-hover:text-gray-900' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.995 5.995 0 0112 12.75a5.995 5.995 0 01-3 5.197z">
                            </path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.stocks.index') }}"
                        class="flex items-center p-2 group rounded-lg {{ request()->routeIs('admin.stocks.*') ? 'bg-white text-[#025863] shadow-md border border-gray-200' : 'text-gray-600 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 transition duration-75 {{ request()->routeIs('admin.stocks.*') ? 'text-[#025863]' : 'text-gray-500 group-hover:text-gray-900' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Manajemen Stok</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.promos.index') }}"
                        class="flex items-center p-2 group rounded-lg {{ request()->routeIs('admin.promos.*') ? 'bg-white text-[#025863] shadow-md border border-gray-200' : 'text-gray-600 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 transition duration-75 {{ request()->routeIs('admin.promos.*') ? 'text-[#025863]' : 'text-gray-500 group-hover:text-gray-900' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 8v-5z">
                            </path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Manajemen Promo</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.payment-methods.index') }}"
                        class="flex items-center p-2 group rounded-lg {{ request()->routeIs('admin.payment-methods.*') ? 'bg-white text-[#025863] shadow-md border border-gray-200' : 'text-gray-600 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 transition duration-75 {{ request()->routeIs('admin.payment-methods.*') ? 'text-[#025863]' : 'text-gray-500 group-hover:text-gray-900' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H4a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Metode Pembayaran</span>
                    </a>
                </li>

                <!-- Menu Group: Laporan -->
                <li class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                    <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Laporan</span>
                </li>
                <li>
                    <a href="{{ route('admin.transactions.index') }}"
                        class="flex items-center p-2 group rounded-lg {{ request()->routeIs('admin.transactions.*') ? 'bg-white text-[#025863] shadow-md border border-gray-200' : 'text-gray-600 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 transition duration-75 {{ request()->routeIs('admin.transactions.*') ? 'text-[#025863]' : 'text-gray-500 group-hover:text-gray-900' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Riwayat Transaksi</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Area Konten Utama -->
    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="mb-6">
                    <div class="max-w-7xl mx-auto">
                        {{ $header }}

                        @if (!request()->routeIs('dashboard'))
                            <x-breadcrumb />
                        @endif
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationButton = document.getElementById('notification-button');
            const notificationBadge = document.getElementById('notification-badge');

            if (notificationButton) {
                notificationButton.addEventListener('click', function() {
                    // Hanya kirim request jika ada notifikasi yang belum dibaca
                    if (notificationBadge) {
                        fetch('{{ route('notifications.read') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Hilangkan badge secara visual setelah request berhasil
                                    notificationBadge.remove();
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            }
        });
    </script>
</body>

</html>
