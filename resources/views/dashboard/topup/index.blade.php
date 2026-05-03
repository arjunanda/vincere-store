@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-black italic uppercase tracking-tight metallic-text">Top-up <span class="text-brand-red">Poin</span></h1>
        <p class="text-gray-500 font-medium mt-1">Isi saldo poin untuk transaksi yang lebih instan dan praktis.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="stat-card">
            <h4 class="text-lg font-black uppercase tracking-widest metallic-text mb-6">Pilih Nominal</h4>
            <div class="grid grid-cols-2 gap-4">
                @foreach([10000, 25000, 50000, 100000] as $amount)
                <button class="p-6 bg-white/[0.03] border border-white/5 rounded-2xl hover:border-brand-red/50 transition-all text-left group">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-1">Top-up</p>
                    <p class="font-black italic text-lg group-hover:text-brand-red">Rp {{ number_format($amount, 0, ',', '.') }}</p>
                </button>
                @endforeach
            </div>
        </div>

        <div class="stat-card bg-brand-red/5 border-brand-red/20 border">
            <div class="flex items-center gap-4 mb-6">
                <div class="p-3 bg-brand-red rounded-xl text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h4 class="font-black uppercase tracking-widest text-white italic">Info Saldo</h4>
            </div>
            <p class="text-gray-400 text-sm leading-relaxed mb-6">Gunakan poin Ventuz untuk proses *instant-processing* tanpa perlu konfirmasi manual setiap kali belanja.</p>
            <div class="p-6 bg-black/40 rounded-2xl border border-white/5">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-600 mb-1">Saldo Poin Anda</p>
                <p class="text-3xl font-black italic text-brand-red">0 <span class="text-xs not-italic text-gray-500 ml-1">POIN</span></p>
            </div>
        </div>
    </div>
</div>
@endsection
