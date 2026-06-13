<?php

namespace App\Livewire\Antrian;

use App\Models\Antrian;
use App\Models\Pasien;
use App\Models\Poli;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Manajemen Antrian')]
class AntrianManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterPoli = '';
    public string $filterStatus = '';
    public string $filterTanggal = '';
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;

    public int|string $poli_id = '';
    public int|string $pasien_id = '';
    public string $tanggal = '';

    protected array $rules = [
        'poli_id' => 'required|exists:poli,id',
        'pasien_id' => 'required|exists:pasien,id',
        'tanggal' => 'required|date',
    ];

    protected array $messages = [
        'poli_id.required' => 'Poli wajib dipilih.',
        'pasien_id.required' => 'Pasien wajib dipilih.',
        'tanggal.required' => 'Tanggal wajib diisi.',
    ];

    public function mount(): void
    {
        $this->filterTanggal = now()->toDateString();
        $this->tanggal = now()->toDateString();
    }

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedFilterPoli(): void { $this->resetPage(); }
    public function updatedFilterStatus(): void { $this->resetPage(); }
    public function updatedFilterTanggal(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->reset(['poli_id', 'pasien_id']);
        $this->tanggal = now()->toDateString();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $existing = Antrian::where('poli_id', $this->poli_id)
            ->where('pasien_id', $this->pasien_id)
            ->whereDate('tanggal', $this->tanggal)
            ->exists();

        if ($existing) {
            $this->addError('pasien_id', 'Pasien sudah memiliki antrian di poli ini pada tanggal tersebut.');
            return;
        }

        $nomorAntrian = Antrian::generateNomor((int) $this->poli_id);
        $antrian = Antrian::create([
            'poli_id' => $this->poli_id,
            'pasien_id' => $this->pasien_id,
            'nomor_antrian' => $nomorAntrian,
            'tanggal' => $this->tanggal,
            'status' => 'menunggu',
            'estimasi_menit' => $this->hitungEstimasi((int) $this->poli_id),
        ]);

        $this->showModal = false;
        $this->dispatch('notify', message: "Nomor antrian #{$nomorAntrian} berhasil dibuat.", type: 'success');
        $this->dispatch('antrian-updated');
        $this->reset(['poli_id', 'pasien_id']);
    }

    private function hitungEstimasi(int $poliId): int
    {
        $menunggu = Antrian::where('poli_id', $poliId)
            ->whereDate('tanggal', today())
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->count();
        return ($menunggu + 1) * 15;
    }

    public function panggil(int $id): void
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->update([
            'status' => 'dipanggil',
            'waktu_panggil' => now(),
        ]);
        $this->dispatch('notify', message: "Antrian #{$antrian->nomor_antrian} — {$antrian->pasien->nama} dipanggil.", type: 'info');
        $this->dispatch('antrian-updated');
    }

    public function layani(int $id): void
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->update(['status' => 'sedang_dilayani']);
        $this->dispatch('notify', message: "Antrian #{$antrian->nomor_antrian} sedang dilayani.", type: 'info');
        $this->dispatch('antrian-updated');
    }

    public function selesai(int $id): void
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->update([
            'status' => 'selesai',
            'waktu_selesai' => now(),
        ]);
        $this->dispatch('notify', message: "Antrian #{$antrian->nomor_antrian} selesai dilayani.", type: 'success');
        $this->dispatch('antrian-updated');
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            Antrian::findOrFail($this->deleteId)->delete();
            $this->dispatch('notify', message: 'Data antrian berhasil dihapus.', type: 'success');
            $this->dispatch('antrian-updated');
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $antrian = Antrian::query()
            ->with(['poli', 'pasien'])
            ->when($this->filterTanggal, fn($q) => $q->whereDate('tanggal', $this->filterTanggal))
            ->when($this->filterPoli, fn($q) => $q->where('poli_id', $this->filterPoli))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->search, fn($q) => $q->whereHas('pasien', fn($p) => $p->where('nama', 'like', "%{$this->search}%")))
            ->orderBy('nomor_antrian')
            ->paginate(15);

        $poliList = Poli::where('is_active', true)->get();
        $pasienList = Pasien::orderBy('nama')->get();

        return view('livewire.antrian.antrian-manager', compact('antrian', 'poliList', 'pasienList'));
    }
}
