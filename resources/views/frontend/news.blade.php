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

@push('scripts')
<script>
    function newsPage() {
        return {
            category: 'all',
            initialArticles: @json($newsData),
            extraArticles: [],
            nextPage: '{{ $articles->nextPageUrl() }}',
            loading: false,

            get filteredInitialCount() {
                return this.initialArticles.filter(a => this.category === 'all' || a.category === this.category).length;
            },

            get filteredExtraCount() {
                return this.extraArticles.filter(a => this.category === 'all' || a.category === this.category).length;
            },

            get totalVisible() {
                return this.filteredInitialCount + this.filteredExtraCount;
            },

            async loadMore() {
                if (!this.nextPage || this.loading) return;
                this.loading = true;
                try {
                    const response = await fetch(this.nextPage, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const result = await response.json();
                    this.extraArticles = [...this.extraArticles, ...result.data];
                    this.nextPage = result.next_page_url;
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endpush

@section('main_class', 'max-w-7xl mx-auto px-4 md:px-6 py-10 md:py-16 space-y-10')

@section('content')

    {{-- ── Header ── --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-brand-neon mb-2">Update Terbaru</p>
            <h1 class="text-4xl md:text-5xl font-black tracking-tighter uppercase leading-none text-white">
                Promo & <span class="text-brand-neon">Berita</span>
            </h1>
            <p class="text-gray-500 text-sm mt-3 font-medium max-w-md leading-relaxed">
                Penawaran eksklusif dan info terbaru seputar dunia gaming.
            </p>
        </div>

        {{-- Filter Tabs --}}
        <div class="flex items-center gap-1.5 flex-shrink-0 flex-wrap">
            @foreach([
                ['val' => 'all',    'label' => 'Semua'],
                ['val' => 'promo',  'label' => 'Promo'],
                ['val' => 'berita', 'label' => 'Berita'],
            ] as $tab)
                <button @click="category = '{{ $tab['val'] }}'"
                    :class="category === '{{ $tab['val'] }}'
                        ? 'bg-brand-neon text-black border-transparent'
                        : 'bg-white/[0.03] text-gray-400 border-white/[0.07] hover:text-white hover:bg-white/[0.07]'"
                    class="px-5 py-2 rounded-xl border text-[12px] font-bold uppercase tracking-wide transition-all duration-200">
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- ── Featured + Grid ── --}}
    <div>
        {{-- SSR Initial Articles --}}
        @php $featuredArticle = $articles->first(); $remainingArticles = $articles->slice(1); @endphp
        
        @if($featuredArticle)
            <div x-show="category === 'all' || '{{ $featuredArticle->type }}' === category"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">
                @include('partials.news-card', ['article' => $featuredArticle, 'isFeatured' => true])
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($remainingArticles as $article)
                <div x-show="category === 'all' || '{{ $article->type }}' === category"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">
                    @include('partials.news-card', ['article' => $article, 'isFeatured' => false])
                </div>
            @endforeach
        </div>

        {{-- Extra Articles (Loaded via AJAX) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            <template x-for="article in extraArticles" :key="article.id">
                <div x-show="category === 'all' || article.category === category"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">

                    <a :href="'/news/' + article.slug"
                        class="group flex flex-col metal-card rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 h-full">

                        {{-- Image --}}
                        <div class="relative aspect-video overflow-hidden">
                            <img :src="article.image" :alt="article.title"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                loading="lazy">
                            <div class="absolute top-3 left-3">
                                <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg border"
                                    style="background:rgba(0,0,0,0.6); border-color:rgba(255,255,255,0.1); color:rgba(255,255,255,0.7);"
                                    x-text="article.category"></span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="p-4 flex flex-col gap-2.5 flex-1">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest flex items-center gap-1.5">
                                <span class="w-1 h-1 rounded-full bg-brand-neon inline-block"></span>
                                <span x-text="article.date"></span>
                            </p>
                            <h4 class="text-[14px] font-black text-white uppercase leading-snug line-clamp-2 group-hover:text-brand-neon transition-colors"
                                x-text="article.title"></h4>
                            <p class="text-gray-500 text-[12px] leading-relaxed line-clamp-2 flex-1"
                                x-text="article.excerpt"></p>
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
                </div>
            </template>
        </div>
    </div>

    {{-- ── Empty State ── --}}
    <div x-show="totalVisible === 0" x-cloak class="text-center py-24 space-y-4">
        <div class="w-14 h-14 mx-auto rounded-2xl metal-card flex items-center justify-center text-gray-600">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h3 class="text-base font-black uppercase tracking-widest text-white">Belum Ada Artikel</h3>
        <p class="text-gray-500 text-sm font-medium">Belum ada konten untuk kategori ini.</p>
    </div>

    {{-- ── Load More ── --}}
    <div class="flex justify-center" x-show="nextPage" x-cloak>
        <button @click="loadMore()" :disabled="loading"
            class="flex items-center gap-3 px-8 py-3 rounded-xl border border-white/[0.07] text-[13px] font-bold text-gray-400
                hover:text-white hover:border-brand-neon/40 hover:bg-brand-neon/[0.06] transition-all duration-200 disabled:opacity-40 metal-card">
            <template x-if="!loading">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </template>
            <template x-if="loading">
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </template>
            <span x-text="loading ? 'Memuat...' : 'Muat Lebih Banyak'"></span>
        </button>
    </div>

@endsection
