@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-1.5">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" class="w-9 h-9 rounded-lg bg-slate-50 text-slate-300 border border-slate-200/80 flex items-center justify-center text-xs cursor-not-allowed select-none">
                <i class="ti ti-chevron-left text-base"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-9 h-9 rounded-lg bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/90 flex items-center justify-center text-xs transition shadow-2xs hover:text-emerald-700 select-none cursor-pointer" aria-label="Halaman Sebelumnya">
                <i class="ti ti-chevron-left text-base"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span aria-disabled="true" class="w-9 h-9 rounded-lg flex items-center justify-center text-xs text-slate-400 font-bold select-none">
                    {{ $element }}
                </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="w-9 h-9 rounded-lg bg-emerald-600 text-white font-black text-xs flex items-center justify-center shadow-xs select-none">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="w-9 h-9 rounded-lg bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/90 flex items-center justify-center text-xs font-bold transition shadow-2xs hover:text-emerald-700 hover:border-emerald-200 select-none cursor-pointer" aria-label="Halaman {{ $page }}">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-9 h-9 rounded-lg bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/90 flex items-center justify-center text-xs transition shadow-2xs hover:text-emerald-700 select-none cursor-pointer" aria-label="Halaman Berikutnya">
                <i class="ti ti-chevron-right text-base"></i>
            </a>
        @else
            <span aria-disabled="true" class="w-9 h-9 rounded-lg bg-slate-50 text-slate-300 border border-slate-200/80 flex items-center justify-center text-xs cursor-not-allowed select-none">
                <i class="ti ti-chevron-right text-base"></i>
            </span>
        @endif
    </nav>
@endif
