@extends('layouts.dashboard')

@section('content')
<div class="space-y-12">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black italic uppercase tracking-tight text-white">Welcome <span class="text-brand-red">{{ auth()->user()->name }}</span></h1>
            <p class="text-gray-500 font-medium mt-1">Senang melihat Anda kembali hari ini.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="stat-card py-3 px-6 rounded-xl flex items-center gap-4">
                <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></div>
                <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Akun Terverifikasi</span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="stat-card group">
            <div class="flex justify-between items-start mb-8">
                <div class="p-4 bg-brand-red/10 rounded-xl text-brand-red">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <span class="premium-badge">Total Top-up</span>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mb-2">{{ auth()->user()->role === 'admin' ? 'Total Pendapatan' : 'Total Belanja' }}</p>
            <h3 class="text-3xl font-black italic">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
        </div>

        <div class="stat-card">
            <div class="flex justify-between items-start mb-8">
                <div class="p-4 bg-blue-500/10 rounded-xl text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </div>
                <span class="premium-badge bg-blue-500">Pesanan</span>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mb-2">{{ auth()->user()->role === 'admin' ? 'Total Pesanan' : 'Total Transaksi' }}</p>
            <h3 class="text-3xl font-black italic">{{ $stats['total_orders'] }} <span class="text-sm text-gray-600 not-italic uppercase ml-2">Transaksi</span></h3>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="stat-card">
            <div class="flex justify-between items-start mb-8">
                <div class="p-4 bg-purple-500/10 rounded-xl text-purple-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="premium-badge bg-purple-500">Loyalitas</span>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mb-2">Game Aktif</p>
            <h3 class="text-3xl font-black italic">{{ $stats['active_games'] }} <span class="text-sm text-gray-600 not-italic uppercase ml-2">Judul</span></h3>
        </div>
        @endif
    </div>

    <!-- Recent Activity -->
    <div class="stat-card">
        <h4 class="text-xl font-black italic uppercase tracking-tight mb-8">Transaksi Terakhir</h4>
        <div class="space-y-6">
            @forelse($stats['recent_transactions'] as $transaction)
            <div class="flex items-center justify-between p-6 bg-white/[0.02] border border-white/5 rounded-xl hover:border-brand-red/30 transition-all group">
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-brand-red/10 flex items-center justify-center">
                        @if($transaction->game)
                            <img src="{{ $transaction->game->image }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        @endif
                    </div>
                    <div>
                        <h5 class="font-bold text-white group-hover:text-brand-red transition-colors">{{ $transaction->game_name }} - {{ $transaction->variant_name }}</h5>
                        <p class="text-xs text-gray-500 font-medium">{{ $transaction->created_at->format('d M Y • H:i') }} WIB</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-black italic text-white">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    <p class="text-[10px] font-black uppercase tracking-widest {{ $transaction->payment_status == 'paid' ? 'text-green-500' : 'text-yellow-500' }}">
                        {{ strtoupper($transaction->payment_status) }}
                    </p>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-600 py-8 font-medium">Belum ada transaksi terbaru.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
