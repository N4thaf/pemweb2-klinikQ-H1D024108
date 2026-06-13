@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
            <span class="btn-secondary btn-sm opacity-50 cursor-not-allowed">Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn-secondary btn-sm">Sebelumnya</a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn-secondary btn-sm">Berikutnya</a>
        @else
            <span class="btn-secondary btn-sm opacity-50 cursor-not-allowed">Berikutnya</span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-xs text-ios-label-secondary">
                Menampilkan
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                &ndash;
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-medium">{{ $paginator->total() }}</span>
                data
            </p>
        </div>
        <div>
            <span class="relative z-0 inline-flex gap-1">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center px-2.5 py-1.5 text-xs rounded-ios border border-ios-separator text-ios-label-secondary cursor-not-allowed bg-ios-bg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-2.5 py-1.5 text-xs rounded-ios border border-ios-separator text-ios-label hover:bg-ios-blue-light hover:text-ios-blue hover:border-ios-blue transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex items-center px-2.5 py-1.5 text-xs rounded-ios border border-ios-separator text-ios-label-secondary">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="inline-flex items-center px-3 py-1.5 text-xs rounded-ios border border-ios-blue bg-ios-blue text-white font-medium">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="inline-flex items-center px-3 py-1.5 text-xs rounded-ios border border-ios-separator text-ios-label hover:bg-ios-blue-light hover:text-ios-blue hover:border-ios-blue transition-colors">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-2.5 py-1.5 text-xs rounded-ios border border-ios-separator text-ios-label hover:bg-ios-blue-light hover:text-ios-blue hover:border-ios-blue transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                @else
                    <span class="inline-flex items-center px-2.5 py-1.5 text-xs rounded-ios border border-ios-separator text-ios-label-secondary cursor-not-allowed bg-ios-bg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif
