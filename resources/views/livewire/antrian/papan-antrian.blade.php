<div class="min-h-screen bg-ios-bg text-ios-label">
    <header class="bg-white border-b border-ios-separator px-6 py-4 shadow-ios">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-ios-blue rounded-ios flex items-center justify-center shadow-ios">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-brand font-semibold text-ios-label text-xl leading-none">Papan Antrian KlinikQ</h1>
                    <p class="text-xs text-ios-label-secondary mt-1">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <select wire:model.live="filterPoli" id="filter-poli-papan" class="input-ios w-auto text-sm">
                    <option value="">Semua Poli</option>
                    @foreach($poliList as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
                <div class="text-right">
                    <p class="text-ios-label font-mono text-xl font-semibold" id="papan-jam">{{ now()->format('H:i:s') }}</p>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 py-6">
        @if($sedangDilayani->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-xs font-semibold text-ios-label-secondary uppercase tracking-widest mb-4">Sedang Dilayani</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($sedangDilayani as $item)
                <div class="bg-ios-blue rounded-ios-xl p-5 shadow-ios-md" wire:key="aktif-{{ $item->id }}">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-white/90 text-xs font-semibold uppercase tracking-wide">{{ $item->poli->nama }}</span>
                        <span class="text-xs bg-white/25 text-white px-2 py-0.5 rounded-full font-medium">
                            {{ $item->status === 'dipanggil' ? 'Dipanggil' : 'Dilayani' }}
                        </span>
                    </div>
                    <div class="text-6xl font-bold text-white leading-none mb-3">{{ str_pad($item->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</div>
                    <p class="text-white/90 font-medium truncate text-sm">{{ $item->pasien->nama }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($antrian->isEmpty())
        <div class="text-center py-24">
            <div class="w-20 h-20 bg-ios-blue-light rounded-ios-xl flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-ios-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
            <p class="text-ios-label-secondary text-lg">Tidak ada antrian hari ini.</p>
        </div>
        @else
        @foreach($antrian as $poliId => $items)
        @php $poliNama = $items->first()->poli->nama; @endphp
        <div class="mb-8" wire:key="poli-group-{{ $poliId }}">
            <h2 class="text-xs font-semibold text-ios-label-secondary uppercase tracking-widest mb-4">{{ $poliNama }}</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($items as $item)
                <div class="rounded-ios p-3 text-center border transition-all duration-300
                    {{ $item->status === 'selesai'
                        ? 'bg-ios-separator/30 border-ios-separator opacity-60'
                        : ($item->status === 'menunggu'
                            ? 'bg-white border-ios-separator shadow-ios'
                            : 'bg-ios-blue-light border-ios-blue shadow-ios') }}"
                    wire:key="item-{{ $item->id }}">
                    <div class="text-3xl font-bold leading-none mb-1
                        {{ $item->status === 'selesai' ? 'text-ios-label-secondary' : 'text-ios-label' }}">
                        {{ str_pad($item->nomor_antrian, 3, '0', STR_PAD_LEFT) }}
                    </div>
                    <p class="text-xs truncate mb-1.5
                        {{ $item->status === 'selesai' ? 'text-ios-label-secondary/60' : 'text-ios-label-secondary' }}">
                        {{ $item->pasien->nama }}
                    </p>
                    <div>
                        @if($item->status === 'selesai')
                            <span class="text-xs bg-ios-separator/50 text-ios-label-secondary px-1.5 py-0.5 rounded-full">Selesai</span>
                        @elseif($item->status === 'menunggu')
                            <span class="text-xs bg-ios-bg text-ios-label-secondary px-1.5 py-0.5 rounded-full border border-ios-separator">Menunggu</span>
                        @else
                            <span class="text-xs bg-ios-blue text-white px-1.5 py-0.5 rounded-full font-medium">Dipanggil</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <script>
        function updateClock() {
            const el = document.getElementById('papan-jam');
            if (el) {
                el.textContent = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false});
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</div>
