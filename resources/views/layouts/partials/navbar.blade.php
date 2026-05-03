<!-- Navbar -->
<nav class="sticky top-0 z-50 bg-[#050505]/95 py-4 px-6 border-b border-white/10"
    x-data="{ mobileMenu: false, showSearch: false }">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Left Side: Logo & Menu -->
        <div class="flex items-center gap-16">
            <!-- Logo -->
            <a href="/">
                <x-logo size="md" />
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-10">
                <a href="/"
                    class="text-[15px] font-bold tracking-wide {{ Route::is('index') ? 'text-brand-red' : 'text-white/70' }} hover:text-brand-red transition-colors">Beranda</a>
                <a href="{{ route('games.index') }}"
                    class="text-[15px] font-bold tracking-wide {{ Route::is('games.index') ? 'text-brand-red' : 'text-white/70' }} hover:text-brand-red transition-colors whitespace-nowrap">Daftar Game</a>
                <a href="{{ route('check.transaction') }}"
                    class="text-[15px] font-bold tracking-wide {{ Route::is('check.transaction') ? 'text-brand-red' : 'text-white/70' }} hover:text-brand-red transition-colors whitespace-nowrap">Cek Transaksi</a>
                <a href="{{ route('news.index') }}"
                    class="text-[15px] font-bold tracking-wide {{ Route::is('news.index') ? 'text-brand-red' : 'text-white/70' }} hover:text-brand-red transition-colors whitespace-nowrap">Promo & Berita</a>
            </div>
        </div>

        <!-- Right Side: Actions -->
        <div class="flex items-center gap-4">
            <!-- Search Icon Toggle (Desktop) -->
            <button @click="showSearch = !showSearch"
                class="hidden lg:flex w-11 h-11 relative items-center justify-center bg-white/[0.07] border border-white/20 rounded-xl text-white hover:bg-brand-red hover:border-brand-red transition-all shadow-lg z-50 group">
                <svg x-show="!showSearch" x-cloak class="w-5 h-5 transition-all duration-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <svg x-show="showSearch" x-cloak class="w-5 h-5 transition-all duration-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            @guest
                <a href="{{ route('login') }}"
                    class="hidden lg:flex bg-white/[0.07] hover:bg-white/[0.12] px-8 py-3 rounded-xl font-bold text-[15px] transition-all border border-white/20 items-center justify-center shadow-lg">Masuk</a>
                <a href="{{ route('register') }}"
                    class="hidden lg:flex btn-metal px-8 py-3 rounded-xl font-bold text-[15px] shadow-xl whitespace-nowrap items-center justify-center">Daftar</a>
            @else
                <a href="{{ route('dashboard.index') }}"
                    class="hidden lg:flex btn-metal px-8 py-3 rounded-xl font-bold text-[15px] shadow-lg items-center justify-center">Dashboard</a>
            @endguest

            <!-- Mobile Toggle Group -->
            <div class="flex lg:hidden items-center gap-3">
                <button @click="showSearch = !showSearch" 
                    class="w-11 h-11 flex items-center justify-center bg-white/5 border border-white/10 rounded-2xl text-white hover:text-brand-red transition-all">
                    <svg x-show="!showSearch" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <svg x-show="showSearch" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <button @click="mobileMenu = !mobileMenu" 
                    class="w-11 h-11 flex items-center justify-center bg-white/5 border border-white/10 rounded-2xl text-white hover:text-brand-red transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenu" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Search Dropdown (Below Navbar) -->
    <div x-show="showSearch" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="absolute left-0 right-0 top-full bg-[#0a0a0a]/98 border-b border-white/10 py-6 px-6 shadow-2xl">
        <div class="max-w-3xl mx-auto relative">
            <input type="text" x-model="search" placeholder="Cari game favoritmu..."
                class="w-full bg-white/[0.05] border border-white/10 rounded-2xl py-4 px-14 focus:outline-none focus:border-brand-red/50 transition-all text-lg font-medium placeholder:text-gray-600">
            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-brand-red">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div class="absolute right-5 top-1/2 -translate-y-1/2 flex items-center gap-2">
                <span
                    class="text-[10px] font-bold text-gray-500 uppercase tracking-widest bg-white/5 px-2 py-1 rounded">ESC</span>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" x-cloak 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" 
        x-transition:enter-end="opacity-100 translate-y-0"
        class="lg:hidden mt-6 pt-6 border-t border-white/10 space-y-8 pb-4">
        
        <!-- Nav Links List -->
        <div class="space-y-3">
            <a href="/" class="flex items-center gap-4 py-4 px-6 rounded-2xl bg-white/[0.03] border border-white/5 text-[15px] font-bold text-white uppercase tracking-wider hover:bg-brand-red/10 hover:border-brand-red/30 transition-all group">
                <svg class="w-5 h-5 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <a href="/games" class="flex items-center gap-4 py-4 px-6 rounded-2xl bg-white/[0.03] border border-white/5 text-[15px] font-bold text-white uppercase tracking-wider hover:bg-brand-red/10 hover:border-brand-red/30 transition-all group">
                <svg class="w-5 h-5 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Daftar Game
            </a>
            <a href="{{ route('check.transaction') }}" class="flex items-center gap-4 py-4 px-6 rounded-2xl bg-white/[0.03] border border-white/5 text-[15px] font-bold text-white uppercase tracking-wider hover:bg-brand-red/10 hover:border-brand-red/30 transition-all group">
                <svg class="w-5 h-5 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Cek Transaksi
            </a>
            <a href="{{ route('news.index') }}" class="flex items-center gap-4 py-4 px-6 rounded-2xl bg-white/[0.03] border border-white/5 text-[15px] font-bold text-white uppercase tracking-wider hover:bg-brand-red/10 hover:border-brand-red/30 transition-all group">
                <svg class="w-5 h-5 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM3 8h10M9 20v-8m0 0l-2 2m2-2l2 2" />
                </svg>
                Promo & Berita
            </a>
        </div>

        <!-- Auth Buttons -->
        <div class="pt-6 border-t border-white/10 space-y-4">
            @guest
                <a href="{{ route('register') }}" class="block w-full text-center py-5 rounded-2xl bg-brand-red shadow-lg shadow-brand-red/20 text-[15px] font-black uppercase tracking-widest text-white hover:brightness-110 transition-all">
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="block w-full text-center py-5 rounded-2xl bg-white/5 border border-white/10 text-[15px] font-black uppercase tracking-widest text-white hover:bg-white/10 transition-all">
                    Masuk
                </a>
            @else
                <a href="{{ route('dashboard.index') }}" class="btn-metal block w-full text-center py-5 rounded-2xl font-black text-[15px] uppercase tracking-widest shadow-lg">
                    Dashboard
                </a>
            @endguest
        </div>
    </div>
</nav>