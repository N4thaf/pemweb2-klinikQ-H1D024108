<div class="space-y-5">
    <div class="flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-48">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ios-label-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" wire:model.live.debounce.300ms="search" id="search-kunjungan" class="input-ios pl-9" placeholder="Cari nama pasien..." />
        </div>
        <input type="date" wire:model.live="filterTanggal" id="filter-tanggal-kunjungan" class="input-ios w-auto" />
        <select wire:model.live="filterDokter" id="filter-dokter-kunjungan" class="input-ios w-auto">
            <option value="">Semua Dokter</option>
            @foreach($dokterList as $d)
                <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
        </select>
        <button wire:click="openCreate" id="btn-tambah-kunjungan" class="btn-primary flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Catat Kunjungan
        </button>
    </div>

    <div class="ios-card p-0 overflow-hidden">
        <table class="table-ios">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Poli</th>
                    <th>Keluhan</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kunjungan as $k)
                <tr wire:key="kunjungan-{{ $k->id }}">
                    <td class="text-ios-label-secondary text-xs whitespace-nowrap">{{ $k->tanggal->format('d M Y') }}</td>
                    <td class="font-medium">{{ $k->pasien->nama }}</td>
                    <td class="text-ios-label-secondary text-sm">{{ $k->dokter->nama }}</td>
                    <td><span class="badge badge-blue">{{ $k->dokter->poli->nama ?? '-' }}</span></td>
                    <td class="text-ios-label-secondary text-sm max-w-xs truncate">{{ $k->keluhan }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <button wire:click="openDetail({{ $k->id }})" id="btn-detail-kunjungan-{{ $k->id }}" class="btn-secondary btn-sm">Detail</button>
                            <button wire:click="openEdit({{ $k->id }})" id="btn-edit-kunjungan-{{ $k->id }}" class="btn-secondary btn-sm">Edit</button>
                            <button wire:click="confirmDelete({{ $k->id }})" id="btn-hapus-kunjungan-{{ $k->id }}" class="btn-danger btn-sm">Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-ios-label-secondary">Belum ada data kunjungan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($kunjungan->hasPages())
        <div class="px-4 py-3 border-t border-ios-separator">{{ $kunjungan->links() }}</div>
        @endif
    </div>

    @if($showModal)
    <div class="modal-backdrop animate-fade-in" wire:click.self="$set('showModal', false)">
        <div class="modal-box animate-slide-up">
            <div class="modal-header">
                <h3 class="font-semibold text-ios-label">{{ $editId ? 'Edit Kunjungan' : 'Catat Kunjungan Baru' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-ios-label-secondary hover:text-ios-label">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="modal-pasien-kunjungan" class="label-ios">Pasien</label>
                        <select id="modal-pasien-kunjungan" wire:model="pasien_id" class="input-ios @error('pasien_id') input-error @enderror">
                            <option value="">Pilih Pasien</option>
                            @foreach($pasienList as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        @error('pasien_id') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="modal-dokter-kunjungan" class="label-ios">Dokter</label>
                        <select id="modal-dokter-kunjungan" wire:model="dokter_id" class="input-ios @error('dokter_id') input-error @enderror">
                            <option value="">Pilih Dokter</option>
                            @foreach($dokterList as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }} ({{ $d->poli->nama ?? '' }})</option>
                            @endforeach
                        </select>
                        @error('dokter_id') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="modal-tanggal-kunjungan" class="label-ios">Tanggal Kunjungan</label>
                        <input id="modal-tanggal-kunjungan" type="date" wire:model="tanggal" class="input-ios @error('tanggal') input-error @enderror" />
                        @error('tanggal') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="modal-keluhan" class="label-ios">Keluhan</label>
                        <textarea id="modal-keluhan" wire:model="keluhan" class="input-ios @error('keluhan') input-error @enderror" rows="2" placeholder="Keluhan yang disampaikan pasien"></textarea>
                        @error('keluhan') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="modal-diagnosis" class="label-ios">Diagnosis</label>
                        <textarea id="modal-diagnosis" wire:model="diagnosis" class="input-ios" rows="2" placeholder="Diagnosis singkat (opsional)"></textarea>
                    </div>
                    <div class="col-span-2">
                        <label for="modal-catatan" class="label-ios">Catatan</label>
                        <textarea id="modal-catatan" wire:model="catatan" class="input-ios" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showModal', false)" class="btn-secondary">Batal</button>
                <button wire:click="save" id="btn-simpan-kunjungan" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">{{ $editId ? 'Simpan Perubahan' : 'Catat Kunjungan' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if($showDetailModal && $detailRecord)
    <div class="modal-backdrop animate-fade-in" wire:click.self="$set('showDetailModal', false)">
        <div class="modal-box animate-slide-up">
            <div class="modal-header">
                <h3 class="font-semibold text-ios-label">Detail Kunjungan</h3>
                <button wire:click="$set('showDetailModal', false)" class="text-ios-label-secondary hover:text-ios-label">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="label-ios">Tanggal</p><p class="text-ios-label font-medium">{{ $detailRecord->tanggal->format('d F Y') }}</p></div>
                    <div><p class="label-ios">Pasien</p><p class="text-ios-label font-medium">{{ $detailRecord->pasien->nama }}</p></div>
                    <div><p class="label-ios">Dokter</p><p class="text-ios-label font-medium">{{ $detailRecord->dokter->nama }}</p></div>
                    <div><p class="label-ios">Poli</p><p class="text-ios-label font-medium">{{ $detailRecord->dokter->poli->nama ?? '-' }}</p></div>
                    <div class="col-span-2"><p class="label-ios">Keluhan</p><p class="text-ios-label">{{ $detailRecord->keluhan }}</p></div>
                    <div class="col-span-2"><p class="label-ios">Diagnosis</p><p class="text-ios-label">{{ $detailRecord->diagnosis ?? '-' }}</p></div>
                    <div class="col-span-2"><p class="label-ios">Catatan</p><p class="text-ios-label">{{ $detailRecord->catatan ?? '-' }}</p></div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showDetailModal', false)" class="btn-secondary">Tutup</button>
            </div>
        </div>
    </div>
    @endif

    @if($showDeleteModal)
    <div class="modal-backdrop animate-fade-in">
        <div class="modal-box animate-slide-up max-w-sm">
            <div class="modal-header"><h3 class="font-semibold text-ios-label">Konfirmasi Hapus</h3></div>
            <div class="modal-body"><p class="text-sm text-ios-label-secondary">Apakah Anda yakin ingin menghapus data kunjungan ini?</p></div>
            <div class="modal-footer">
                <button wire:click="$set('showDeleteModal', false)" class="btn-secondary">Batal</button>
                <button wire:click="delete" id="btn-konfirmasi-hapus-kunjungan" class="btn-danger">Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>
