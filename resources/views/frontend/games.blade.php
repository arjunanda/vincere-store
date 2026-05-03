@extends('layouts.frontend')

@section('title', 'Daftar Game -')

@section('body_attr')
x-data="{ 
    search: '', 
    category: 'all',
    service: 'all',
    games: [
        @foreach($games as $game)
        { 
            id: {{ $game->id }}, 
            name: '{{ $game->name }}', 
            slug: '{{ $game->slug }}', 
            category: '{{ $game->platform_type }}', 
            category_name: '{{ $game->category->name ?? "General" }}',
            service: '{{ $game->category->slug ?? "all" }}', 
            image: '{{ asset('storage/' . $game->image) }}' 
        },
        @endforeach
    ]
}"
@endsection

@section('main_class', 'max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-24 space-y-16')

@section('content')
<!-- Header -->
<div class="text-center space-y-6 max-w-3xl mx-auto">
    <h1 class="text-4xl md:text-7xl font-black tracking-tighter italic metallic-text uppercase leading-none">
        Jelajahi <span class="text-brand-red">Game</span>
    </h1>
    <p class="text-gray-500 text-base md:text-xl font-medium leading-relaxed">
        Temukan game favoritmu dan mulai tingkatkan pengalaman bermainmu dengan layanan top-up premium kami.
    </p>
</div>

