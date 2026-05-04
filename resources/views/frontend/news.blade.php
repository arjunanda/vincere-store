@extends('layouts.frontend')

@section('title', 'Promo & Berita -')

@section('body_attr')
x-data="newsPage()"
@endsection

@php
    $newsData = $articles->map(fn($a) => [
        'id' => $a->id,
        'title' => $a->title,
        'category' => $a->type,
        'date' => $a->created_at->translatedFormat('d M Y'),
        'image' => asset('storage/' . $a->image),
        'excerpt' => Str::limit(strip_tags($a->content), 120),
        'slug' => $a->slug
    ]);
@endphp

@section('body_attr')
x-data="newsPage()"
@endsection

@push('scripts')
<script>
    function newsPage() {
        return {
            category: 'all',
            articles: @json($newsData)
        }
    }
</script>
@endpush

@section('main_class', 'max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-24 space-y-16')

@section('content')
<!-- Header -->
<div class="text-center space-y-6 max-w-3xl mx-auto">
    <h1 class="text-4xl md:text-7xl font-black tracking-tighter italic metallic-text uppercase leading-none">
        Promo & <span class="text-brand-red">Berita</span>
    </h1>
    <p class="text-gray-500 text-base md:text-xl font-medium leading-relaxed">
        Tetap terupdate dengan penawaran eksklusif dan informasi terbaru seputar dunia gaming dari Ventuz Store.
    </p>
</div>

<!-- Filter Tab -->
<div class="flex justify-center">
    <div class="flex p-1.5 glass-dark rounded-xl border border-white/5 gap-1.5">
        <button @click="category = 'all'" 
            :class="category === 'all' ? 'btn-metal shadow-lg' : 'text-gray-500 hover:text-white hover:bg-white/5'" 
            class="px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300">
            Semua
        </button>
        <button @click="category = 'promo'" 
            :class="category === 'promo' ? 'btn-metal shadow-lg' : 'text-gray-500 hover:text-white hover:bg-white/5'" 
            class="px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300">
            Promo
        </button>
        <button @click="category = 'berita'" 
            :class="category === 'berita' ? 'btn-metal shadow-lg' : 'text-gray-500 hover:text-white hover:bg-white/5'" 
            class="px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300">
            Berita
        </button>
    </div>
</div>

<!-- News Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
    <template x-for="article in articles" :key="article.id">
        <div x-show="category === 'all' || article.category === category"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0">
            
            <a :href="'/news/' + article.slug" class="block metal-card rounded-xl overflow-hidden group h-full flex flex-col">
                <!-- Image Wrap -->
                <div class="relative aspect-video overflow-hidden">
                    <img :src="article.image" :alt="article.title" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                    <div class="absolute top-6 left-6">
                        <div class="glass-dark px-4 py-2 rounded-lg border border-white/10 group-hover:border-brand-red/50 transition-colors shadow-2xl">
                            <p class="text-[10px] text-white font-black uppercase tracking-widest" x-text="article.category"></p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8 flex-1 flex flex-col space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-brand-red"></div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-500" x-text="article.date"></p>
                    </div>
                    <div class="space-y-4 flex-1">
                        <h4 class="text-xl md:text-2xl font-black italic uppercase tracking-tighter leading-tight group-hover:text-brand-red transition-colors item-title line-clamp-2" x-text="article.title"></h4>
                        <p class="text-gray-400 text-sm leading-relaxed line-clamp-3" x-text="article.excerpt"></p>
                    </div>

                    <!-- Read More Button -->
                    <div class="pt-6 border-t border-white/5 flex items-center justify-between group/btn">
                        <span class="text-[10px] font-black uppercase tracking-widest text-white group-hover/btn:text-brand-red transition-colors">Selengkapnya</span>
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover/btn:bg-brand-red transition-all duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </template>
</div>
@endsection
