<?php

namespace App\Livewire\Dokter;

use App\Models\Dokter;
use App\Models\Poli;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Manajemen Dokter')]
class DokterManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $filterPoli = '';
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $editId = null;
    public ?int $deleteId = null;

    public string $nama = '';
    public string $spesialisasi = '';
    public string $no_hp = '';
    public int|string $poli_id = '';
    public bool $is_active = true;
    public $foto = null;
    public ?string $fotoLama = null;

    protected function rules(): array
    {
        return [
            'nama' => 'required|string|max:100',
            'spesialisasi' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'poli_id' => 'required|exists:poli,id',
            'is_active' => 'boolean',
            'foto' => 'nullable|image|max:2048',
        ];
    }

    protected array $messages = [
        'nama.required' => 'Nama dokter wajib diisi.',
        'spesialisasi.required' => 'Spesialisasi wajib diisi.',
        'poli_id.required' => 'Poli wajib dipilih.',
        'poli_id.exists' => 'Poli tidak valid.',
        'foto.image' => 'File harus berupa gambar.',
        'foto.max' => 'Ukuran foto maksimal 2MB.',
    ];

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedFilterPoli(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->reset(['editId', 'nama', 'spesialisasi', 'no_hp', 'poli_id', 'foto', 'fotoLama']);
        $this->is_active = true;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $dokter = Dokter::findOrFail($id);
        $this->editId = $id;
        $this->nama = $dokter->nama;
        $this->spesialisasi = $dokter->spesialisasi;
        $this->no_hp = $dokter->no_hp ?? '';
        $this->poli_id = $dokter->poli_id;
        $this->is_active = $dokter->is_active;
        $this->fotoLama = $dokter->foto;
        $this->foto = null;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'spesialisasi' => $this->spesialisasi,
            'no_hp' => $this->no_hp,
            'poli_id' => $this->poli_id,
            'is_active' => $this->is_active,
        ];

        if ($this->foto) {
            if ($this->fotoLama) {
                \Storage::disk('public')->delete($this->fotoLama);
            }
            $data['foto'] = $this->foto->store('dokter', 'public');
        }

        Dokter::updateOrCreate(['id' => $this->editId], $data);

        $this->showModal = false;
        $this->dispatch('notify', message: $this->editId ? 'Data dokter berhasil diperbarui.' : 'Data dokter berhasil ditambahkan.', type: 'success');
        $this->reset(['editId', 'nama', 'spesialisasi', 'no_hp', 'poli_id', 'foto', 'fotoLama']);
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $dokter = Dokter::findOrFail($this->deleteId);
            if ($dokter->kunjungan()->count() > 0) {
                $this->dispatch('notify', message: 'Tidak dapat menghapus dokter yang memiliki riwayat kunjungan.', type: 'error');
                $this->showDeleteModal = false;
                return;
            }
            if ($dokter->foto) {
                \Storage::disk('public')->delete($dokter->foto);
            }
            $dokter->delete();
            $this->dispatch('notify', message: 'Data dokter berhasil dihapus.', type: 'success');
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $dokter = Dokter::query()
            ->with('poli')
            ->when($this->search, fn($q) => $q->where('nama', 'like', "%{$this->search}%")
                ->orWhere('spesialisasi', 'like', "%{$this->search}%"))
            ->when($this->filterPoli, fn($q) => $q->where('poli_id', $this->filterPoli))
            ->latest()
            ->paginate(10);

        $poliList = Poli::where('is_active', true)->get();

        return view('livewire.dokter.dokter-manager', compact('dokter', 'poliList'));
    }
}
