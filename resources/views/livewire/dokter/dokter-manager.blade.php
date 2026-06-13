<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ios-label-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" wire:model.live.debounce.300ms="search" id="search-dokter" class="input-ios pl-9" placeholder="Cari nama atau spesialisasi..." />
        </div>
        <select wire:model.live="filterPoli" id="filter-poli-dokter" class="input-ios w-auto flex-shrink-0">
            <option value="">Semua Poli</option>
            @foreach($poliList as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
            @endforeach
        </select>
        <button wire:click="openCreate" id="btn-tambah-dokter" class="btn-primary flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Dokter
        </button>
    </div>

    <div class="ios-card p-0 overflow-hidden">
        <table class="table-ios">
            <thead>
                <tr>
                    <th>Dokter</th>
                    <th>Spesialisasi</th>
                    <th>Poli</th>
                    <th>No. HP</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dokter as $d)
                <tr wire:key="dokter-{{ $d->id }}">
                    <td>
                        <div class="flex items-center gap-3">
                            @if($d->foto)
                                <img src="{{ asset('storage/' . $d->foto) }}" alt="{{ $d->nama }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0" />
                            @else
                                <div class="w-9 h-9 bg-ios-blue-light rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-ios-blue text-xs font-bold">{{ strtoupper(substr($d->nama, 0, 2)) }}</span>
                                </div>
                            @endif
                            <span class="font-medium text-ios-label">{{ $d->nama }}</span>
                        </div>
                    </td>
                    <td class="text-ios-label-secondary">{{ $d->spesialisasi }}</td>
                    <td><span class="badge badge-blue">{{ $d->poli->nama ?? '-' }}</span></td>
                    <td class="text-ios-label-secondary text-xs">{{ $d->no_hp ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $d->is_active ? 'badge-green' : 'badge-red' }}">
                            {{ $d->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button wire:click="openEdit({{ $d->id }})" id="btn-edit-dokter-{{ $d->id }}" class="btn-secondary btn-sm">Edit</button>
                            <button wire:click="confirmDelete({{ $d->id }})" id="btn-hapus-dokter-{{ $d->id }}" class="btn-danger btn-sm">Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-ios-label-secondary">
                        @if($search || $filterPoli)
                            Tidak ada dokter yang cocok dengan filter yang dipilih.
                        @else
                            Belum ada data dokter.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($dokter->hasPages())
        <div class="px-4 py-3 border-t border-ios-separator">
            {{ $dokter->links() }}
        </div>
        @endif
    </div>

    @if($showModal)
    <div class="modal-backdrop animate-fade-in" wire:click.self="$set('showModal', false)">
        <div class="modal-box animate-slide-up">
            <div class="modal-header">
                <h3 class="font-semibold text-ios-label">{{ $editId ? 'Edit Dokter' : 'Tambah Dokter Baru' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-ios-label-secondary hover:text-ios-label">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label for="modal-nama-dokter" class="label-ios">Nama Dokter</label>
                        <input id="modal-nama-dokter" type="text" wire:model.live="nama" class="input-ios @error('nama') input-error @enderror" placeholder="dr. Nama Dokter" />
                        @error('nama') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="modal-spesialisasi" class="label-ios">Spesialisasi</label>
                        <input id="modal-spesialisasi" type="text" wire:model.live="spesialisasi" class="input-ios @error('spesialisasi') input-error @enderror" placeholder="Dokter Umum" />
                        @error('spesialisasi') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="modal-poli-dokter" class="label-ios">Poli</label>
                        <select id="modal-poli-dokter" wire:model="poli_id" class="input-ios @error('poli_id') input-error @enderror">
                            <option value="">Pilih Poli</option>
                            @foreach($poliList as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        @error('poli_id') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="modal-nohp-dokter" class="label-ios">No. HP</label>
                        <input id="modal-nohp-dokter" type="text" wire:model="no_hp" class="input-ios" placeholder="08xxxxxxxxxx" />
                    </div>
                    <div class="flex items-center gap-3 pt-5">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="sr-only peer" id="modal-active-dokter">
                            <div class="w-10 h-6 bg-ios-separator rounded-full peer peer-checked:bg-ios-blue transition-colors duration-200"></div>
                            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-4"></div>
                        </label>
                        <label for="modal-active-dokter" class="text-sm text-ios-label cursor-pointer">Dokter Aktif</label>
                    </div>
                </div>
                <div>
                    <label for="modal-foto" class="label-ios">Foto Profil</label>
                    @if($fotoLama && !$foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $fotoLama) }}" alt="Foto saat ini" class="w-16 h-16 rounded-ios object-cover" />
                            <p class="text-xs text-ios-label-secondary mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
                        </div>
                    @endif
                    @if($foto)
                        <div class="mb-2">
                            <img src="{{ $foto->temporaryUrl() }}" alt="Preview" class="w-16 h-16 rounded-ios object-cover" />
                            <p class="text-xs text-ios-green mt-1">Foto baru siap diupload.</p>
                        </div>
                    @endif
                    <input id="modal-foto" type="file" wire:model="foto" accept="image/*" class="input-ios text-sm file:mr-3 file:py-1 file:px-3 file:rounded-ios file:border-0 file:bg-ios-blue-light file:text-ios-blue file:text-xs file:font-medium cursor-pointer" />
                    @error('foto') <p class="error-text">{{ $message }}</p> @enderror
                    <div wire:loading wire:target="foto">
                        <p class="text-xs text-ios-blue mt-1">Mengunggah...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showModal', false)" class="btn-secondary">Batal</button>
                <button wire:click="save" id="btn-simpan-dokter" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">{{ $editId ? 'Simpan Perubahan' : 'Tambah Dokter' }}</span>
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
                <p class="text-sm text-ios-label-secondary">Apakah Anda yakin ingin menghapus data dokter ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showDeleteModal', false)" class="btn-secondary">Batal</button>
                <button wire:click="delete" id="btn-konfirmasi-hapus-dokter" class="btn-danger">Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>
