<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ios-label-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" wire:model.live.debounce.300ms="search" id="search-poli" class="input-ios pl-9" placeholder="Cari nama atau kode poli..." />
        </div>
        <button wire:click="openCreate" id="btn-tambah-poli" class="btn-primary flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Poli
        </button>
    </div>

    <div class="ios-card p-0 overflow-hidden">
        <table class="table-ios">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Poli</th>
                    <th>Deskripsi</th>
                    <th class="text-center">Dokter</th>
                    <th class="text-center">Antrian Hari Ini</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($poli as $p)
                <tr wire:key="poli-{{ $p->id }}">
                    <td><span class="font-mono font-semibold text-ios-blue text-xs bg-ios-blue-light px-2 py-0.5 rounded">{{ $p->kode }}</span></td>
                    <td class="font-medium">{{ $p->nama }}</td>
                    <td class="text-ios-label-secondary max-w-xs truncate">{{ $p->deskripsi ?? '-' }}</td>
                    <td class="text-center"><span class="badge badge-blue">{{ $p->dokter_count }}</span></td>
                    <td class="text-center"><span class="badge badge-gray">{{ $p->antrian_hari_ini_count }}</span></td>
                    <td class="text-center">
                        <button wire:click="toggleActive({{ $p->id }})" class="{{ $p->is_active ? 'badge-green' : 'badge-red' }} badge cursor-pointer hover:opacity-80 transition-opacity">
                            {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button wire:click="openEdit({{ $p->id }})" id="btn-edit-poli-{{ $p->id }}" class="btn-secondary btn-sm">
                                Edit
                            </button>
                            <button wire:click="confirmDelete({{ $p->id }})" id="btn-hapus-poli-{{ $p->id }}" class="btn-danger btn-sm">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-ios-label-secondary">
                        @if($search)
                            Tidak ada poli yang cocok dengan pencarian "{{ $search }}".
                        @else
                            Belum ada data poli.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($poli->hasPages())
        <div class="px-4 py-3 border-t border-ios-separator">
            {{ $poli->links() }}
        </div>
        @endif
    </div>

    @if($showModal)
    <div class="modal-backdrop animate-fade-in" wire:click.self="$set('showModal', false)">
        <div class="modal-box animate-slide-up">
            <div class="modal-header">
                <h3 class="font-semibold text-ios-label">{{ $editId ? 'Edit Poli' : 'Tambah Poli Baru' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-ios-label-secondary hover:text-ios-label">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label for="modal-nama" class="label-ios">Nama Poli</label>
                        <input id="modal-nama" type="text" wire:model.live="nama" class="input-ios @error('nama') input-error @enderror" placeholder="Contoh: Poli Umum" />
                        @error('nama') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="modal-kode" class="label-ios">Kode Poli</label>
                        <input id="modal-kode" type="text" wire:model.live="kode" class="input-ios uppercase @error('kode') input-error @enderror" placeholder="PU" maxlength="10" />
                        @error('kode') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center gap-3 pt-5">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="sr-only peer" id="modal-active">
                            <div class="w-10 h-6 bg-ios-separator rounded-full peer peer-checked:bg-ios-blue transition-colors duration-200"></div>
                            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-4"></div>
                        </label>
                        <label for="modal-active" class="text-sm text-ios-label cursor-pointer">Aktif</label>
                    </div>
                </div>
                <div>
                    <label for="modal-deskripsi" class="label-ios">Deskripsi</label>
                    <textarea id="modal-deskripsi" wire:model="deskripsi" class="input-ios" rows="3" placeholder="Deskripsi poli (opsional)"></textarea>
                    @error('deskripsi') <p class="error-text">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showModal', false)" class="btn-secondary">Batal</button>
                <button wire:click="save" id="btn-simpan-poli" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">{{ $editId ? 'Simpan Perubahan' : 'Tambah Poli' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if($showDeleteModal)
    <div class="modal-backdrop animate-fade-in">
        <div class="modal-box animate-slide-up max-w-sm">
            <div class="modal-header">
                <h3 class="font-semibold text-ios-label">Konfirmasi Hapus</h3>
            </div>
            <div class="modal-body">
                <p class="text-sm text-ios-label-secondary">Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin ingin menghapus data poli ini?</p>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showDeleteModal', false)" class="btn-secondary">Batal</button>
                <button wire:click="delete" id="btn-konfirmasi-hapus-poli" class="btn-danger" wire:loading.attr="disabled" wire:target="delete">
                    <span wire:loading.remove wire:target="delete">Hapus</span>
                    <span wire:loading wire:target="delete">Menghapus...</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
