<?php

namespace App\Livewire\Dashboard;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dashboard')]
class StatsDashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_pasien' => Pasien::count(),
            'total_dokter' => Dokter::where('is_active', true)->count(),
            'total_poli' => Poli::where('is_active', true)->count(),
            'antrian_hari_ini' => Antrian::whereDate('tanggal', today())->count(),
            'antrian_menunggu' => Antrian::whereDate('tanggal', today())->where('status', 'menunggu')->count(),
            'antrian_selesai' => Antrian::whereDate('tanggal', today())->where('status', 'selesai')->count(),
            'kunjungan_hari_ini' => Kunjungan::whereDate('tanggal', today())->count(),
            'kunjungan_bulan_ini' => Kunjungan::whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->count(),
        ];

        $antrianAktif = Antrian::with(['pasien', 'poli'])
            ->whereDate('tanggal', today())
            ->whereIn('status', ['dipanggil', 'sedang_dilayani'])
            ->get();

        $rekapPoliHariIni = Poli::withCount(['antrian as total_antrian' => fn($q) => $q->whereDate('tanggal', today())])
            ->withCount(['antrian as selesai_count' => fn($q) => $q->whereDate('tanggal', today())->where('status', 'selesai')])
            ->withCount(['antrian as menunggu_count' => fn($q) => $q->whereDate('tanggal', today())->where('status', 'menunggu')])
            ->where('is_active', true)
            ->get();

        $kunjungan7Hari = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $kunjungan7Hari->push([
                'label' => $date->format('d/m'),
                'count' => Kunjungan::whereDate('tanggal', $date->toDateString())->count(),
            ]);
        }

        return view('livewire.dashboard.stats-dashboard', compact('stats', 'antrianAktif', 'rekapPoliHariIni', 'kunjungan7Hari'));
    }
}
