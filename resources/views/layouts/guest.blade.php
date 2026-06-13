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
<body class="min-h-screen bg-ios-bg flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-ios-blue rounded-ios-xl shadow-ios-md mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-ios-label">KlinikQ</h1>
            <p class="text-sm text-ios-label-secondary mt-0.5">Sistem Antrian &amp; Kunjungan Klinik</p>
        </div>

        <div class="ios-card">
            {{ $slot }}
        </div>

        <p class="text-center text-xs text-ios-label-secondary mt-6">
            &copy; {{ date('Y') }} KlinikQ — Pemrograman Web 2, Informatika UNSOED
        </p>
    </div>

    @livewireScripts
</body>
</html>
