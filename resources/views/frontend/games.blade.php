@extends('layouts.frontend')

@section('title', 'Daftar Game -')

@section('body_attr')
    x-data="gamesPage()"
@endsection

@php
    $gamesData = $games->map(fn($g) => [
        'id' => $g->id,
        'name' => $g->name,
        'slug' => $g->slug,
        'category' => $g->platform_type,
        'category_name' => $g->category->name ?? "General",
        'service' => $g->category->slug ?? "all",
        'image' => asset('storage/' . $g->image)
    ]);
@endphp

@push('scripts')
<script>
    function gamesPage() {
        return {
            search: '{{ request('search') }}',
            category: 'all',
            service: 'all',
            initialGames: @json($gamesData),
            extraGames: [],
            serviceNames: {
                @foreach($categories as $cat)
                    '{{ $cat->slug }}': '{{ addslashes($cat->name) }}',
                @endforeach
            },
            nextPage: '{{ $games->nextPageUrl() }}',
            loading: false,

            get filteredInitialCount() {
                return this.initialGames.filter(g => this.matches(g)).length;
            },

            get filteredExtraCount() {
                return this.extraGames.filter(g => this.matches(g)).length;
            },

            get totalVisible() {
                return this.filteredInitialCount + this.filteredExtraCount;
            },

            matches(game) {
                return (this.category === 'all' || game.category === this.category) &&
                       (this.service === 'all' || game.service === this.service) &&
                       (this.search === '' || game.name.toLowerCase().includes(this.search.toLowerCase()));
            },

            async loadMore() {
                if (!this.nextPage || this.loading) return;
                this.loading = true;
                try {
                    const url = new URL(this.nextPage);
                    const response = await fetch(url.toString(), {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const result = await response.json();
                    
                    const newGames = result.data.map(g => ({
                        ...g,
                        service: g.service || 'all'
                    }));

                    this.extraGames = [...this.extraGames, ...newGames];
                    this.nextPage = result.next_page_url;
                } catch (error) {
                    console.error('Error loading more games:', error);
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

    {{-- ── Page Header ── --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-brand-neon mb-2">Katalog Lengkap</p>
            <h1 class="text-4xl md:text-5xl font-black tracking-tighter uppercase leading-none text-white">
                Daftar <span class="text-brand-neon">Game</span>
            </h1>
            <p class="text-gray-500 text-sm mt-3 font-medium max-w-md leading-relaxed">
                Top-up game favorit kamu dengan cepat, aman, dan harga terbaik.
            </p>
        </div>

        {{-- Stats --}}
        <div class="flex items-center gap-4 flex-shrink-0">
            <div class="text-center px-5 py-3 rounded-xl border border-white/[0.07]" style="background:#1a1d27">
                <p class="text-xl font-black text-brand-neon leading-none">{{ $games->total() }}+</p>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-1">Game</p>
            </div>
            <div class="text-center px-5 py-3 rounded-xl border border-white/[0.07]" style="background:#1a1d27">
                <p class="text-xl font-black text-white leading-none">24/7</p>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-1">Instan</p>
            </div>
        </div>
    </div>

    {{-- ── Filter Bar ── --}}
    <div class="rounded-2xl border border-white/[0.07] p-4 space-y-4" style="background:#1a1d27">

        {{-- Search --}}
        <div class="relative">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-neon pointer-events-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" x-model="search"
                placeholder="Cari nama game..."
                class="w-full bg-white/[0.04] border border-white/[0.07] rounded-xl py-3 pl-12 pr-4
                    focus:outline-none focus:border-brand-neon/40 focus:bg-white/[0.06]
                    transition-all text-[14px] font-medium placeholder:text-white/25 text-white">
        </div>

        {{-- Platform + Category Filter --}}
        <div class="flex flex-wrap gap-2 items-center justify-between">

            {{-- Platform tabs --}}
            <div class="flex flex-wrap gap-1.5">
                @foreach([
                    ['val' => 'all',     'label' => 'Semua',   'icon' => 'M4 6h16M4 12h16M4 18h16'],
                    ['val' => 'mobile',  'label' => 'Mobile',  'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
                    ['val' => 'pc',      'label' => 'PC',      'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['val' => 'console', 'label' => 'Console', 'icon' => 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H7a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z'],
                ] as $tab)
                    <button @click="category = '{{ $tab['val'] }}'"
                        :class="category === '{{ $tab['val'] }}'
                            ? 'bg-brand-neon text-black border-transparent shadow-sm shadow-brand-neon/20'
                            : 'bg-white/[0.03] text-gray-400 border-white/[0.07] hover:text-white hover:bg-white/[0.07]'"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl border text-[12px] font-bold uppercase tracking-wide transition-all duration-200 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $tab['icon'] }}" />
                        </svg>
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>

            {{-- Service Dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center gap-3 px-4 py-2 rounded-xl border border-white/[0.07] bg-white/[0.03]
                        hover:border-white/20 hover:bg-white/[0.06] transition-all text-[12px] font-bold uppercase tracking-wide text-gray-400 hover:text-white whitespace-nowrap">
                    <span x-text="service === 'all' ? 'Semua Layanan' : (serviceNames[service] || 'Layanan')"></span>
                    <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition x-cloak
                    class="absolute right-0 top-full mt-2 w-52 rounded-xl border border-white/[0.07] shadow-2xl z-20 overflow-hidden"
                    style="background:#1a1d27">
                    <button @click="service = 'all'; open = false"
                        class="w-full flex items-center gap-3 px-4 py-3 text-[12px] font-bold uppercase tracking-wide transition-all hover:bg-white/[0.05]"
                        :class="service === 'all' ? 'text-brand-neon' : 'text-gray-400'">
                        <div class="w-1.5 h-1.5 rounded-full flex-shrink-0"
                            :class="service === 'all' ? 'bg-brand-neon' : 'bg-white/20'"></div>
                        Semua Layanan
                    </button>
                    @foreach($categories as $cat)
                        <button @click="service = '{{ $cat->slug }}'; open = false"
                            class="w-full flex items-center gap-3 px-4 py-3 text-[12px] font-bold uppercase tracking-wide transition-all hover:bg-white/[0.05]"
                            :class="service === '{{ $cat->slug }}' ? 'text-brand-neon' : 'text-gray-400'">
                            <div class="w-1.5 h-1.5 rounded-full flex-shrink-0"
                                :class="service === '{{ $cat->slug }}' ? 'bg-brand-neon' : 'bg-white/20'"></div>
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Result count --}}
        <p class="text-[11px] text-gray-600 font-medium" x-text="`Menampilkan ${totalVisible} game`"></p>
    </div>

    {{-- ── Game Grid ── --}}
    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3 md:gap-6">
        {{-- SSR Initial Games --}}
        @foreach($games as $game)
            <div x-show="(category === 'all' || '{{ $game->platform_type }}' === category) && (service === 'all' || '{{ $game->category->slug ?? 'all' }}' === service) && (search === '' || '{{ strtolower($game->name) }}'.includes(search.toLowerCase()))"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">
                @include('partials.game-card', ['game' => $game])
            </div>
        @endforeach

        {{-- Extra Games (Loaded via AJAX) --}}
        <template x-for="game in extraGames" :key="game.id">
            <div x-show="(category === 'all' || game.category === category) && (service === 'all' || game.service === service) && (search === '' || game.name.toLowerCase().includes(search.toLowerCase()))"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">
                <a :href="'/game/' + game.slug"
                    class="block metal-card p-2 md:p-3 rounded-2xl group transition-all duration-300 h-full">
                    <div class="aspect-square rounded-xl overflow-hidden mb-3 md:mb-4 border border-white/5 group-hover:border-brand-neon/50 transition-colors shadow-lg">
                        <img :src="game.image" :alt="game.name"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            loading="lazy">
                    </div>
                    <div class="px-1 pb-1 space-y-3">
                        <h4 class="text-[9px] sm:text-[10px] md:text-xs font-bold tracking-tight uppercase text-center line-clamp-1 group-hover:text-brand-neon transition-colors"
                            x-text="game.name"></h4>
                        <div class="flex justify-center">
                            <div class="w-full py-2 rounded-xl bg-brand-neon text-black transition-all duration-300 shadow-[0_0_15px_rgba(124,255,0,0.2)] group-hover:shadow-[0_0_25px_rgba(124,255,0,0.4)] group-hover:scale-[1.02]">
                                <span class="text-[8px] sm:text-[9px] md:text-[11px] font-black uppercase tracking-widest block text-center">Top Up</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </template>
    </div>

    {{-- ── Empty State ── --}}
    <div x-show="totalVisible === 0" x-cloak class="text-center py-24 space-y-4">
        <div class="w-16 h-16 mx-auto rounded-2xl border border-white/[0.07] flex items-center justify-center text-gray-600" style="background:#1a1d27">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-base font-black uppercase tracking-widest text-white">Game Tidak Ditemukan</h3>
        <p class="text-gray-500 text-sm font-medium">Coba kata kunci atau filter yang berbeda.</p>
        <button @click="search = ''; category = 'all'; service = 'all'"
            class="inline-flex items-center gap-2 mt-2 px-5 py-2.5 rounded-xl border border-white/10 text-[12px] font-bold text-gray-400 hover:text-white hover:border-white/20 hover:bg-white/[0.04] transition-all">
            Reset Filter
        </button>
    </div>

    {{-- ── Load More ── --}}
    <div class="flex justify-center" x-show="nextPage" x-cloak>
        <button @click="loadMore()" :disabled="loading"
            class="flex items-center gap-3 px-8 py-3 rounded-xl border border-white/[0.07] text-[13px] font-bold text-gray-400
                hover:text-white hover:border-brand-neon/40 hover:bg-brand-neon/[0.06] transition-all duration-200 disabled:opacity-40"
            style="background:#1a1d27">
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