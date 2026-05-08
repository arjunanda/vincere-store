@extends('layouts.frontend')

@section('title', 'Cek Transaksi -')

@section('main_class', 'max-w-2xl mx-auto px-4 md:px-6 py-12 md:py-20 space-y-8')

@section('content')

    {{-- ── Header ── --}}
    <div class="space-y-1">
        <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-brand-neon">Lacak Pesanan</p>
        <h1 class="text-3xl md:text-4xl font-black tracking-tighter uppercase text-white leading-none">
            Cek <span class="text-brand-neon">Transaksi</span>
        </h1>
        <p class="text-gray-500 text-sm font-medium pt-1">Masukkan Order ID untuk melihat status pesananmu.</p>
    </div>

    {{-- ── Search Form ── --}}
    <div class="rounded-2xl border border-white/[0.07] p-4" style="background:#1a1d27">
        <form action="{{ route('check.transaction') }}" method="GET">
            <div class="flex gap-3">
                <div class="relative flex-1">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-neon pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <input type="text"
                        name="order_id"
                        value="{{ request('order_id') }}"
                        placeholder="Masukkan Order ID..."
                        required
                        class="w-full bg-white/[0.04] border border-white/[0.07] rounded-xl py-3 pl-11 pr-4
                            focus:outline-none focus:border-brand-neon/40 transition-all
                            text-[14px] font-bold tracking-widest uppercase placeholder:text-white/25 placeholder:normal-case placeholder:font-medium placeholder:tracking-normal text-white">
                </div>
                <button type="submit"
                    class="flex-shrink-0 flex items-center gap-2 px-5 py-3 rounded-xl bg-brand-neon text-black font-black text-[13px] uppercase tracking-wide hover:brightness-110 active:scale-[0.97] transition-all shadow-sm shadow-brand-neon/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="hidden sm:inline">Cek</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ── Result ── --}}
    @if(request()->has('order_id'))
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 80)"
            x-show="show"
            x-transition:enter="transition ease-out duration-400"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">

            @if($transaction)
                {{-- Status Badge --}}
                @php
                    $isPending  = $transaction->payment_status === 'pending';
                    $isVerif    = $transaction->payment_status === 'verif';
                    $isSuccess  = in_array($transaction->payment_status, ['success', 'paid', 'completed']);
                    $isFailed   = $transaction->payment_status === 'failed' || $transaction->delivery_status === 'failed';
                @endphp

                <div class="rounded-2xl border overflow-hidden
                    @if($isSuccess) border-emerald-500/30
                    @elseif($isFailed) border-red-500/30
                    @elseif($isVerif) border-brand-neon/30
                    @else border-white/[0.07] @endif"
                    style="background:#1a1d27">

                    {{-- Status Header --}}
                    <div class="px-6 py-5 border-b border-white/[0.07] flex items-center justify-between gap-4
                        @if($isSuccess) bg-emerald-500/[0.05]
                        @elseif($isFailed) bg-red-500/[0.05]
                        @elseif($isVerif) bg-brand-neon/[0.04]
                        @else bg-white/[0.02] @endif">

                        <div class="flex items-center gap-3">
                            {{-- Icon --}}
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                                @if($isSuccess) bg-emerald-500/15 text-emerald-400
                                @elseif($isFailed) bg-red-500/15 text-red-400
                                @elseif($isVerif) bg-brand-neon/15 text-brand-neon
                                @else bg-white/[0.06] text-gray-400 @endif">
                                @if($isSuccess)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif($isFailed)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @elseif($isVerif)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Status Pesanan</p>
                                <p class="text-base font-black uppercase
                                    @if($isSuccess) text-emerald-400
                                    @elseif($isFailed) text-red-400
                                    @elseif($isVerif) text-brand-neon
                                    @else text-white @endif
                                    {{ $isVerif ? 'animate-pulse' : '' }}">
                                    @if($isPending) Menunggu Pembayaran
                                    @elseif($isVerif) Sedang Diverifikasi
                                    @elseif($isSuccess) Berhasil
                                    @else Gagal / Dibatalkan
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="text-right flex-shrink-0">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Order ID</p>
                            <p class="text-sm font-black text-white font-mono">{{ $transaction->order_id }}</p>
                        </div>
                    </div>

                    {{-- Detail Body --}}
                    <div class="p-6 space-y-4">

                        {{-- Product Info --}}
                        <div class="flex items-center gap-4 p-4 rounded-xl border border-white/[0.06] bg-white/[0.02]">
                            <div class="w-14 h-14 rounded-xl overflow-hidden border border-white/[0.07] flex-shrink-0 bg-white/[0.04]">
                                <img src="{{ asset('storage/' . $transaction->game->image) }}"
                                    class="w-full h-full object-cover" alt="{{ $transaction->game_name }}">
                            </div>
                            <div class="min-w-0">
                                <p class="text-[13px] font-black text-white uppercase truncate">{{ $transaction->game_name }}</p>
                                <p class="text-[11px] font-bold text-brand-neon uppercase tracking-wide">{{ $transaction->variant_name }}</p>
                            </div>
                            <div class="ml-auto text-right flex-shrink-0">
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Total</p>
                                <p class="text-sm font-black text-white">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        {{-- Data Rows --}}
                        <div class="space-y-2">
                            {{-- Target / Input Data --}}
                            @foreach($transaction->input_data as $label => $value)
                                <div class="flex items-center justify-between px-4 py-3 rounded-xl border border-white/[0.06] bg-white/[0.02]">
                                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">{{ $label }}</span>
                                    <span class="text-[13px] font-black text-white">{{ $value }}</span>
                                </div>
                            @endforeach

                            {{-- Payment Method --}}
                            <div class="flex items-center justify-between px-4 py-3 rounded-xl border border-white/[0.06] bg-white/[0.02]">
                                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Metode Bayar</span>
                                <span class="text-[13px] font-black text-white">{{ $transaction->payment_method }}</span>
                            </div>

                            {{-- Date --}}
                            <div class="flex items-center justify-between px-4 py-3 rounded-xl border border-white/[0.06] bg-white/[0.02]">
                                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Waktu Transaksi</span>
                                <span class="text-[13px] font-black text-white">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        {{-- CTA Button --}}
                        @if($isPending || ($isVerif && !$transaction->proof_of_payment))
                            <a href="{{ route('checkout.success', $transaction->order_id) }}"
                                class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl bg-brand-neon text-black font-black text-[13px] uppercase tracking-wide hover:brightness-110 active:scale-[0.98] transition-all shadow-sm shadow-brand-neon/20 mt-2">
                                {{ $isVerif ? 'Upload Bukti Pembayaran' : 'Bayar Sekarang' }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

            @else
                {{-- Not Found --}}
                <div class="rounded-2xl border border-red-500/20 overflow-hidden" style="background:#1a1d27">
                    <div class="p-8 text-center space-y-4">
                        <div class="w-14 h-14 mx-auto rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black uppercase text-white">Transaksi Tidak Ditemukan</h3>
                            <p class="text-gray-500 text-sm font-medium mt-1">Periksa kembali Order ID dan coba lagi.</p>
                        </div>

                        @php
                            $waCS = preg_replace('/[^0-9]/', '', $webSettings['contact_wa'] ?? '');
                            if (str_starts_with($waCS, '0')) $waCS = '62' . substr($waCS, 1);
                        @endphp
                        @if($waCS)
                            <a href="https://wa.me/{{ $waCS }}?text=Halo%20Admin%20{{ urlencode($webSettings['web_title'] ?? 'Ventuz Store') }},%20saya%20ingin%20menanyakan%20pesanan%20dengan%20ID%20{{ request('order_id') }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-white/[0.07] bg-white/[0.03] text-[12px] font-bold text-gray-400 hover:text-white hover:border-white/20 hover:bg-white/[0.06] transition-all">
                                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Hubungi Customer Service
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endif

@endsection
