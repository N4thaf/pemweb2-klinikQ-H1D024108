<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ios-label-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" wire:model.live.debounce.300ms="search" id="search-pasien" class="input-ios pl-9" placeholder="Cari nama, NIK, atau nomor HP..." />
        </div>
        <button wire:click="openCreate" id="btn-tambah-pasien" class="btn-primary flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Pasien
        </button>
    </div>

    <div class="ios-card p-0 overflow-hidden">
        <table class="table-ios">
            <thead>
                <tr>
                    <th>Nama Pasien</th>
                    <th>NIK</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>No. HP</th>
                    <th>Kunjungan</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pasien as $p)
                <tr wire:key="pasien-{{ $p->id }}">
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $p->jenis_kelamin === 'L' ? 'bg-ios-blue-light' : 'bg-pink-100' }}">
                                <span class="text-xs font-bold {{ $p->jenis_kelamin === 'L' ? 'text-ios-blue' : 'text-pink-500' }}">{{ strtoupper(substr($p->nama, 0, 2)) }}</span>
                            </div>
                            <span class="font-medium text-ios-label">{{ $p->nama }}</span>
                        </div>
                    </td>
                    <td class="font-mono text-xs text-ios-label-secondary">{{ $p->nik }}</td>
                    <td><span class="badge {{ $p->jenis_kelamin === 'L' ? 'badge-blue' : 'bg-pink-100 text-pink-500 badge' }}">{{ $p->jenis_kelamin_label }}</span></td>
                    <td class="text-ios-label-secondary text-xs">
                        {{ $p->tgl_lahir ? $p->tgl_lahir->format('d M Y') : '-' }}
                        @if($p->tgl_lahir)<span class="text-ios-label-secondary"> ({{ $p->umur }} th)</span>@endif
                    </td>
                    <td class="text-ios-label-secondary text-xs">{{ $p->no_hp ?? '-' }}</td>
                    <td><span class="badge badge-gray">{{ $p->kunjungan_count }}</span></td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button wire:click="openEdit({{ $p->id }})" id="btn-edit-pasien-{{ $p->id }}" class="btn-secondary btn-sm">Edit</button>
                            <button wire:click="confirmDelete({{ $p->id }})" id="btn-hapus-pasien-{{ $p->id }}" class="btn-danger btn-sm">Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-ios-label-secondary">
                        @if($search) Tidak ada pasien yang cocok dengan "{{ $search }}". @else Belum ada data pasien. @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($pasien->hasPages())
        <div class="px-4 py-3 border-t border-ios-separator">{{ $pasien->links() }}</div>
        @endif
    </div>

    @if($showModal)
    <div class="modal-backdrop animate-fade-in" wire:click.self="$set('showModal', false)">
        <div class="modal-box animate-slide-up">
            <div class="modal-header">
                <h3 class="font-semibold text-ios-label">{{ $editId ? 'Edit Pasien' : 'Tambah Pasien Baru' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-ios-label-secondary hover:text-ios-label">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label for="modal-nama-pasien" class="label-ios">Nama Lengkap</label>
                        <input id="modal-nama-pasien" type="text" wire:model.live="nama" class="input-ios @error('nama') input-error @enderror" placeholder="Nama lengkap pasien" />
                        @error('nama') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="modal-nik" class="label-ios">NIK (KTP)</label>
                        <input id="modal-nik" type="text" wire:model.live="nik" class="input-ios font-mono @error('nik') input-error @enderror" placeholder="16 digit NIK" maxlength="16" />
                        @error('nik') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="modal-tgl-lahir" class="label-ios">Tanggal Lahir</label>
                        <input id="modal-tgl-lahir" type="date" wire:model="tgl_lahir" class="input-ios @error('tgl_lahir') input-error @enderror" />
                        @error('tgl_lahir') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label-ios">Jenis Kelamin</label>
                        <div class="flex gap-3 mt-1.5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="jenis_kelamin" value="L" class="text-ios-blue focus:ring-ios-blue" id="jk-l" />
                                <span class="text-sm text-ios-label">Laki-laki</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="jenis_kelamin" value="P" class="text-pink-500 focus:ring-pink-500" id="jk-p" />
                                <span class="text-sm text-ios-label">Perempuan</span>
                            </label>
                        </div>
                        @error('jenis_kelamin') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="modal-nohp-pasien" class="label-ios">No. HP</label>
                        <input id="modal-nohp-pasien" type="text" wire:model="no_hp" class="input-ios" placeholder="08xxxxxxxxxx" />
                    </div>
                    <div class="col-span-2">
                        <label for="modal-alamat" class="label-ios">Alamat</label>
                        <textarea id="modal-alamat" wire:model="alamat" class="input-ios" rows="2" placeholder="Alamat lengkap"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showModal', false)" class="btn-secondary">Batal</button>
                <button wire:click="save" id="btn-simpan-pasien" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">{{ $editId ? 'Simpan Perubahan' : 'Tambah Pasien' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if($showDeleteModal)
    <div class="modal-backdrop animate-fade-in">
        <div class="modal-box animate-slide-up max-w-sm">
            <div class="modal-header"><h3 class="font-semibold text-ios-label">Konfirmasi Hapus</h3></div>
            <div class="modal-body"><p class="text-sm text-ios-label-secondary">Apakah Anda yakin ingin menghapus data pasien ini?</p></div>
            <div class="modal-footer">
                <button wire:click="$set('showDeleteModal', false)" class="btn-secondary">Batal</button>
                <button wire:click="delete" id="btn-konfirmasi-hapus-pasien" class="btn-danger">Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>
