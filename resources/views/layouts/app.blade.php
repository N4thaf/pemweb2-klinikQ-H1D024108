<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="KlinikQ — Sistem Antrian &amp; Kunjungan Klinik Digital">
    <title>{{ isset($title) ? $title . ' — KlinikQ' : 'KlinikQ' }}</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-ios-bg">
    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-white border-r border-ios-separator flex flex-col flex-shrink-0 hidden lg:flex">
            <div class="px-5 py-5 border-b border-ios-separator">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-ios-blue rounded-ios flex items-center justify-center flex-shrink-0 shadow-ios">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-brand font-semibold text-ios-label text-lg leading-none">KlinikQ</span>
                        <p class="text-xs text-ios-label-secondary leading-none mt-1">Sistem Antrian Klinik</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
                <p class="text-xs font-semibold text-ios-label-secondary uppercase tracking-wider px-3 mb-2">Menu Utama</p>
                <a href="{{ route('dashboard') }}" wire:navigate class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM14 5a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('antrian.index') }}" wire:navigate class="sidebar-link {{ request()->routeIs('antrian.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    Antrian
                </a>
                <a href="{{ route('kunjungan.index') }}" wire:navigate class="sidebar-link {{ request()->routeIs('kunjungan.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Kunjungan
                </a>

                <div class="pt-4 pb-1">
                    <p class="text-xs font-semibold text-ios-label-secondary uppercase tracking-wider px-3 mb-2">Master Data</p>
                </div>
                <a href="{{ route('pasien.index') }}" wire:navigate class="sidebar-link {{ request()->routeIs('pasien.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Pasien
                </a>
                <a href="{{ route('dokter.index') }}" wire:navigate class="sidebar-link {{ request()->routeIs('dokter.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Dokter
                </a>
                <a href="{{ route('poli.index') }}" wire:navigate class="sidebar-link {{ request()->routeIs('poli.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    Poli
                </a>

                <div class="pt-4 pb-1">
                    <p class="text-xs font-semibold text-ios-label-secondary uppercase tracking-wider px-3 mb-2">Lainnya</p>
                </div>
                <a href="{{ route('papan.antrian') }}" target="_blank" class="sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    Papan Antrian
                </a>
            </nav>

            <div class="px-3 py-4 border-t border-ios-separator">
                <div class="flex items-center gap-3 px-3 py-2 rounded-ios mb-2">
                    <div class="w-8 h-8 bg-ios-blue-light rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-ios-blue text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-ios-label truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-ios-label-secondary">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-ios-red hover:bg-red-50 hover:text-ios-red">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="bg-white border-b border-ios-separator px-6 py-4 flex items-center justify-between flex-shrink-0">
                <div>
                    <h1 class="font-brand text-xl font-semibold text-ios-label tracking-tight">{{ $title ?? 'Dashboard' }}</h1>
                    <p class="text-xs text-ios-label-secondary mt-0.5">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('papan.antrian') }}" target="_blank" class="btn-secondary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        Papan Antrian
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
