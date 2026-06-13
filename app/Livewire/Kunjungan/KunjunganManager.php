<?php

namespace App\Livewire\Kunjungan;

use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Manajemen Kunjungan')]
class KunjunganManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterDokter = '';
    public string $filterTanggal = '';
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public bool $showDetailModal = false;
    public ?int $editId = null;
    public ?int $deleteId = null;
    public ?Kunjungan $detailRecord = null;

    public int|string $pasien_id = '';
    public int|string $dokter_id = '';
    public string $tanggal = '';
    public string $keluhan = '';
    public string $diagnosis = '';
    public string $catatan = '';

    protected array $rules = [
        'pasien_id' => 'required|exists:pasien,id',
        'dokter_id' => 'required|exists:dokter,id',
        'tanggal' => 'required|date',
        'keluhan' => 'required|string|max:1000',
        'diagnosis' => 'nullable|string|max:1000',
        'catatan' => 'nullable|string|max:1000',
    ];

    protected array $messages = [
        'pasien_id.required' => 'Pasien wajib dipilih.',
        'dokter_id.required' => 'Dokter wajib dipilih.',
        'tanggal.required' => 'Tanggal wajib diisi.',
        'keluhan.required' => 'Keluhan wajib diisi.',
    ];

    public function mount(): void
    {
        $this->tanggal = now()->toDateString();
    }

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedFilterDokter(): void { $this->resetPage(); }
    public function updatedFilterTanggal(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->reset(['editId', 'pasien_id', 'dokter_id', 'keluhan', 'diagnosis', 'catatan']);
        $this->tanggal = now()->toDateString();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $this->editId = $id;
        $this->pasien_id = $kunjungan->pasien_id;
        $this->dokter_id = $kunjungan->dokter_id;
        $this->tanggal = $kunjungan->tanggal->format('Y-m-d');
        $this->keluhan = $kunjungan->keluhan;
        $this->diagnosis = $kunjungan->diagnosis ?? '';
        $this->catatan = $kunjungan->catatan ?? '';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openDetail(int $id): void
    {
        $this->detailRecord = Kunjungan::with(['pasien', 'dokter.poli'])->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function save(): void
    {
        $this->validate();

        Kunjungan::updateOrCreate(
            ['id' => $this->editId],
            [
                'pasien_id' => $this->pasien_id,
                'dokter_id' => $this->dokter_id,
                'tanggal' => $this->tanggal,
                'keluhan' => $this->keluhan,
                'diagnosis' => $this->diagnosis,
                'catatan' => $this->catatan,
            ]
        );

        $this->showModal = false;
        $this->dispatch('notify', message: $this->editId ? 'Data kunjungan berhasil diperbarui.' : 'Kunjungan berhasil dicatat.', type: 'success');
        $this->reset(['editId', 'pasien_id', 'dokter_id', 'keluhan', 'diagnosis', 'catatan']);
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            Kunjungan::findOrFail($this->deleteId)->delete();
            $this->dispatch('notify', message: 'Data kunjungan berhasil dihapus.', type: 'success');
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $kunjungan = Kunjungan::query()
            ->with(['pasien', 'dokter.poli'])
            ->when($this->search, fn($q) => $q->whereHas('pasien', fn($p) => $p->where('nama', 'like', "%{$this->search}%")))
            ->when($this->filterDokter, fn($q) => $q->where('dokter_id', $this->filterDokter))
            ->when($this->filterTanggal, fn($q) => $q->whereDate('tanggal', $this->filterTanggal))
            ->latest('tanggal')
            ->paginate(10);

        $pasienList = Pasien::orderBy('nama')->get();
        $dokterList = Dokter::with('poli')->where('is_active', true)->orderBy('nama')->get();

        return view('livewire.kunjungan.kunjungan-manager', compact('kunjungan', 'pasienList', 'dokterList'));
    }
}
