@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-black  uppercase tracking-tight metallic-text">Pesanan <span class="text-brand-neon">Saya</span></h1>
        <p class="text-gray-500 font-medium mt-1">Riwayat transaksi dan status top-up Anda.</p>
    </div>

    <!-- Empty State -->
    <div class="stat-card py-20 text-center border-dashed border-white/5 border">
        <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Belum ada pesanan</h3>
        <p class="text-gray-600 text-sm mb-8">Anda belum melakukan transaksi apapun di Ventuz Store.</p>
        <a href="{{ route('games.index') }}" class="btn-metal py-3 px-6 rounded-xl font-black uppercase tracking-widest text-[10px] inline-block">
            Belanja Sekarang
        </a>
    </div>
</div>
@endsection
