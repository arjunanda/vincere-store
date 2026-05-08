@extends('layouts.frontend')

@section('title', $article->title . ' -')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
    
    <!-- Article Content -->
    <div class="lg:col-span-2 space-y-12">
        <!-- Header -->
        <div class="space-y-6">
            <div class="flex items-center gap-4">
                <span class="px-4 py-1.5 rounded-xl bg-brand-neon text-white text-xs font-black uppercase tracking-[0.2em] shadow-[0_0_15px_rgba(124,255,0,0.4)]">
                    {{ $article->type }}
                </span>
                <span class="text-gray-500 text-sm font-bold uppercase tracking-widest">
                    {{ $article->created_at->translatedFormat('d F Y') }}
                </span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black  uppercase tracking-tighter leading-none text-white">
                {{ $article->title }}
            </h1>
        </div>

        <!-- Featured Image -->
        <div class="relative aspect-video rounded-xl overflow-hidden border border-white/10 premium-glow">
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
        </div>

        <!-- Content Body -->
        <div class="news-content prose prose-invert max-w-none">
            {!! nl2br($article->content) !!}
        </div>

        <!-- Social Share -->
        <div class="pt-12 border-t border-white/5 flex items-center justify-between">
            <span class="text-xs font-black uppercase tracking-widest text-gray-500">Bagikan Berita</span>
            <div class="flex gap-4">
                <button class="w-10 h-10 rounded-xl glass-dark flex items-center justify-center hover:bg-brand-neon transition-all">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </button>
                <button class="w-10 h-10 rounded-xl glass-dark flex items-center justify-center hover:bg-brand-neon transition-all">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-12">
        <div class="space-y-8">
            <h5 class="text-xs font-black uppercase tracking-[0.4em] text-brand-neon">Berita Lainnya</h5>
            <div class="space-y-6">
                @foreach($relatedArticles as $related)
                <a href="{{ route('news.detail', $related->slug) }}" class="group flex gap-6 items-start">
                    <div class="w-24 h-20 shrink-0 rounded-xl overflow-hidden border border-white/5">
                        <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="space-y-2">
                        <h6 class="text-sm font-bold uppercase tracking-tight  group-hover:text-brand-neon transition-colors line-clamp-2">{{ $related->title }}</h6>
                        <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">{{ $related->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Banner Ad (Top-up Promo) -->
        <a href="{{ route('games.index') }}" class="block metal-card p-8 rounded-xl relative overflow-hidden group">
            <div class="relative z-10 space-y-6">
                <span class="text-[10px] font-black uppercase tracking-widest text-brand-neon">Special Promo</span>
                <h4 class="text-2xl font-black  uppercase leading-tight tracking-tighter">Top-up Game Favoritmu Sekarang!</h4>
                <button class="btn-metal w-full py-4 rounded-xl text-[10px] font-black uppercase tracking-widest">Gaskeun!</button>
            </div>
            <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-brand-neon opacity-10 blur-3xl group-hover:opacity-20 transition-opacity"></div>
        </a>
    </div>
</div>
@endsection
