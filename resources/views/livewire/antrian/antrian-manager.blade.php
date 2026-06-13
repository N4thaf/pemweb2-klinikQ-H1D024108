<div class="space-y-5">
    <div class="flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-48">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ios-label-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" wire:model.live.debounce.300ms="search" id="search-antrian" class="input-ios pl-9" placeholder="Cari nama pasien..." />
        </div>
        <input type="date" wire:model.live="filterTanggal" id="filter-tanggal-antrian" class="input-ios w-auto" />
        <select wire:model.live="filterPoli" id="filter-poli-antrian" class="input-ios w-auto">
            <option value="">Semua Poli</option>
            @foreach($poliList as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterStatus" id="filter-status-antrian" class="input-ios w-auto">
            <option value="">Semua Status</option>
            <option value="menunggu">Menunggu</option>
            <option value="dipanggil">Dipanggil</option>
            <option value="sedang_dilayani">Sedang Dilayani</option>
            <option value="selesai">Selesai</option>
        </select>
        <button wire:click="openCreate" id="btn-tambah-antrian" class="btn-primary flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Daftarkan Antrian
        </button>
    </div>

    <div class="ios-card p-0 overflow-hidden">
        <table class="table-ios">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pasien</th>
                    <th>Poli</th>
                    <th>Tanggal</th>
                    <th>Estimasi</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antrian as $a)
                <tr wire:key="antrian-{{ $a->id }}">
                    <td>
                        <div class="w-10 h-10 bg-ios-blue rounded-ios flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ $a->nomor_antrian }}</span>
                        </div>
                    </td>
                    <td class="font-medium">{{ $a->pasien->nama }}</td>
                    <td><span class="badge badge-blue">{{ $a->poli->nama }}</span></td>
                    <td class="text-ios-label-secondary text-xs">{{ $a->tanggal->format('d M Y') }}</td>
                    <td class="text-xs text-ios-label-secondary">
                        @if($a->estimasi_menit)
                            ~{{ $a->estimasi_menit }} mnt
                        @else
                            -
                        @endif
                    </td>
                    <td><span class="{{ $a->status_color }}">{{ $a->status_label }}</span></td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            @if($a->status === 'menunggu')
                                <button wire:click="panggil({{ $a->id }})" id="btn-panggil-{{ $a->id }}" class="btn-secondary btn-sm">Panggil</button>
                            @endif
                            @if($a->status === 'dipanggil')
                                <button wire:click="layani({{ $a->id }})" id="btn-layani-{{ $a->id }}" class="btn-primary btn-sm">Layani</button>
                            @endif
                            @if($a->status === 'sedang_dilayani')
                                <button wire:click="selesai({{ $a->id }})" id="btn-selesai-{{ $a->id }}" class="btn-success btn-sm">Selesai</button>
                            @endif
                            <button wire:click="confirmDelete({{ $a->id }})" id="btn-hapus-antrian-{{ $a->id }}" class="btn-danger btn-sm">Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-ios-label-secondary">Tidak ada data antrian ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($antrian->hasPages())
        <div class="px-4 py-3 border-t border-ios-separator">{{ $antrian->links() }}</div>
        @endif
    </div>

    @if($showModal)
    <div class="modal-backdrop animate-fade-in" wire:click.self="$set('showModal', false)">
        <div class="modal-box animate-slide-up">
            <div class="modal-header">
                <h3 class="font-semibold text-ios-label">Daftarkan Antrian Baru</h3>
                <button wire:click="$set('showModal', false)" class="text-ios-label-secondary hover:text-ios-label">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <div>
                    <label for="modal-poli-antrian" class="label-ios">Poli Tujuan</label>
                    <select id="modal-poli-antrian" wire:model="poli_id" class="input-ios @error('poli_id') input-error @enderror">
                        <option value="">Pilih Poli</option>
                        @foreach($poliList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    @error('poli_id') <p class="error-text">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="modal-pasien-antrian" class="label-ios">Pasien</label>
                    <select id="modal-pasien-antrian" wire:model="pasien_id" class="input-ios @error('pasien_id') input-error @enderror">
                        <option value="">Pilih Pasien</option>
                        @foreach($pasienList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }} — {{ $p->nik }}</option>
                        @endforeach
                    </select>
                    @error('pasien_id') <p class="error-text">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="modal-tanggal-antrian" class="label-ios">Tanggal</label>
                    <input id="modal-tanggal-antrian" type="date" wire:model="tanggal" class="input-ios @error('tanggal') input-error @enderror" />
                    @error('tanggal') <p class="error-text">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showModal', false)" class="btn-secondary">Batal</button>
                <button wire:click="save" id="btn-simpan-antrian" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">Daftarkan</span>
                    <span wire:loading wire:target="save">Memproses...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if($showDeleteModal)
    <div class="modal-backdrop animate-fade-in">
        <div class="modal-box animate-slide-up max-w-sm">
            <div class="modal-header"><h3 class="font-semibold text-ios-label">Konfirmasi Hapus</h3></div>
            <div class="modal-body"><p class="text-sm text-ios-label-secondary">Apakah Anda yakin ingin menghapus data antrian ini?</p></div>
            <div class="modal-footer">
                <button wire:click="$set('showDeleteModal', false)" class="btn-secondary">Batal</button>
                <button wire:click="delete" id="btn-konfirmasi-hapus-antrian" class="btn-danger">Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>
