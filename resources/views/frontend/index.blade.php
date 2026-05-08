@extends('layouts.frontend')

@section('body_attr')
    x-data="{
    search: '',
    category: 'all',
    initialized: false,
    init() { this.$nextTick(() => { this.initialized = true; }); },
    games: [
    @foreach($games as $game)
        {
        id: {{ $game->id }},
        name: '{{ $game->name }}',
        slug: '{{ $game->slug }}',
        category: '{{ $game->platform_type }}',
        category_name: '{{ $game->category->name ?? "General" }}',
        image: '{{ asset('storage/' . $game->image) }}'
        },
    @endforeach
    ]
    }"
@endsection

@section('main_class', 'max-w-7xl mx-auto px-4 md:px-6 py-12 space-y-20 md:space-y-40')

@section('content')
    <!-- Banner Slider -->
    <section
        class="relative w-full aspect-[2.4/1] md:aspect-none md:h-[480px] rounded-xl md:rounded-xl overflow-hidden shadow-2xl premium-glow group border border-white/10"
        x-data="{ 
                                                activeSlide: 0,
                                                flash: false,
                                                autoplayInterval: null,
                                                totalSlides: {{ $banners->isEmpty() ? 3 : $banners->count() }},
                                                triggerFlash() {
                                                    this.flash = true;
                                                    setTimeout(() => this.flash = false, 1000);
                                                },
                                                nextSlide(isManual = false) {
                                                    this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                                                    if (isManual) {
                                                        this.resetAutoplay();
                                                    }
                                                },
                                                prevSlide(isManual = false) {
                                                    this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
                                                    if (isManual) {
                                                        this.resetAutoplay();
                                                    }
                                                },
                                                startAutoplay() {
                                                    this.autoplayInterval = setInterval(() => this.nextSlide(false), 5000);
                                                },
                                                resetAutoplay() {
                                                    clearInterval(this.autoplayInterval);
                                                    this.startAutoplay();
                                                }
                                            }" x-init="startAutoplay()">
        <!-- Banner Content -->
        @php
            $slideItems = $banners->isEmpty() ? collect([
                (object) ['image' => 'assets/images-logo/banner-1.png', 'title' => 'PENAWARAN EKSKLUSIF VENTUZ', 'is_asset' => true],
                (object) ['image' => 'assets/images-logo/banner-1.png', 'title' => 'TINGKATKAN PENGALAMAN GAMING', 'is_asset' => true],
                (object) ['image' => 'assets/images-logo/banner-1.png', 'title' => 'TOP-UP CEPAT & AMAN', 'is_asset' => true]
            ]) : $banners;
        @endphp

        @foreach($slideItems as $index => $slide)
            <div x-show="activeSlide === {{ $index }}"
                x-transition:enter="transition all duration-1000 cubic-bezier(0.4, 0, 0.2, 1)"
                x-transition:enter-start="opacity-0 translate-x-1/4 scale-105"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition all duration-1000 cubic-bezier(0.4, 0, 0.2, 1)"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-x-1/4 scale-95" class="absolute inset-0" {!! $index !== 0 ? 'style="display: none;"' : '' !!}>
                @php
                    $imgSrc = isset($slide->is_asset) ? asset($slide->image) : asset('storage/' . $slide->image);
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $slide->title }}" width="1200" height="480" class="w-full h-full object-cover"
                    @if($index === 0) fetchpriority="high" @else loading="lazy" @endif>
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
            </div>
        @endforeach

        <!-- Slider Nav Buttons -->
        <div
            class="absolute left-0 right-0 top-1/2 -translate-y-1/2 flex justify-between px-8 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10">
            <button @click="prevSlide(true)"
                class="w-14 h-14 rounded-xl glass-dark flex items-center justify-center hover:bg-brand-neon transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="nextSlide(true)"
                class="w-14 h-14 rounded-xl glass-dark flex items-center justify-center hover:bg-brand-neon transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <div class="absolute bottom-8 right-8 md:right-20 flex gap-3 md:gap-4 z-10">
            <template x-for="(_, index) in Array.from({length: totalSlides})" :key="index">
                <button @click="activeSlide = index; resetAutoplay()"
                    class="h-1.5 md:h-2 transition-all duration-500 rounded-full"
                    :class="activeSlide === index ? 'w-10 md:w-16 bg-brand-neon' : 'w-4 md:w-6 bg-white/20'"></button>
            </template>
        </div>

        <!-- Flash Effect -->
        <div x-show="flash" x-transition:leave="transition opacity-100 duration-1000" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="absolute inset-0 bg-white/10 pointer-events-none z-20"></div>
    </section>

    <!-- Game Grid Section -->
    <section id="games-section" class="space-y-8">
        <div class="flex flex-col gap-6">
            <div class="section-header">
                <div class="w-1.5 h-6 bg-brand-neon rounded-full"></div>
                <h2 class="text-xl md:text-2xl font-bold uppercase tracking-tight">Game <span
                        class="text-brand-neon">Terpopuler</span></h2>
            </div>
        </div>

        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3 md:gap-6">
            @foreach($games->take(18) as $index => $game)
                <div class="game-card-wrapper">
                    <a href="{{ url('/game/' . $game->slug) }}"
                        class="block metal-card p-2 md:p-3 rounded-2xl group transition-all duration-300">
                        <!-- Icon Wrapper -->
                        <div
                            class="aspect-square rounded-xl overflow-hidden mb-3 md:mb-4 border border-white/5 group-hover:border-brand-neon/50 transition-colors shadow-lg">
                            <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                @if($index < 6) fetchpriority="high" @else loading="lazy" @endif>
                        </div>

                        <!-- Title & Button -->
                        <div class="px-1 pb-1 space-y-3">
                            <h4
                                class="text-[9px] sm:text-[10px] md:text-xs font-bold tracking-tight uppercase text-center line-clamp-1 group-hover:text-brand-neon transition-colors">
                                {{ $game->name }}
                            </h4>

                            <div class="flex justify-center">
                                <div
                                    class="w-full py-2 rounded-xl bg-brand-neon text-black transition-all duration-300 shadow-[0_0_15px_rgba(124,255,0,0.2)] group-hover:shadow-[0_0_25px_rgba(124,255,0,0.4)] group-hover:scale-[1.02]">
                                    <span
                                        class="text-[8px] sm:text-[9px] md:text-[11px] font-black uppercase tracking-widest block text-center">Top
                                        Up</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- View All Games Section -->
        <div class="flex justify-center pt-10 md:pt-16 pb-10">
            <a href="{{ route('games.index') }}"
                class="group relative flex items-center justify-center gap-4 px-10 py-4 bg-brand-neon rounded-xl text-black font-bold uppercase tracking-widest transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(124,255,0,0.3)]">
                <span>Lihat Semua Game</span>
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </section>

    <!-- Why Choose Us Section (Numbered Showcase) -->
    <section class="py-10">
        <div class="section-header w-full">
            <div class="w-1.5 h-6 bg-brand-neon rounded-full"></div>
            <h2 class="text-xl md:text-2xl font-bold uppercase tracking-tight">Kenapa Harus <span
                    class="text-brand-neon">Kami?</span></h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left Side: Branding/Title -->
            <div class="lg:col-span-5 space-y-8">
                <h3 class="text-4xl md:text-5xl font-black uppercase tracking-tighter leading-[1.1]">
                    Pengalaman <span class="text-brand-neon">Top-Up</span> <br>Gamer Paling <span
                        class="text-white/40">Solid.</span>
                </h3>
                <p class="text-gray-400 text-base md:text-lg font-medium leading-relaxed max-w-md">
                    Dibuat oleh gamers untuk gamers. Kami mengutamakan kecepatan, keamanan, dan kenyamanan dalam setiap
                    transaksi kamu.
                </p>
                <div class="flex items-center gap-6 pt-4">
                    <div class="flex -space-x-3">
                        <div
                            class="w-10 h-10 rounded-full border-2 border-brand-dark bg-brand-card flex items-center justify-center text-[10px] font-bold text-brand-neon">
                            10k+</div>
                        <div
                            class="w-10 h-10 rounded-full border-2 border-brand-dark bg-brand-neon flex items-center justify-center text-[10px] font-bold text-black">
                            TOP</div>
                    </div>
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-500">Pilihan Utama <br>Komunitas Gamer
                    </p>
                </div>
            </div>

            <!-- Right Side: Features List -->
            <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                <!-- Feature 1 -->
                <div class="group space-y-4">
                    <div class="flex items-end gap-3">
                        <span
                            class="text-4xl font-black text-white/30 group-hover:text-brand-neon transition-colors duration-500">01</span>
                        <div class="w-full h-px bg-white/10 mb-3 group-hover:bg-brand-neon/30 transition-colors"></div>
                    </div>
                    <h4
                        class="text-lg font-bold uppercase tracking-tight text-white group-hover:text-brand-neon transition-colors">
                        Proses Otomatis</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Sistem kami terintegrasi langsung dengan provider,
                        pesananmu masuk dalam hitungan detik 24/7.</p>
                </div>

                <!-- Feature 2 -->
                <div class="group space-y-4">
                    <div class="flex items-end gap-3">
                        <span
                            class="text-4xl font-black text-white/30 group-hover:text-brand-neon transition-colors duration-500">02</span>
                        <div class="w-full h-px bg-white/10 mb-3 group-hover:bg-brand-neon/30 transition-colors"></div>
                    </div>
                    <h4
                        class="text-lg font-bold uppercase tracking-tight text-white group-hover:text-brand-neon transition-colors">
                        Legal & Resmi</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Semua produk yang kami jual 100% legal dan aman.
                        Garansi anti-banned untuk setiap transaksi.</p>
                </div>

                <!-- Feature 3 -->
                <div class="group space-y-4">
                    <div class="flex items-end gap-3">
                        <span
                            class="text-4xl font-black text-white/30 group-hover:text-brand-neon transition-colors duration-500">03</span>
                        <div class="w-full h-px bg-white/10 mb-3 group-hover:bg-brand-neon/30 transition-colors"></div>
                    </div>
                    <h4
                        class="text-lg font-bold uppercase tracking-tight text-white group-hover:text-brand-neon transition-colors">
                        Metode Terlengkap</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Mulai dari QRIS, E-Wallet, hingga Virtual Account Bank
                        tersedia untuk memudahkan pembayaranmu.</p>
                </div>

                <!-- Feature 4 -->
                <div class="group space-y-4">
                    <div class="flex items-end gap-3">
                        <span
                            class="text-4xl font-black text-white/30 group-hover:text-brand-neon transition-colors duration-500">04</span>
                        <div class="w-full h-px bg-white/10 mb-3 group-hover:bg-brand-neon/30 transition-colors"></div>
                    </div>
                    <h4
                        class="text-lg font-bold uppercase tracking-tight text-white group-hover:text-brand-neon transition-colors">
                        Support Responsif</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Tim Customer Service kami selalu siap membantu jika
                        kamu menemui kendala dalam transaksi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="space-y-16">
        <div class="section-header w-full">
            <div class="w-1.5 h-6 bg-brand-neon rounded-full"></div>
            <h2 class="text-xl md:text-2xl font-bold uppercase tracking-tight">Suara <span
                    class="text-brand-neon">Pelanggan</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Review 1 -->
            <div
                class="glass-dark p-8 rounded-xl border border-white/5 flex flex-col h-full space-y-6 hover:bg-white/[0.03] transition-all group">
                <div class="flex gap-1 text-brand-neon">
                    <template x-for="i in 5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </template>
                </div>
                <p class="text-gray-400 font-medium text-sm leading-relaxed  flex-1">"Gila sih, baru bayar
                    sedetik kemudian langsung masuk diamond-nya. Ventuz Store emang paling kenceng!"</p>
                <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                    <div
                        class="w-10 h-10 bg-brand-neon/20 rounded-full flex items-center justify-center font-bold text-brand-neon text-xs">
                        BK</div>
                    <div>
                        <p class="text-xs font-bold text-white">Budi Kusuma</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">MLBB Player</p>
                    </div>
                </div>
            </div>

            <!-- Review 2 -->
            <div
                class="glass-dark p-8 rounded-xl border border-white/5 flex flex-col h-full space-y-6 hover:bg-white/[0.03] transition-all group">
                <div class="flex gap-1 text-brand-neon">
                    <template x-for="i in 5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </template>
                </div>
                <p class="text-gray-400 font-medium text-sm leading-relaxed  flex-1">"Udah sering top-up di
                    sini buat UC PUBG. Harganya selalu miring dibanding yang lain. Recommended!"</p>
                <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                    <div
                        class="w-10 h-10 bg-brand-neon/20 rounded-full flex items-center justify-center font-bold text-brand-neon text-xs">
                        SA</div>
                    <div>
                        <p class="text-xs font-bold text-white">Siska Amelia</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">PUBG Mobile</p>
                    </div>
                </div>
            </div>

            <!-- Review 3 -->
            <div
                class="glass-dark p-8 rounded-xl border border-white/5 flex flex-col h-full space-y-6 hover:bg-white/[0.03] transition-all group">
                <div class="flex gap-1 text-brand-neon">
                    <template x-for="i in 5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </template>
                </div>
                <p class="text-gray-400 font-medium text-sm leading-relaxed  flex-1">"Baru pertama kali coba
                    dan langsung puas. CS-nya juga ramah banget pas ditanya-tanya. Mantap pokoknya!"</p>
                <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                    <div
                        class="w-10 h-10 bg-brand-neon/20 rounded-full flex items-center justify-center font-bold text-brand-neon text-xs">
                        RF</div>
                    <div>
                        <p class="text-xs font-bold text-white">Rizky Fauzi</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Gamer PC</p>
                    </div>
                </div>
            </div>

            <!-- Review 4 -->
            <div
                class="glass-dark p-8 rounded-xl border border-white/5 flex flex-col h-full space-y-6 hover:bg-white/[0.03] transition-all group">
                <div class="flex gap-1 text-brand-neon">
                    <template x-for="i in 5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </template>
                </div>
                <p class="text-gray-400 font-medium text-sm leading-relaxed  flex-1">"Gak nyesel langganan di
                    sini. Sistem vouchernya otomatis dan harganya paling masuk akal."</p>
                <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                    <div
                        class="w-10 h-10 bg-brand-neon/20 rounded-full flex items-center justify-center font-bold text-brand-neon text-xs">
                        DA</div>
                    <div>
                        <p class="text-xs font-bold text-white">Dani Anwar</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Mobile Legends</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News & Promo Section -->
    <div class="section-header">
        <div class="w-1.5 h-6 bg-brand-neon rounded-full"></div>
        <h2 class="text-xl md:text-2xl font-bold uppercase tracking-tight">Berita & <span
                class="text-brand-neon">Promo</span></h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @php
            $featuredArticle = $articles->first();
            $otherArticles = $articles->skip(1);
        @endphp

        @if($featuredArticle)
            <!-- Featured Article -->
            <div class="lg:col-span-7">
                <a href="{{ route('news.detail', $featuredArticle->slug) }}"
                    class="metal-card rounded-2xl overflow-hidden group flex flex-col h-full">
                    <div class="relative aspect-video lg:aspect-auto lg:h-full overflow-hidden">
                        <img src="{{ asset('storage/' . $featuredArticle->image) }}" alt="{{ $featuredArticle->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6 md:p-8 space-y-3">
                            <div class="flex items-center gap-3">
                                <span
                                    class="px-3 py-1 rounded-lg bg-brand-neon text-black text-[10px] font-black uppercase tracking-widest">{{ $featuredArticle->type }}</span>
                                <span
                                    class="text-[10px] text-white/70 font-bold uppercase tracking-widest">{{ $featuredArticle->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                            <h4
                                class="text-2xl md:text-3xl font-black leading-tight group-hover:text-brand-neon transition-colors uppercase">
                                {{ $featuredArticle->title }}
                            </h4>
                            <p class="text-gray-300 text-sm line-clamp-2 max-w-xl hidden md:block">
                                {{ Str::limit(strip_tags($featuredArticle->content), 150) }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Side Articles -->
            <div class="lg:col-span-5 flex flex-col gap-6">
                @foreach($otherArticles->take(2) as $article)
                    <a href="{{ route('news.detail', $article->slug) }}"
                        class="metal-card rounded-2xl overflow-hidden group flex flex-1 gap-4 md:gap-6 p-4 md:p-5">
                        <div class="w-24 md:w-32 lg:w-40 aspect-square rounded-xl overflow-hidden flex-shrink-0">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        <div class="flex-1 flex flex-col justify-between py-1 min-w-0">
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-[9px] text-brand-neon font-black uppercase tracking-widest">{{ $article->type }}</span>
                                    <span
                                        class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">{{ $article->created_at->translatedFormat('d M Y') }}</span>
                                </div>
                                <h4
                                    class="text-sm md:text-base font-bold leading-tight group-hover:text-brand-neon transition-colors line-clamp-2 uppercase">
                                    {{ $article->title }}
                                </h4>
                            </div>
                            <div
                                class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-white/40 group-hover:text-brand-neon transition-colors">
                                <span>Baca Selengkapnya</span>
                                <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- View All News Section -->
    <div class="flex justify-center pt-8 md:pt-10">
        <a href="/news"
            class="group flex items-center gap-3 md:gap-4 px-8 py-4 md:px-12 md:py-5 bg-white/[0.03] hover:bg-brand-neon border border-white/10 hover:border-brand-neon rounded-xl md:rounded-xl transition-all duration-300">
            <div class="flex items-center gap-3 md:gap-4">
                <span class="text-[10px] md:text-sm font-black uppercase tracking-[0.2em] text-white">Lihat Semua
                    Berita</span>
                <div
                    class="w-6 md:w-10 h-px bg-white/20 group-hover:w-10 md:group-hover:w-16 group-hover:bg-white transition-all duration-500">
                </div>
                <svg class="w-4 h-4 md:w-5 md:h-5 group-hover:translate-x-2 transition-transform duration-500" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </a>
    </div>
    </section>
@endsection