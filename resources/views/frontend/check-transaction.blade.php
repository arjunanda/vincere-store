@extends('layouts.frontend')

@section('title', 'Cek Transaksi -')

@section('main_class', 'min-h-[80vh] flex flex-col items-center justify-center py-24 px-6 relative overflow-hidden')

@section('content')
<!-- Background Decor -->
<div class="absolute top-1/4 left-0 w-96 h-96 bg-brand-red/10 rounded-full blur-[120px] -z-10"></div>
<div class="absolute bottom-1/4 right-0 w-96 h-96 bg-brand-red/5 rounded-full blur-[150px] -z-10"></div>

<div class="max-w-4xl w-full space-y-12 relative z-10">
    <!-- Header -->
    <div class="text-center space-y-4">
        <h1 class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter metallic-text">Cek <span class="text-brand-red">Transaksi</span></h1>
        <p class="text-gray-500 font-bold uppercase tracking-[0.3em] text-[10px] md:text-xs">Lacak status pesanan Anda secara real-time</p>
    </div>

    <!-- Search Box -->
    <div class="metal-card rounded-[2rem] p-3 md:p-4 shadow-2xl">
        <form action="{{ route('check.transaction') }}" method="GET" class="relative group">
            <input type="text" 
                   name="order_id" 
                   value="{{ request('order_id') }}"
                   placeholder="Masukkan Order ID" 
                   class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-4 px-6 md:px-8 focus:outline-none focus:border-brand-red/50 transition-all text-sm md:text-lg font-bold tracking-widest placeholder:text-gray-700 uppercase"
                   required>
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-brand-red hover:brightness-110 text-white px-6 md:px-10 py-2.5 rounded-xl font-black uppercase tracking-widest shadow-lg shadow-brand-red/20 transition-all active:scale-95 text-[10px] md:text-xs">
                Cek <span class="hidden md:inline">Transaksi</span>
            </button>
        </form>
    </div>

    <!-- Results Section -->
    @if(request()->has('order_id'))
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" x-show="show" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
            @if($transaction)
                <div class="metal-card rounded-xl overflow-hidden shadow-2xl border-brand-red/20 relative">
                    @if(in_array($transaction->payment_status, ['success', 'paid', 'completed']))
                        <div class="stamp stamp-success">SUCCESS</div>
                    @elseif($transaction->payment_status === 'failed' || $transaction->delivery_status === 'failed')
                        <div class="stamp stamp-failed">FAILED</div>
                    @endif
                    <!-- Top Info -->
                    <div class="bg-brand-red/5 p-8 border-b border-white/5 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest leading-none">Status Pesanan</p>
                            <div class="flex items-center gap-3">
                                @if($transaction->payment_status === 'pending')
                                    <h2 class="text-xl md:text-3xl font-black italic uppercase text-white">Menunggu Pembayaran</h2>
                                @elseif($transaction->payment_status === 'verif')
                                    <h2 class="text-2xl md:text-3xl font-black italic uppercase text-brand-red animate-pulse">Sedang Diverifikasi</h2>
                                @elseif($transaction->payment_status === 'success' || $transaction->payment_status === 'paid' || $transaction->payment_status === 'completed')
                                    <h2 class="text-2xl md:text-3xl font-black italic uppercase text-emerald-500">Berhasil</h2>
                                @else
                                    <h2 class="text-2xl md:text-3xl font-black italic uppercase text-red-600">Gagal / Dibatalkan</h2>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest">Order ID</p>
                            <p class="text-xl font-black text-white italic">{{ $transaction->order_id }}</p>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="p-8 grid grid-cols-1 gap-10">
                        <!-- Left Details -->
                        <div class="space-y-6">
                            <div class="space-y-4">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 border-b border-white/5 pb-2">Informasi Produk</h4>
                                <div class="space-y-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 bg-white/5 rounded-xl p-2 border border-white/5 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $transaction->game->image) }}" class="w-full h-full object-contain" alt="">
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-white italic uppercase">{{ $transaction->game_name }}</p>
                                            <p class="text-[10px] font-bold text-brand-red uppercase tracking-widest">{{ $transaction->variant_name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 pt-4">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 border-b border-white/5 pb-2">Tujuan Pengiriman</h4>
                                <div class="space-y-3">
                                    @foreach($transaction->input_data as $label => $value)
                                    <div class="flex justify-between items-center bg-white/[0.02] p-3 rounded-xl border border-white/5">
                                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">{{ $label }}</span>
                                        <span class="text-xs font-black text-white uppercase">{{ $value }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Right Details -->
                        <div class="space-y-6">
                        @if($transaction->payment_status === 'pending' || $transaction->payment_status === 'verif')
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 border-b border-white/5 pb-2">Detail Pembayaran</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center bg-white/[0.02] p-3 rounded-xl border border-white/5">
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Metode</span>
                                    <span class="text-xs font-black text-white uppercase">{{ $transaction->payment_method }}</span>
                                </div>
                                <div class="flex justify-between items-center bg-brand-red/5 p-4 rounded-xl border border-brand-red/10">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Bayar</span>
                                    <span class="text-xl font-black italic text-brand-red">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                            <div class="space-y-4 pt-4">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 border-b border-white/5 pb-2">Waktu Transaksi</h4>
                                <div class="flex items-center gap-3 bg-white/[0.02] p-4 rounded-xl border border-white/5">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-xs font-black text-white uppercase tracking-widest">{{ $transaction->created_at->format('d F Y, H:i') }}</span>
                                </div>
                            </div>

                            @if($transaction->payment_status === 'pending' || ($transaction->payment_status === 'verif' && !$transaction->proof_of_payment))
                                <a href="{{ route('checkout.success', $transaction->order_id) }}" class="flex items-center justify-center gap-3 w-full py-5 bg-brand-red text-white rounded-xl font-black uppercase tracking-widest text-xs hover:scale-[1.02] active:scale-[0.98] transition-all shadow-lg shadow-brand-red/20 mt-4">
                                    {{ $transaction->payment_status === 'verif' ? 'Upload Bukti' : 'Bayar Sekarang' }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="metal-card rounded-xl p-12 text-center space-y-6 shadow-2xl border-white/5 bg-red-500/5">
                    <div class="flex justify-center">
                        <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center text-red-500">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-2xl font-black italic uppercase text-white">Transaksi Tidak Ditemukan</h3>
                        <p class="text-gray-500 font-bold uppercase tracking-widest text-[10px]">Periksa kembali Order ID Anda dan coba lagi.</p>
                    </div>
                    <div class="pt-4">
                        @php
                            $waCS = preg_replace('/[^0-9]/', '', $webSettings['contact_wa'] ?? '');
                            if (str_starts_with($waCS, '0')) $waCS = '62' . substr($waCS, 1);
                        @endphp
                        <a href="https://wa.me/{{ $waCS }}" target="_blank" class="text-[10px] font-black text-brand-red uppercase tracking-widest hover:text-red-400 transition-colors">Bantuan Customer Service</a>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
