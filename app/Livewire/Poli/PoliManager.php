<?php

namespace App\Livewire\Poli;

use App\Models\Poli;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Manajemen Poli')]
class PoliManager extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $editId = null;
    public ?int $deleteId = null;

    public string $nama = '';
    public string $kode = '';
    public string $deskripsi = '';
    public bool $is_active = true;

    protected function rules(): array
    {
        $id = $this->editId;
        return [
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:10|unique:poli,kode,' . ($id ?? 'NULL'),
            'deskripsi' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ];
    }

    protected array $messages = [
        'nama.required' => 'Nama poli wajib diisi.',
        'kode.required' => 'Kode poli wajib diisi.',
        'kode.unique' => 'Kode poli sudah digunakan.',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['editId', 'nama', 'kode', 'deskripsi']);
        $this->is_active = true;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $poli = Poli::findOrFail($id);
        $this->editId = $id;
        $this->nama = $poli->nama;
        $this->kode = $poli->kode;
        $this->deskripsi = $poli->deskripsi ?? '';
        $this->is_active = $poli->is_active;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        Poli::updateOrCreate(
            ['id' => $this->editId],
            [
                'nama' => $this->nama,
                'kode' => strtoupper($this->kode),
                'deskripsi' => $this->deskripsi,
                'is_active' => $this->is_active,
            ]
        );

        $this->showModal = false;
        $this->dispatch('notify', message: $this->editId ? 'Data poli berhasil diperbarui.' : 'Data poli berhasil ditambahkan.', type: 'success');
        $this->reset(['editId', 'nama', 'kode', 'deskripsi']);
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $poli = Poli::findOrFail($this->deleteId);
            if ($poli->dokter()->count() > 0) {
                $this->dispatch('notify', message: 'Tidak dapat menghapus poli yang masih memiliki dokter.', type: 'error');
                $this->showDeleteModal = false;
                return;
            }
            $poli->delete();
            $this->dispatch('notify', message: 'Data poli berhasil dihapus.', type: 'success');
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function toggleActive(int $id): void
    {
        $poli = Poli::findOrFail($id);
        $poli->update(['is_active' => !$poli->is_active]);
        $this->dispatch('notify', message: 'Status poli diperbarui.', type: 'info');
    }

    public function render()
    {
        $poli = Poli::query()
            ->when($this->search, fn($q) => $q->where('nama', 'like', "%{$this->search}%")
                ->orWhere('kode', 'like', "%{$this->search}%"))
            ->withCount('dokter')
            ->withCount(['antrian as antrian_hari_ini_count' => fn($q) => $q->whereDate('tanggal', today())])
            ->latest()
            ->paginate(10);

        return view('livewire.poli.poli-manager', compact('poli'));
    }
}
