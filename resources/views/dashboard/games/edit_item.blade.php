@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8 max-w-2xl mx-auto">
        <div>
            <a href="{{ route('dashboard.games.items', $variant->game_id) }}"
                class="text-xs font-black uppercase tracking-widest text-gray-500 hover:text-brand-neon flex items-center gap-2 mb-4 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Set Item
            </a>
            <h1 class="text-3xl font-black  uppercase tracking-tight text-white">Edit <span
                    class="text-brand-neon">Item</span></h1>
            <p class="text-gray-500 font-medium mt-1">Ubah nama atau harga item untuk game {{ $variant->game->name }}.</p>
        </div>

        <form action="{{ route('dashboard.items.update', $variant) }}" method="POST" class="stat-card space-y-6" novalidate>
            @csrf
            @method('PUT')

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Nama Item
                    (Varian)</label>
                <input type="text" name="name" value="{{ $variant->name }}" required
                    class="w-full input-metal rounded-2xl py-4 px-6">
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Harga Jual (Rp)</label>
                <input type="number" name="price" value="{{ $variant->price }}" required
                    class="w-full input-metal rounded-2xl py-4 px-6">
            </div>

            <button type="submit"
                class="btn-metal w-full py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-brand-neon/20 mt-4">
                Perbarui Item
            </button>
        </form>
    </div>
@endsection