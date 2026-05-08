<!-- Navbar -->
<nav class="sticky top-0 z-50 border-b border-white/[0.06] backdrop-blur-xl"
    style="background: rgba(18, 20, 26, 0.96);"
    x-data="{ mobileMenu: false, showSearch: false }"
    aria-label="Navigasi Utama">

    <div class="max-w-7xl mx-auto px-6 h-[68px] flex items-center justify-between gap-8">

        <!-- ── Col 1: Logo ── -->
        <a href="/" class="flex-shrink-0" title="Halaman Utama">
            <x-logo size="md" />
        </a>

        <!-- ── Col 2: Desktop Nav Links (Center) ── -->
        <nav class="hidden lg:flex items-center gap-1 flex-1 justify-center" aria-label="Menu Utama">
            <a href="/"
                title="Kembali ke Beranda"
                class="relative px-4 py-2 rounded-xl text-[14px] font-semibold tracking-wide transition-all duration-200
                    {{ Route::is('index')
                        ? 'text-brand-neon bg-brand-neon/10'
                        : 'text-white/60 hover:text-white hover:bg-white/[0.05]' }}">
                Beranda
            </a>

            <a href="{{ route('games.index') }}"
                title="Lihat Daftar Game Terlengkap"
                class="relative px-4 py-2 rounded-xl text-[14px] font-semibold tracking-wide transition-all duration-200 whitespace-nowrap
                    {{ Route::is('games.index')
                        ? 'text-brand-neon bg-brand-neon/10'
                        : 'text-white/60 hover:text-white hover:bg-white/[0.05]' }}">
                Daftar Game
            </a>

            <a href="{{ route('check.transaction') }}"
                title="Cek Status Pesanan Kamu"
                class="relative px-4 py-2 rounded-xl text-[14px] font-semibold tracking-wide transition-all duration-200 whitespace-nowrap
                    {{ Route::is('check.transaction')
                        ? 'text-brand-neon bg-brand-neon/10'
                        : 'text-white/60 hover:text-white hover:bg-white/[0.05]' }}">
                Cek Transaksi
            </a>

            <a href="{{ route('news.index') }}"
                title="Berita Gaming dan Promo Terbaru"
                class="relative px-4 py-2 rounded-xl text-[14px] font-semibold tracking-wide transition-all duration-200 whitespace-nowrap
                    {{ Route::is('news.index')
                        ? 'text-brand-neon bg-brand-neon/10'
                        : 'text-white/60 hover:text-white hover:bg-white/[0.05]' }}">
                Promo & Berita
            </a>
        </nav>

        <!-- ── Col 3: Right Actions ── -->
        <div class="flex items-center gap-2 flex-shrink-0">

            <!-- Search Button -->
            <button @click="showSearch = !showSearch"
                aria-label="Cari Game"
                class="w-10 h-10 flex items-center justify-center rounded-xl border transition-all duration-200
                    bg-white/[0.04] border-white/10 text-white/60
                    hover:bg-brand-neon/10 hover:border-brand-neon/40 hover:text-brand-neon">
                <svg x-show="!showSearch" x-cloak class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <svg x-show="showSearch" x-cloak class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Divider -->
            <span class="hidden lg:block w-px h-6 bg-white/10 mx-1"></span>

            @guest
                <!-- Login -->
                <a href="{{ route('login') }}"
                    title="Masuk ke Akun Kamu"
                    class="hidden lg:inline-flex items-center gap-2 h-10 px-5 rounded-xl text-[13.5px] font-semibold
                        text-white/80 border border-white/10 bg-white/[0.04]
                        hover:bg-white/[0.08] hover:text-white hover:border-white/20 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Masuk
                </a>
            @else
                <!-- Dashboard -->
                <a href="{{ route('dashboard.index') }}"
                    title="Buka Dashboard Member"
                    class="hidden lg:inline-flex items-center gap-2 h-10 px-5 rounded-xl text-[13.5px] font-bold
                        bg-brand-neon text-black shadow-lg shadow-brand-neon/20
                        hover:brightness-110 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z" />
                    </svg>
                    Dashboard
                </a>
            @endguest

            <!-- Mobile Toggle -->
            <button @click="mobileMenu = !mobileMenu"
                aria-label="Menu Mobile"
                class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl border border-white/10 bg-white/[0.04] text-white/70 hover:text-brand-neon hover:border-brand-neon/40 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileMenu" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Search Bar Dropdown -->
    <div x-show="showSearch" x-cloak
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="border-t border-white/[0.06] py-4 px-6"
        style="background: rgba(12, 14, 18, 0.98);">
        <form action="{{ route('games.index') }}" method="GET" class="max-w-2xl mx-auto relative">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-neon pointer-events-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input
                type="text"
                name="search"
                placeholder="Cari game favoritmu..."
                autofocus
                class="w-full bg-white/[0.04] border border-white/10 rounded-xl py-3 pl-12 pr-20
                    focus:outline-none focus:border-brand-neon/50 focus:bg-white/[0.06]
                    transition-all text-[15px] font-medium placeholder:text-white/30 text-white">
            <div class="absolute right-4 top-1/2 -translate-y-1/2">
                <kbd class="text-[10px] font-bold text-white/30 uppercase tracking-widest bg-white/[0.06] border border-white/10 px-2 py-1 rounded-md">Enter</kbd>
            </div>
        </form>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" x-cloak
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden border-t border-white/[0.06] px-6 py-5 space-y-2"
        style="background: rgba(12, 14, 18, 0.98);">

        <!-- Nav Links -->
        <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold
            {{ Route::is('index') ? 'text-brand-neon bg-brand-neon/10 border border-brand-neon/20' : 'text-white/70 hover:text-white hover:bg-white/[0.04]' }}
            transition-all">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Beranda
        </a>

        <a href="{{ route('games.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold
            {{ Route::is('games.index') ? 'text-brand-neon bg-brand-neon/10 border border-brand-neon/20' : 'text-white/70 hover:text-white hover:bg-white/[0.04]' }}
            transition-all">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Daftar Game
        </a>

        <a href="{{ route('check.transaction') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold
            {{ Route::is('check.transaction') ? 'text-brand-neon bg-brand-neon/10 border border-brand-neon/20' : 'text-white/70 hover:text-white hover:bg-white/[0.04]' }}
            transition-all">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Cek Transaksi
        </a>

        <a href="{{ route('news.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold
            {{ Route::is('news.index') ? 'text-brand-neon bg-brand-neon/10 border border-brand-neon/20' : 'text-white/70 hover:text-white hover:bg-white/[0.04]' }}
            transition-all">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
            </svg>
            Promo & Berita
        </a>

        <!-- Auth Buttons Mobile -->
        <div class="pt-4 border-t border-white/[0.06] space-y-2">
            @guest
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center gap-2 w-full py-3 rounded-xl font-semibold text-[14px]
                        text-white/80 border border-white/10 bg-white/[0.04] hover:bg-white/[0.08] hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Masuk
                </a>
            @else
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center justify-center gap-2 w-full py-3 rounded-xl font-bold text-[14px]
                        bg-brand-neon text-black shadow-lg shadow-brand-neon/20 hover:brightness-110 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z" />
                    </svg>
                    Dashboard
                </a>
            @endguest
        </div>
    </div>
</nav>