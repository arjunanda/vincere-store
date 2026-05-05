<footer class="bg-black py-24 px-6 mt-40 border-t border-white/5">
    <div class="max-w-7xl w-full mx-auto flex flex-col md:flex-row justify-between gap-16 md:gap-24">
        <div class="w-full md:w-2/5 space-y-12">
            <a href="/">
                <x-logo size="lg" />
            </a>
            <p class="text-gray-500 font-medium text-base leading-loose max-w-md">
                {{ $webSettings['web_description'] ?? 'Ventuz Store adalah platform top-up game paling kencang dan terpercaya di Indonesia. Kami menyediakan layanan top-up 24 jam otomatis untuk berbagai game populer dengan harga termurah.' }}
            </p>
        </div>
        <div class="w-full md:w-1/4 md:mx-auto">
            <h5 class="text-xs font-bold uppercase tracking-[0.5em] text-brand-red mb-8 md:mb-12 text-left">
                Layanan</h5>
            <ul class="space-y-6 md:space-y-8 text-gray-400 font-bold uppercase text-xs tracking-widest text-left">
                <li><a href="{{ route('games.index') }}" class="hover:text-white transition-colors">Semua Game</a></li>
                <li><a href="{{ route('check.transaction') }}" class="hover:text-white transition-colors">Lacak Pesanan</a></li>
                <li><a href="{{ route('news.index') }}" class="hover:text-white transition-colors">Berita Gaming</a></li>
                <li><a href="/sitemap.xml" class="hover:text-white transition-colors">Sitemap</a></li>
            </ul>
        </div>
        <div class="w-full" style="max-width: 320px;">
            <h5 class="text-xs font-bold uppercase tracking-[0.5em] text-brand-red mb-8 md:mb-12 text-left md:text-right">
                Metode Bayar</h5>
            <div class="flex flex-wrap gap-3 md:justify-end">
                @isset($paymentMethods)
                    @foreach ($paymentMethods->take(9) as $method)
                        <div
                            class="glass-dark rounded-xl flex items-center justify-center p-2 hover:border-brand-red/50 transition-colors border border-white/5 overflow-hidden"
                            style="width: 70px; height: 40px;">
                            @if ($method->image)
                                <img src="{{ asset('storage/' . $method->image) }}" alt="{{ $method->name }}"
                                    class="h-full w-full object-contain filter grayscale brightness-200 hover:grayscale-0 transition-all duration-300">
                            @else
                                <span class="text-[8px] md:text-[10px] font-black tracking-widest text-white/50 text-center leading-tight truncate w-full">{{ $method->name }}</span>
                            @endif
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
    <div class="max-w-7xl w-full mx-auto mt-24 pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8 md:gap-12">
        <p class="text-gray-600 text-xs font-bold uppercase tracking-widest text-center md:text-left">&copy; {{ date('Y') }} Ventuz Store. Seluruh Hak Cipta Dilindungi.</p>
        
        <div class="flex flex-col md:flex-row items-center gap-6 md:gap-12">
            <div class="flex gap-6 md:gap-10 text-gray-600 text-xs font-bold uppercase tracking-widest">
                <a href="#" class="hover:text-brand-red transition-colors">Privasi</a>
                <a href="#" class="hover:text-brand-red transition-colors">Syarat & Ketentuan</a>
            </div>
            
            <div class="h-4 w-px bg-white/10 hidden md:block"></div>
            
            <div class="flex gap-6 items-center">
                @php
                    $waCS = preg_replace('/[^0-9]/', '', $webSettings['contact_wa'] ?? '');
                    if (str_starts_with($waCS, '0')) $waCS = '62' . substr($waCS, 1);
                    
                    $igLink = $webSettings['contact_ig'] ?? '#';
                    if ($igLink !== '#' && !str_starts_with($igLink, 'http')) {
                        $igLink = 'https://instagram.com/' . ltrim($igLink, '@');
                    }
                    
                    $fbLink = $webSettings['contact_fb'] ?? '';
                    $emailLink = $webSettings['contact_email'] ?? '';
                @endphp
                
                @if($emailLink)
                <a href="mailto:{{ $emailLink }}" class="text-gray-600 hover:text-brand-red transition-transform hover:scale-110" title="Email Support">
                    <svg class="w-5 h-5 fill-current" viewBox="2 2 20 20">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                </a>
                @endif
                
                @if($fbLink)
                <a href="{{ str_starts_with($fbLink, 'http') ? $fbLink : 'https://' . $fbLink }}" target="_blank" class="text-gray-600 hover:text-brand-red transition-transform hover:scale-110" title="Facebook">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z"/>
                    </svg>
                </a>
                @endif
                
                @if($igLink !== '#')
                <a href="{{ $igLink }}" target="_blank" class="text-gray-600 hover:text-brand-red transition-transform hover:scale-110" title="Instagram">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.054 1.805.249 2.227.412.56.216.96.474 1.38.894.42.42.678.82.894 1.38.163.422.358 1.057.412 2.227.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.054 1.17-.249 1.805-.412 2.227-.216.56-.474.96-.894 1.38-.42.42-.82.678-1.38.894-.422.163-1.057.358-2.227.412-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.054-1.805-.249-2.227-.412-.56-.216-.96-.474-1.38-.894-.42-.42-.678-.82-.894-1.38-.163-.422-.358-1.057-.412-2.227-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.054-1.17.249-1.805.412-2.227.216-.56.474-.96.894-1.38.42-.42.82-.678 1.38-.894.422-.163 1.057-.358 2.227-.412 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.277.057-2.148.258-2.911.554-.789.307-1.459.717-2.126 1.384-.666.667-1.077 1.337-1.383 2.126-.297.764-.498 1.634-.555 2.911-.058 1.28-.073 1.688-.073 4.947s.015 3.667.072 4.947c.057 1.277.258 2.148.554 2.911.307.789.717 1.459 1.384 2.126.667.666 1.337 1.077 2.126 1.383.764.297 1.634.498 2.911.555 1.28.058 1.688.073 4.947.073s3.667-.015 4.947-.072c1.277-.057 2.148-.258 2.911-.554.789-.307 1.459-.717 2.126-1.384.666-.667 1.077-1.337 1.383-2.126.297-.764.498-1.634.555-2.911.058-1.28.073-1.688.073-4.947s-.015-3.667-.072-4.947c-.057-1.277-.258-2.148-.554-2.911-.307-.789-.717-1.459-1.384-2.126-.667-.666-1.337-1.077-2.126-1.383-.764-.297-1.634-.498-2.911-.555-1.28-.058-1.688-.073-4.947-.073z"/>
                        <path d="M12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </div>
