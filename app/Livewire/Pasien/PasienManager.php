<?php

namespace App\Livewire\Pasien;

use App\Models\Pasien;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Manajemen Pasien')]
class PasienManager extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $editId = null;
    public ?int $deleteId = null;

    public string $nik = '';
    public string $nama = '';
    public string $tgl_lahir = '';
    public string $jenis_kelamin = 'L';
    public string $alamat = '';
    public string $no_hp = '';

    protected function rules(): array
    {
        $id = $this->editId;
        return [
            'nik' => 'required|string|max:20|unique:pasien,nik,' . ($id ?? 'NULL'),
            'nama' => 'required|string|max:100',
            'tgl_lahir' => 'nullable|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string|max:500',
            'no_hp' => 'nullable|string|max:20',
        ];
    }

    protected array $messages = [
        'nik.required' => 'NIK wajib diisi.',
        'nik.unique' => 'NIK sudah terdaftar.',
        'nama.required' => 'Nama pasien wajib diisi.',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'tgl_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
    ];

    public function updatedSearch(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->reset(['editId', 'nik', 'nama', 'tgl_lahir', 'alamat', 'no_hp']);
        $this->jenis_kelamin = 'L';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $pasien = Pasien::findOrFail($id);
        $this->editId = $id;
        $this->nik = $pasien->nik;
        $this->nama = $pasien->nama;
        $this->tgl_lahir = $pasien->tgl_lahir ? $pasien->tgl_lahir->format('Y-m-d') : '';
        $this->jenis_kelamin = $pasien->jenis_kelamin;
        $this->alamat = $pasien->alamat ?? '';
        $this->no_hp = $pasien->no_hp ?? '';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        Pasien::updateOrCreate(
            ['id' => $this->editId],
            [
                'nik' => $this->nik,
                'nama' => $this->nama,
                'tgl_lahir' => $this->tgl_lahir ?: null,
                'jenis_kelamin' => $this->jenis_kelamin,
                'alamat' => $this->alamat,
                'no_hp' => $this->no_hp,
            ]
        );

        $this->showModal = false;
        $this->dispatch('notify', message: $this->editId ? 'Data pasien berhasil diperbarui.' : 'Data pasien berhasil ditambahkan.', type: 'success');
        $this->reset(['editId', 'nik', 'nama', 'tgl_lahir', 'alamat', 'no_hp']);
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $pasien = Pasien::findOrFail($this->deleteId);
            if ($pasien->antrian()->count() > 0 || $pasien->kunjungan()->count() > 0) {
                $this->dispatch('notify', message: 'Tidak dapat menghapus pasien yang memiliki riwayat antrian atau kunjungan.', type: 'error');
                $this->showDeleteModal = false;
                return;
            }
            $pasien->delete();
            $this->dispatch('notify', message: 'Data pasien berhasil dihapus.', type: 'success');
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $pasien = Pasien::query()
            ->when($this->search, fn($q) => $q->where('nama', 'like', "%{$this->search}%")
                ->orWhere('nik', 'like', "%{$this->search}%")
                ->orWhere('no_hp', 'like', "%{$this->search}%"))
            ->withCount('kunjungan')
            ->latest()
            ->paginate(10);

        return view('livewire.pasien.pasien-manager', compact('pasien'));
    }
}