<!-- Filter & Search Section -->
<div class="space-y-10">
    <!-- Platform Tabs -->
    <div class="flex justify-center">
        <div class="w-full md:w-max overflow-hidden md:overflow-visible">
            <div class="flex flex-nowrap items-center p-1 glass-dark rounded-xl border border-white/5 gap-1 overflow-x-auto md:overflow-x-visible custom-scrollbar">
                <button @click="category = 'all'" 
                     :class="category === 'all' ? 'btn-metal shadow-lg text-white' : 'text-gray-500 hover:text-white hover:bg-white/5'" 
                     class="flex shrink-0 items-center gap-2 px-5 py-2.5 md:px-10 md:py-3.5 rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all duration-300 whitespace-nowrap">
                     <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" /></svg>
                     Semua Platform
                </button>
                <button @click="category = 'mobile'" 
                     :class="category === 'mobile' ? 'btn-metal shadow-lg text-white' : 'text-gray-500 hover:text-white hover:bg-white/5'" 
                     class="flex shrink-0 items-center gap-2 px-5 py-2.5 md:px-10 md:py-3.5 rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all duration-300 whitespace-nowrap">
                     <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                     Mobile
                </button>
                <button @click="category = 'pc'" 
                     :class="category === 'pc' ? 'btn-metal shadow-lg text-white' : 'text-gray-500 hover:text-white hover:bg-white/5'" 
                     class="flex shrink-0 items-center gap-2 px-5 py-2.5 md:px-10 md:py-3.5 rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all duration-300 whitespace-nowrap">
                     <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                     PC
                </button>
                <button @click="category = 'console'" 
                     :class="category === 'console' ? 'btn-metal shadow-lg text-white' : 'text-gray-500 hover:text-white hover:bg-white/5'" 
                     class="flex shrink-0 items-center gap-2 px-5 py-2.5 md:px-10 md:py-3.5 rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all duration-300 whitespace-nowrap">
                     <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H7a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" /></svg>
                     Console
                </button>
            </div>
        </div>
    </div>

    <!-- Search & Secondary Filter -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white/[0.02] p-4 md:p-6 rounded-xl border border-white/5 shadow-2xl">
        <!-- Search Bar -->
        <div class="relative flex-1 max-w-xl">
            <input type="text" x-model="search" placeholder="Cari game favoritmu..."
                class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-4 px-14 focus:outline-none focus:border-brand-red/50 transition-all text-sm font-medium">
            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-brand-red">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Service Filter Dropdown -->
        <div class="flex items-center gap-4" x-data="{ open: false }">
            <span class="hidden lg:block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">Tipe Layanan:</span>
            <div class="relative w-full md:w-64">
                    <button @click="open = !open" @click.away="open = false" class="w-full flex items-center justify-between px-6 py-4 glass-dark rounded-xl border border-white/10 hover:border-brand-red/30 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full" :class="service === 'all' ? 'bg-white/40' : 'bg-brand-red shadow-[0_0_8px_#e11d48]'"></div>
                            <span class="text-xs font-bold uppercase tracking-widest text-white/80 group-hover:text-white" x-text="service === 'all' ? 'Semua Layanan' : (service === 'top-up-game' ? 'Game Top-up' : 'Kode Voucher')"></span>
                        </div>
                        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" x-transition class="absolute top-full left-0 right-0 mt-3 p-1.5 glass-dark rounded-xl border border-white/10 shadow-2xl z-20">
                        <button @click="service = 'all'; open = false" class="w-full flex items-center gap-3 px-5 py-3.5 rounded-xl hover:bg-white/5 transition-all group/item">
                            <div class="w-1.5 h-1.5 rounded-full" :class="service === 'all' ? 'bg-brand-red shadow-[0_0_8px_#e11d48]' : 'bg-white/20'"></div>
                            <span class="text-[10px] font-bold uppercase tracking-widest" :class="service === 'all' ? 'text-white' : 'text-gray-500 group-hover/item:text-white'">Semua Layanan</span>
                        </button>
                        <button @click="service = 'top-up-game'; open = false" class="w-full flex items-center gap-3 px-5 py-3.5 rounded-xl hover:bg-white/5 transition-all group/item">
                            <div class="w-1.5 h-1.5 rounded-full" :class="service === 'top-up-game' ? 'bg-brand-red shadow-[0_0_8px_#e11d48]' : 'bg-white/20'"></div>
                            <span class="text-[10px] font-bold uppercase tracking-widest" :class="service === 'top-up-game' ? 'text-white' : 'text-gray-500 group-hover/item:text-white'">Game Top-up</span>
                        </button>
                        <button @click="service = 'voucher-game'; open = false" class="w-full flex items-center gap-3 px-5 py-3.5 rounded-xl hover:bg-white/5 transition-all group/item">
                            <div class="w-1.5 h-1.5 rounded-full" :class="service === 'voucher-game' ? 'bg-brand-red shadow-[0_0_8px_#e11d48]' : 'bg-white/20'"></div>
                            <span class="text-[10px] font-bold uppercase tracking-widest" :class="service === 'voucher-game' ? 'text-white' : 'text-gray-500 group-hover/item:text-white'">Kode Voucher</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Game Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-10">
        <template x-for="game in games" :key="game.id">
            <div x-show="(category === 'all' || game.category === category) && (service === 'all' || game.service === service) && (search === '' || game.name.toLowerCase().includes(search.toLowerCase()))"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-10 scale-90"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                
                <a :href="'/game/' + game.slug" class="block relative aspect-[3/4] rounded-xl overflow-hidden metal-card group">
                    <img :src="game.image" :alt="game.name" class="w-full h-full object-cover transition-transform duration-700 opacity-80 group-hover:opacity-100 group-hover:scale-110" loading="lazy">
                    <div class="absolute top-4 right-4 z-10">
                        <div class="glass-dark px-3 py-1.5 rounded-xl border border-white/10 group-hover:border-brand-red/50 transition-colors">
                            <p class="text-[10px] text-white font-black uppercase tracking-widest" x-text="game.category"></p>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-95 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-8 md:bottom-12 left-0 right-0 px-6 text-center flex flex-col items-center gap-1">
                        <h4 class="text-sm md:text-xl font-black tracking-tight italic uppercase px-1 item-title" x-text="game.name"></h4>
                        <!-- Decorative Line -->
                        <div class="w-0 group-hover:w-12 h-0.5 bg-brand-red transition-all duration-500 mt-1"></div>
                    </div>
                </a>
            </div>
        </template>
    </div>
</div>
@endsection