</footer>

<!-- CS Floating Menu -->
<div class="whatsapp-float flex" x-data="{ open: false }">
    <!-- Menu Items -->
    <div class="flex flex-col gap-4 mb-2" 
         x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-50"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-50">
        
        <!-- Instagram -->
        <a href="{{ $igLink }}" target="_blank" class="cs-menu-item cs-ig group">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.054 1.805.249 2.227.412.56.216.96.474 1.38.894.42.42.678.82.894 1.38.163.422.358 1.057.412 2.227.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.054 1.17-.249 1.805-.412 2.227-.216.56-.474.96-.894 1.38-.42.42-.82.678-1.38.894-.422.163-1.057.358-2.227.412-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.054-1.805-.249-2.227-.412-.56-.216-.96-.474-1.38-.894-.42-.42-.678-.82-.894-1.38-.163-.422-.358-1.057-.412-2.227-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.054-1.17.249-1.805.412-2.227.216-.56.474-.96.894-1.38.42-.42.82-.678 1.38-.894.422-.163 1.057-.358 2.227-.412 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.277.057-2.148.258-2.911.554-.789.307-1.459.717-2.126 1.384-.666.667-1.077 1.337-1.383 2.126-.297.764-.498 1.634-.555 2.911-.058 1.28-.073 1.688-.073 4.947s.015 3.667.072 4.947c.057 1.277.258 2.148.554 2.911.307.789.717 1.459 1.384 2.126.667.666 1.337 1.077 2.126 1.383.764.297 1.634.498 2.911.555 1.28.058 1.688.073 4.947.073s3.667-.015 4.947-.072c1.277-.057 2.148-.258 2.911-.554.789-.307 1.459-.717 2.126-1.384.666-.667 1.077-1.337 1.383-2.126.297-.764.498-1.634.555-2.911.058-1.28.073-1.688.073-4.947s-.015-3.667-.072-4.947c-.057-1.277-.258-2.148-.554-2.911-.307-.789-.717-1.459-1.384-2.126-.667-.666-1.337-1.077-2.126-1.383-.764-.297-1.634-.498-2.911-.555-1.28-.058-1.688-.073-4.947-.073z"/>
                <path d="M12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
        </a>

        <!-- WhatsApp -->
        <a href="https://wa.me/{{ $waCS }}?text=Halo%20Admin%20{{ urlencode($webSettings['web_title'] ?? 'Ventuz Store') }},%20saya%20ingin%20bertanya%20tentang..." target="_blank" class="cs-menu-item cs-wa group">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </a>
    </div>

    <!-- Main Button -->
    <button @click="open = !open" 
            class="cs-main-btn group relative" 
            :class="open ? 'active' : ''">
        <div class="whatsapp-pulse" x-show="!open"></div>
        
        <!-- Icons Toggle -->
        <div class="relative w-5 h-5">
            <svg x-show="!open" class="absolute inset-0 w-5 h-5 fill-current" viewBox="0 0 24 24">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
            </svg>
            <svg x-show="open" class="absolute inset-0 w-5 h-5 fill-current" viewBox="0 0 24 24">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
            </svg>
        </div>
        
        <span class="font-black uppercase tracking-widest text-[10px] md:text-xs">Chat CS</span>
    </button>
</div>