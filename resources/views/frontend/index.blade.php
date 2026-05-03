@extends('layouts.frontend')

@section('title')

@section('body_attr')
    x-data="{
    search: '',
    category: 'all',
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
            slides: [
                @foreach($banners as $banner)
                    { 
                        image: '{{ asset('storage/' . $banner->image) }}', 
                        title: '{{ $banner->title }}' 
                    },
                @endforeach
                @if($banners->isEmpty())
                    { image: '{{ asset('assets/images-logo/banner-1.jpeg') }}', title: 'PENAWARAN EKSKLUSIF VENTUZ' },
                    { image: '{{ asset('assets/images-logo/banner-2.jpeg') }}', title: 'TINGKATKAN PENGALAMAN GAMING' },
                    { image: '{{ asset('assets/images-logo/banner-3.jpeg') }}', title: 'TOP-UP CEPAT & AMAN' }
                @endif
            ],
            triggerFlash() {
                this.flash = true;
                setTimeout(() => this.flash = false, 1000);
            },
            nextSlide(isManual = false) {
                this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                if (isManual) {
                    this.resetAutoplay();
                }
            },
            prevSlide(isManual = false) {
                this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
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
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                x-transition:enter="transition all duration-1000 cubic-bezier(0.4, 0, 0.2, 1)"
                x-transition:enter-start="opacity-0 translate-x-1/4 scale-105"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition all duration-1000 cubic-bezier(0.4, 0, 0.2, 1)"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-x-1/4 scale-95" class="absolute inset-0">
                <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover" loading="eager">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
            </div>
        </template>

        <!-- Slider Nav Buttons -->
        <div
            class="absolute left-0 right-0 top-1/2 -translate-y-1/2 flex justify-between px-8 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10">
            <button @click="prevSlide(true)"
                class="w-14 h-14 rounded-xl glass-dark flex items-center justify-center hover:bg-brand-red transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="nextSlide(true)"
                class="w-14 h-14 rounded-xl glass-dark flex items-center justify-center hover:bg-brand-red transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Navigation dots -->
        <div class="absolute bottom-8 right-8 md:right-20 flex gap-3 md:gap-4 z-10">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index; resetAutoplay()"
                    class="h-1.5 md:h-2 transition-all duration-500 rounded-full"
                    :class="activeSlide === index ? 'w-10 md:w-16 bg-brand-red' : 'w-4 md:w-6 bg-white/20'"></button>
            </template>
        </div>

        <!-- Flash Effect -->
        <div x-show="flash" x-transition:leave="transition opacity-100 duration-1000" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="absolute inset-0 bg-white/10 pointer-events-none z-20"></div>
    </section>

    <!-- Game Grid Section -->
    <section id="games-section" class="space-y-12">
        <div class="flex flex-col gap-10">
            <!-- Title Block -->
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-[2px] bg-brand-red"></div>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-brand-red">Top-up & Voucher Game</p>
                </div>
                <h3 class="text-3xl md:text-6xl font-black italic uppercase tracking-tighter leading-none">
                    GAME <span class="text-brand-red">TERPOPULER</span>
                </h3>
            </div>

            <!-- Filters Block -->
            <div class="w-full md:w-max overflow-hidden md:overflow-visible">
                <div
                    class="flex flex-nowrap items-center p-1 glass-dark rounded-xl border border-white/5 gap-1 overflow-x-auto md:overflow-x-visible custom-scrollbar">
                    <button @click="category = 'all'"
                        :class="category === 'all' ? 'btn-metal shadow-lg text-white' : 'text-gray-500 hover:text-white hover:bg-white/5'"
                        class="flex shrink-0 items-center gap-2 px-5 py-2.5 md:px-10 md:py-3.5 rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all duration-300 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Semua
                    </button>
                    <button @click="category = 'mobile'"
                        :class="category === 'mobile' ? 'btn-metal shadow-lg text-white' : 'text-gray-500 hover:text-white hover:bg-white/5'"
                        class="flex shrink-0 items-center gap-2 px-5 py-2.5 md:px-10 md:py-3.5 rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all duration-300 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Mobile
                    </button>
                    <button @click="category = 'pc'"
                        :class="category === 'pc' ? 'btn-metal shadow-lg text-white' : 'text-gray-500 hover:text-white hover:bg-white/5'"
                        class="flex shrink-0 items-center gap-2 px-5 py-2.5 md:px-10 md:py-3.5 rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all duration-300 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        PC
                    </button>
                    <button @click="category = 'console'"
                        :class="category === 'console' ? 'btn-metal shadow-lg text-white' : 'text-gray-500 hover:text-white hover:bg-white/5'"
                        class="flex shrink-0 items-center gap-2 px-5 py-2.5 md:px-10 md:py-3.5 rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all duration-300 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H7a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 011-1V4z" />
                        </svg>
                        Console
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-12">
            <template
                x-for="game in games.filter(g => (category === 'all' || g.category === category) && (search === '' || g.name.toLowerCase().includes(search.toLowerCase()))).slice(0, 8)"
                :key="game.id">
                <div x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-10 scale-90"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100">

                    <a :href="'/game/' + game.slug"
                        class="block relative aspect-[3/4] rounded-xl overflow-hidden metal-card group">
                        <!-- Image -->
                        <img :src="game.image" :alt="game.name"
                            class="w-full h-full object-cover transition-transform duration-700 opacity-80 group-hover:opacity-100 group-hover:scale-110"
                            loading="lazy">

                        <!-- Category Badge -->
                        <div class="absolute top-4 right-4 z-10">
                            <div
                                class="glass-dark px-3 py-1.5 rounded-xl border border-white/10 group-hover:border-brand-red/50 transition-colors">
                                <p class="text-[10px] text-white font-black uppercase tracking-widest"
                                    x-text="game.category"></p>
                            </div>
                        </div>

                        <!-- Premium Gradient Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-95 group-hover:opacity-100 transition-opacity">
                        </div>

                        <!-- Card Content -->
                        <div
                            class="absolute bottom-8 md:bottom-12 left-0 right-0 px-6 text-center flex flex-col items-center gap-1">
                            <h4 class="text-sm md:text-xl font-black tracking-tight italic uppercase px-1 item-title"
                                x-text="game.name"></h4>
                            <!-- Decorative Line -->
                            <div class="w-0 group-hover:w-12 h-0.5 bg-brand-red transition-all duration-500 mt-1">
                            </div>
                        </div>

                        <!-- Corner Glow -->
                        <div
                            class="absolute -bottom-10 -right-10 w-40 h-40 bg-[radial-gradient(circle,rgba(225,29,72,0.15)_0%,transparent_70%)] opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
                        </div>
                    </a>
                </div>
            </template>
        </div>

        <!-- View All Games Section -->
        <div class="flex justify-center pt-10 md:pt-16 pb-10">
            <a href="{{ route('games.index') }}"
                class="group flex items-center gap-3 md:gap-4 px-8 py-4 md:px-12 md:py-5 bg-white/[0.03] hover:bg-brand-red border border-white/10 hover:border-brand-red rounded-xl md:rounded-xl transition-all duration-300">
                <div class="flex items-center gap-3 md:gap-4">
                    <span class="text-[10px] md:text-sm font-black uppercase tracking-[0.2em] text-white">Lihat
                        Semua Game</span>
                    <div
                        class="w-6 md:w-10 h-px bg-white/20 group-hover:w-10 md:group-hover:w-16 group-hover:bg-white transition-all duration-500">
                    </div>
                    <svg class="w-4 h-4 md:w-5 md:h-5 group-hover:translate-x-2 transition-transform duration-500"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
            </a>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="space-y-16">
        <div class="text-center space-y-4 max-w-2xl mx-auto">
            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-[1px] bg-white/10"></div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Standar Elit</p>
                <div class="w-10 h-[1px] bg-white/10"></div>
            </div>
            <h3 class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter leading-none">
                Kenapa Pilih <span class="text-brand-red">Kami?</span>
            </h3>
            <p class="text-gray-500 text-sm md:text-base font-medium px-4">Kami menghadirkan pengalaman top-up
                paling kencang, aman, dan terpercaya untuk seluruh gamer Indonesia.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="metal-card p-12 rounded-xl relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-48 h-48 bg-[radial-gradient(circle,rgba(225,29,72,0.1)_0%,transparent_70%)] pointer-events-none">
                </div>
                <div
                    class="w-20 h-20 bg-brand-red/10 rounded-xl flex items-center justify-center text-brand-red mb-12 group-hover:scale-110 transition-transform">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h4
                    class="text-3xl font-black uppercase tracking-tighter mb-6 italic bg-gradient-to-b from-white to-white/60 bg-clip-text text-transparent">
                    KILAT</h4>
                <p class="text-gray-400 font-medium text-base leading-relaxed">Voucher masuk dalam hitungan detik
                    setelah pembayaran.</p>
            </div>
            <div class="metal-card p-12 rounded-xl relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-48 h-48 bg-[radial-gradient(circle,rgba(225,29,72,0.1)_0%,transparent_70%)] pointer-events-none">
                </div>
                <div
                    class="w-20 h-20 bg-brand-red/10 rounded-xl flex items-center justify-center text-brand-red mb-12 group-hover:scale-110 transition-transform">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h4
                    class="text-3xl font-black uppercase tracking-tighter mb-6 italic bg-gradient-to-b from-white to-white/60 bg-clip-text text-transparent">
                    AMAN</h4>
                <p class="text-gray-400 font-medium text-base leading-relaxed">Keamanan data dan transaksi adalah
                    prioritas utama kami.</p>
            </div>
            <div class="metal-card p-14 rounded-xl relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-48 h-48 bg-[radial-gradient(circle,rgba(225,29,72,0.1)_0%,transparent_70%)] pointer-events-none">
                </div>
                <div
                    class="w-20 h-20 bg-brand-red/10 rounded-xl flex items-center justify-center text-brand-red mb-12 group-hover:scale-110 transition-transform">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4
                    class="text-3xl font-black uppercase tracking-tighter mb-6 italic bg-gradient-to-b from-white to-white/60 bg-clip-text text-transparent">
                    MURAH</h4>
                <p class="text-gray-400 font-medium text-base leading-relaxed">Dapatkan penawaran terbaik dan promo
                    eksklusif setiap harinya.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="space-y-16">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-[2px] bg-brand-red"></div>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-brand-red">Ulasan Komunitas</p>
                </div>
                <h3 class="text-3xl md:text-6xl font-black italic uppercase tracking-tighter leading-none">
                    Suara <span class="text-brand-red">Pelanggan</span>
                </h3>
            </div>
            <div class="flex-1 h-[1px] bg-white/5 hidden md:block mb-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Review 1 -->
            <div
                class="glass-dark p-8 rounded-xl border border-white/5 flex flex-col h-full space-y-6 hover:bg-white/[0.03] transition-all group">
                <div class="flex gap-1 text-brand-red">
                    <template x-for="i in 5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </template>
                </div>
                <p class="text-gray-400 font-medium text-sm leading-relaxed italic flex-1">"Gila sih, baru bayar
                    sedetik kemudian langsung masuk diamond-nya. Ventuz Store emang paling kenceng!"</p>
                <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                    <div
                        class="w-10 h-10 bg-brand-red/20 rounded-full flex items-center justify-center font-bold text-brand-red text-xs">
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
                <div class="flex gap-1 text-brand-red">
                    <template x-for="i in 5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </template>
                </div>
                <p class="text-gray-400 font-medium text-sm leading-relaxed italic flex-1">"Udah sering top-up di
                    sini buat UC PUBG. Harganya selalu miring dibanding yang lain. Recommended!"</p>
                <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                    <div
                        class="w-10 h-10 bg-brand-red/20 rounded-full flex items-center justify-center font-bold text-brand-red text-xs">
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
                <div class="flex gap-1 text-brand-red">
                    <template x-for="i in 5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </template>
                </div>
                <p class="text-gray-400 font-medium text-sm leading-relaxed italic flex-1">"Baru pertama kali coba
                    dan langsung puas. CS-nya juga ramah banget pas ditanya-tanya. Mantap pokoknya!"</p>
                <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                    <div
                        class="w-10 h-10 bg-brand-red/20 rounded-full flex items-center justify-center font-bold text-brand-red text-xs">
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
                <div class="flex gap-1 text-brand-red">
                    <template x-for="i in 5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </template>
                </div>
                <p class="text-gray-400 font-medium text-sm leading-relaxed italic flex-1">"Gak nyesel langganan di
                    sini. Sistem vouchernya otomatis dan harganya paling masuk akal."</p>
                <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                    <div
                        class="w-10 h-10 bg-brand-red/20 rounded-full flex items-center justify-center font-bold text-brand-red text-xs">
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
    <section class="space-y-16">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-[2px] bg-brand-red"></div>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-brand-red">Update Terbaru</p>
                </div>
                <h3 class="text-3xl md:text-6xl font-black italic uppercase tracking-tighter leading-none">
                    Berita & <span class="text-brand-red">Promo</span>
                </h3>
            </div>
            <a href="/news"
                class="glass-dark px-8 py-4 rounded-xl border border-white/5 text-[10px] font-black uppercase tracking-[0.2em] hover:border-brand-red/50 hover:text-brand-red transition-all whitespace-nowrap mb-2">Lihat
                Semua</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <a href="{{ route('news.detail', $article->slug) }}" class="metal-card rounded-xl overflow-hidden group">
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-8 space-y-4">
                        <div class="flex items-center gap-3">
                            <span
                                class="px-3 py-1 rounded-lg bg-brand-red/10 text-brand-red text-[10px] font-bold uppercase tracking-widest">{{ $article->type }}</span>
                            <span
                                class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">{{ $article->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        <h4
                            class="text-xl font-bold leading-tight group-hover:text-brand-red transition-colors line-clamp-2 uppercase italic">
                            {{ $article->title }}
                        </h4>
                        <p class="text-gray-400 text-sm line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($article->content), 100) }}
                        </p>
                        <!-- Read More Button -->
                        <div class="pt-6 border-t border-white/5 flex items-center justify-between group/btn">
                            <span
                                class="text-[10px] font-black uppercase tracking-widest text-white group-hover/btn:text-brand-red transition-colors">Selengkapnya</span>
                            <div
                                class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover/btn:bg-brand-red transition-all duration-300">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection