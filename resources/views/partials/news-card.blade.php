@php
    $isFeatured = $isFeatured ?? false;
@endphp

@if($isFeatured)
    <a href="{{ route('news.detail', $article->slug) }}"
        class="group flex flex-col h-auto lg:h-80 md:flex-row gap-0 metal-card rounded-2xl overflow-hidden transition-all duration-300 mb-6">
        
        {{-- Image --}}
        <div class="md:w-1/2 aspect-video md:aspect-auto overflow-hidden relative">
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-r from-transparent to-[#1a1d27]/60 hidden md:block"></div>
            <div class="absolute top-4 left-4">
                <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg border"
                    style="background:rgba(0,0,0,0.6); border-color:rgba(255,255,255,0.1); color:rgba(255,255,255,0.8);">
                    {{ $article->type }}
                </span>
            </div>
        </div>

        {{-- Info --}}
        <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-between gap-4">
            <div class="space-y-3">
                <p class="text-[10px] font-bold text-brand-neon uppercase tracking-widest flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-neon inline-block"></span>
                    <span>{{ $article->created_at->translatedFormat('d M Y') }}</span>
                </p>
                <h2 class="text-xl md:text-2xl font-black text-white uppercase leading-tight group-hover:text-brand-neon transition-colors line-clamp-3">
                    {{ $article->title }}
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed line-clamp-3">
                    {{ Str::limit(strip_tags($article->content), 120) }}
                </p>
            </div>
            <div class="flex items-center gap-2 text-[12px] font-bold text-brand-neon uppercase tracking-wide">
                <span>Baca Selengkapnya</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </div>
        </div>
    </a>
@else
    <a href="{{ route('news.detail', $article->slug) }}"
        class="group flex flex-col metal-card rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 h-full">

        {{-- Image --}}
        <div class="relative aspect-video overflow-hidden">
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                loading="lazy">
            <div class="absolute top-3 left-3">
                <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg border"
                    style="background:rgba(0,0,0,0.6); border-color:rgba(255,255,255,0.1); color:rgba(255,255,255,0.7);">
                    {{ $article->type }}
                </span>
            </div>
        </div>

        {{-- Info --}}
        <div class="p-4 flex flex-col gap-2.5 flex-1">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-brand-neon inline-block"></span>
                <span>{{ $article->created_at->translatedFormat('d M Y') }}</span>
            </p>
            <h4 class="text-[14px] font-black text-white uppercase leading-snug line-clamp-2 group-hover:text-brand-neon transition-colors">
                {{ $article->title }}
            </h4>
            <p class="text-gray-500 text-[12px] leading-relaxed line-clamp-2 flex-1">
                {{ Str::limit(strip_tags($article->content), 120) }}
            </p>
            <div class="flex items-center justify-between pt-3 border-t border-white/[0.06]">
                <span class="text-[11px] font-bold text-gray-500 group-hover:text-brand-neon transition-colors uppercase tracking-wide">Selengkapnya</span>
                <div class="w-7 h-7 rounded-lg bg-white/[0.04] border border-white/[0.07] flex items-center justify-center group-hover:bg-brand-neon group-hover:border-transparent transition-all duration-200">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </div>
    </a>
@endif
