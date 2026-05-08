@if ($paginator->hasPages())
<div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-6 py-4 border-t border-white/5">
    {{-- Info --}}
    <p class="text-[10px] font-bold text-gray-600 uppercase tracking-widest">
        Menampilkan
        <span class="text-gray-400">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</span>
        dari
        <span class="text-gray-400">{{ $paginator->total() }}</span>
        data
    </p>

    {{-- Buttons --}}
    <div class="flex items-center gap-1">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-[10px] font-black uppercase tracking-widest text-gray-700 cursor-not-allowed select-none">
                &laquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-white border border-white/5 hover:border-white/20 rounded-lg transition-all">
                &laquo;
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-2 text-[10px] font-black text-gray-700">…</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 text-[10px] font-black uppercase tracking-widest text-white bg-brand-neon/90 border border-brand-neon rounded-lg min-w-[36px] text-center">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-2 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-white border border-white/5 hover:border-white/20 rounded-lg transition-all min-w-[36px] text-center">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-white border border-white/5 hover:border-white/20 rounded-lg transition-all">
                &raquo;
            </a>
        @else
            <span class="px-3 py-2 text-[10px] font-black uppercase tracking-widest text-gray-700 cursor-not-allowed select-none">
                &raquo;
            </span>
        @endif
    </div>
</div>
@endif
