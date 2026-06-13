<div class="space-y-6">
    {{-- Stat cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="stat-icon bg-ios-blue-light">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-ios-blue-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-ios-label">{{ number_format($stats['total_pasien']) }}</p>
                <p class="text-xs text-ios-label-secondary mt-0.5">Total Pasien</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-ios-blue-light">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-ios-blue-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-ios-label">{{ number_format($stats['total_dokter']) }}</p>
                <p class="text-xs text-ios-label-secondary mt-0.5">Dokter Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-ios-blue-light">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-ios-blue-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-ios-label">{{ number_format($stats['antrian_hari_ini']) }}</p>
                <p class="text-xs text-ios-label-secondary mt-0.5">Antrian Hari Ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-ios-blue-light">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-ios-blue-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-ios-label">{{ number_format($stats['kunjungan_hari_ini']) }}</p>
                <p class="text-xs text-ios-label-secondary mt-0.5">Kunjungan Hari Ini</p>
            </div>
        </div>
    </div>

    {{-- Status antrian — semua merah --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="ios-card-sm text-center border-l-4 border-ios-blue">
            <p class="text-3xl font-bold text-ios-blue">{{ $stats['antrian_menunggu'] }}</p>
            <p class="text-xs text-ios-label-secondary mt-1">Menunggu</p>
        </div>
        <div class="ios-card-sm text-center border-l-4 border-ios-blue">
            <p class="text-3xl font-bold text-ios-blue">{{ $stats['antrian_hari_ini'] - $stats['antrian_menunggu'] - $stats['antrian_selesai'] }}</p>
            <p class="text-xs text-ios-label-secondary mt-1">Berlangsung</p>
        </div>
        <div class="ios-card-sm text-center border-l-4 border-ios-blue">
            <p class="text-3xl font-bold text-ios-blue">{{ $stats['antrian_selesai'] }}</p>
            <p class="text-xs text-ios-label-secondary mt-1">Selesai</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="ios-card">
            <h2 class="text-sm font-semibold text-ios-label mb-4">Antrian Berlangsung</h2>
            @if($antrianAktif->isEmpty())
                <div class="text-center py-8">
                    <p class="text-sm text-ios-label-secondary">Tidak ada antrian aktif saat ini.</p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach($antrianAktif as $a)
                    <div class="flex items-center gap-3 p-3 rounded-ios bg-ios-bg">
                        <div class="w-10 h-10 bg-ios-blue rounded-ios flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">{{ $a->nomor_antrian }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-ios-label truncate">{{ $a->pasien->nama }}</p>
                            <p class="text-xs text-ios-label-secondary">{{ $a->poli->nama }}</p>
                        </div>
                        <span class="{{ $a->status_color }}">{{ $a->status_label }}</span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="ios-card">
            <h2 class="text-sm font-semibold text-ios-label mb-4">Rekap Poli Hari Ini</h2>
            <div class="space-y-3">
                @foreach($rekapPoliHariIni as $poli)
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-ios-label">{{ $poli->nama }}</span>
                        <span class="text-xs text-ios-label-secondary">{{ $poli->selesai_count }}/{{ $poli->total_antrian }}</span>
                    </div>
                    <div class="w-full bg-ios-separator/40 rounded-full h-2">
                        @php
                            $pct = $poli->total_antrian > 0 ? ($poli->selesai_count / $poli->total_antrian) * 100 : 0;
                        @endphp
                        <div class="h-2 rounded-full transition-all duration-500" style="width: {{ $pct }}%; background-color: #F07B7B;"></div>
                    </div>
                </div>
                @endforeach
                @if($rekapPoliHariIni->isEmpty())
                    <p class="text-sm text-ios-label-secondary text-center py-4">Belum ada data hari ini.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="ios-card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-ios-label">Kunjungan 7 Hari Terakhir</h2>
            <span class="badge badge-blue">{{ $stats['kunjungan_bulan_ini'] }} bulan ini</span>
        </div>
        <div class="flex items-end gap-2 h-28">
            @php $maxCount = max($kunjungan7Hari->pluck('count')->toArray() ?: [1]); @endphp
            @foreach($kunjungan7Hari as $day)
            <div class="flex-1 flex flex-col items-center gap-1">
                <span class="text-xs font-medium text-ios-label">{{ $day['count'] }}</span>
                <div class="w-full rounded-t-ios transition-all duration-500" style="height: {{ $maxCount > 0 ? (($day['count'] / $maxCount) * 72) : 4 }}px; min-height: 4px; background-color: {{ $day['count'] > 0 ? '#F07B7B' : '#FDEAEA' }};"></div>
                <span class="text-xs text-ios-label-secondary">{{ $day['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
