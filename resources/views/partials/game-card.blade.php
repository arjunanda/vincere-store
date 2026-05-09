<a href="{{ route('game.detail', $game->slug) }}"
    class="block metal-card p-2 md:p-3 rounded-2xl group transition-all duration-300 h-full">
    
    {{-- Game Cover --}}
    <div class="aspect-square rounded-xl overflow-hidden mb-3 md:mb-4 border border-white/5 group-hover:border-brand-neon/50 transition-colors shadow-lg">
        <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}"
            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
            loading="lazy">
    </div>

    {{-- Info --}}
    <div class="px-1 pb-1 space-y-3">
        <h4 class="text-[9px] sm:text-[10px] md:text-xs font-bold tracking-tight uppercase text-center line-clamp-1 group-hover:text-brand-neon transition-colors">
            {{ $game->name }}
        </h4>

        <div class="flex justify-center">
            <div class="w-full py-2 rounded-xl bg-brand-neon text-black transition-all duration-300 shadow-[0_0_15px_rgba(124,255,0,0.2)] group-hover:shadow-[0_0_25px_rgba(124,255,0,0.4)] group-hover:scale-[1.02]">
                <span class="text-[8px] sm:text-[9px] md:text-[11px] font-black uppercase tracking-widest block text-center">Top Up</span>
            </div>
        </div>
    </div>
</a>
