<?php

namespace App\Livewire\Antrian;

use App\Models\Antrian;
use App\Models\Poli;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.papan')]
#[Title('Papan Antrian')]
class PapanAntrian extends Component
{
    public string $filterPoli = '';
    public ?int $poliId = null;

    #[On('antrian-updated')]
    public function refresh(): void
    {
    }

    public function updatedFilterPoli(): void
    {
        $this->poliId = $this->filterPoli ? (int) $this->filterPoli : null;
    }

    public function render()
    {
        $poliList = Poli::where('is_active', true)->get();

        $antrian = Antrian::query()
            ->with(['pasien', 'poli'])
            ->whereDate('tanggal', today())
            ->when($this->poliId, fn($q) => $q->where('poli_id', $this->poliId))
            ->orderByRaw("FIELD(status, 'dipanggil', 'sedang_dilayani', 'menunggu', 'selesai')")
            ->orderBy('nomor_antrian')
            ->get()
            ->groupBy('poli_id');

        $sedangDilayani = Antrian::query()
            ->with(['pasien', 'poli'])
            ->whereDate('tanggal', today())
            ->whereIn('status', ['dipanggil', 'sedang_dilayani'])
            ->when($this->poliId, fn($q) => $q->where('poli_id', $this->poliId))
            ->get();

        return view('livewire.antrian.papan-antrian', compact('poliList', 'antrian', 'sedangDilayani'));
    }
}
