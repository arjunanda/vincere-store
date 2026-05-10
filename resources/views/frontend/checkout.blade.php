@extends('layouts.frontend')

@section('title', 'Invoice Pembelian - ' . ($game->name ?? 'Vincere Store'))

@section('hide_layout_elements', true)

@section('body_attr')
    x-data="{
    imagePreview: null,
    imageLoading: false,
    isLoading: false,
    handleFileChange(event) {
    const file = event.target.files[0];
    if (file) {
    this.imageLoading = true;
    if (this.imagePreview && this.imagePreview.startsWith('blob:')) {
    URL.revokeObjectURL(this.imagePreview);
    }
    this.imagePreview = URL.createObjectURL(file);
    }
    }
    }"
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const orderId = "{{ $transaction->order_id }}";
            const initialStatus = "{{ $transaction->delivery_status }}";
            const initialPaymentStatus = "{{ $transaction->payment_status }}";

            if (['success', 'completed', 'failed'].includes(initialStatus) || initialPaymentStatus === 'paid') {
                return;
            }

            if (window.Echo) {
                window.Echo.channel(`order.${orderId}`)
                    .listen('OrderStatusUpdated', (e) => {
                        if (['success', 'completed', 'failed'].includes(e.delivery_status) || e.payment_status === 'paid') {
                            window.location.reload();
                        }
                    });
            }
        });
    </script>
@endpush

@section('main_class', 'py-8 md:py-16 px-4 md:px-6 max-w-2xl mx-auto')

    @section('content')
        <div class="space-y-8">
            <!-- Main Invoice Card -->
            <div class="metal-card rounded-3xl overflow-hidden border-white/5 shadow-xl">
                <div class="p-6 md:p-10 space-y-6">

                    <!-- Title & Order ID -->
                    <div class="text-center space-y-2">
                        <h1 class="text-2xl md:text-4xl font-black uppercase tracking-tight">
                            Invoice <span class="text-brand-neon">Pembelian</span>
                        </h1>
                        <div class="flex items-center justify-center gap-3 group cursor-pointer"
                            onclick="navigator.clipboard.writeText('{{ $transaction->order_id }}'); alert('ID Transaksi berhasil disalin!')">
                            <p class="text-xs md:text-sm text-gray-500 font-bold uppercase tracking-widest">
                                #{{ $transaction->order_id }}
                            </p>
                            <div
                                class="p-1.5 rounded-lg bg-white/10 border border-white/10 group-hover:bg-brand-neon/15 group-hover:border-brand-neon/40 transition-all">
                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-brand-neon transition-colors" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        @if($transaction->payment_status === 'pending')
                            <p class="text-[10px] font-black uppercase tracking-widest text-brand-neon animate-pulse">Menunggu
                                Pembayaran</p>
                        @elseif($transaction->payment_status === 'verif')
                            <p class="text-[10px] font-black uppercase tracking-widest text-amber-500">Menunggu Verifikasi</p>
                        @endif
                    </div>

                    <hr class="border-white/5">

                    <!-- Detail Items -->
                    <div class="space-y-3 text-[11px] md:text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Game</span>
                            <span class="text-white font-bold uppercase">{{ $game->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Item</span>
                            <span class="text-brand-neon font-bold uppercase">{{ $variant->name }}</span>
                        </div>
                        @foreach($transaction->input_data as $label => $value)
                            <div class="flex justify-between">
                                <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">{{ $label }}</span>
                                <span class="text-white font-bold uppercase text-right">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>

                    <hr class="border-white/5">

                    <!-- Total -->
                    <div class="flex flex-col md:flex-row justify-between items-center gap-3 py-2">
                        <span class="text-gray-400 font-black uppercase tracking-widest text-xs">Total Tagihan</span>
                        <div class="flex items-center gap-3 group cursor-pointer"
                            onclick="navigator.clipboard.writeText('{{ $transaction->total_price }}'); alert('Total bayar berhasil disalin!')">
                            <span class="text-lg md:text-3xl font-black text-white">
                                Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                            </span>
                            <div
                                class="p-1.5 rounded-lg bg-white/10 border border-white/10 group-hover:bg-brand-neon/15 group-hover:border-brand-neon/40 transition-all shrink-0">
                                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-gray-400 group-hover:text-brand-neon transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    @if($transaction->payment_status === 'pending' || $transaction->payment_status === 'verif')
                        <hr class="border-white/5">

                        <div class="text-center space-y-4">
                            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Instruksi Pembayaran</p>

                            @if($paymentMethod->type === 'qris')
                                <p class="text-xs text-gray-400">
                                    Bayar via <span
                                        class="text-brand-neon font-bold">{{ $paymentMethod?->code ?? $paymentMethod?->name ?? '—' }}</span>
                                </p>
                                <div class="bg-white p-4 rounded-2xl inline-block">
                                    <img src="{{ asset('storage/' . $paymentMethod->qris_image) }}" class="w-48 md:w-56 h-auto"
                                        alt="QRIS">
                                </div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest animate-pulse">Scan QR di atas
                                    untuk bayar</p>
                            @else
                                <p class="text-xs text-gray-400">
                                    Bayar via <span
                                        class="text-brand-neon font-bold">{{ $paymentMethod?->code ?? $paymentMethod?->name ?? '—' }}</span>
                                    &mdash; transfer tepat sesuai tagihan
                                </p>
                                <div
                                    class="relative bg-gradient-to-b from-white/[0.05] to-transparent border border-white/5 rounded-xl p-4 space-y-4 max-w-xs mx-auto shadow-lg shadow-brand-neon/5">
                                    <div
                                        class="absolute top-0 left-0 w-full h-full rounded-xl bg-gradient-to-b from-brand-neon/[0.03] to-transparent pointer-events-none">
                                    </div>
                                    <p class="text-xl md:text-2xl font-black text-white tracking-tight relative">
                                        {{ $paymentMethod->bank_name ?: $paymentMethod->name }}</p>
                                    <div class="flex flex-wrap justify-center items-center gap-2 relative">
                                        <span
                                            class="text-white font-bold text-lg md:text-xl break-all tracking-wider">{{ $paymentMethod->account_number }}</span>
                                        <div class="group cursor-pointer shrink-0 p-1.5 rounded-lg bg-white/10 border border-white/10 hover:bg-brand-neon/15 hover:border-brand-neon/40 transition-all hover:shadow-lg hover:shadow-brand-neon/20"
                                            onclick="navigator.clipboard.writeText('{{ $paymentMethod->account_number }}'); alert('No. rekening berhasil disalin!')">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-brand-neon transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider relative">A/N <span
                                            class="text-white">{{ $paymentMethod->account_name }}</span></p>
                                </div>
                            @endif
                        </div>

                        @if($transaction->payment_status === 'pending')
                            <div class="space-y-3 pt-4">
                                <div class="bg-brand-neon/5 border border-white/5 p-4 rounded-xl text-center">
                                    <p class="text-xs text-gray-400">Kadaluarsa dalam <span class="text-white font-bold">24 Jam</span>
                                        jika tidak dibayar</p>
                                </div>
                                <div class="bg-amber-500/10 border border-amber-500/20 p-4 rounded-xl text-center">
                                    <p class="text-xs text-amber-500 font-bold">Setelah bayar, upload bukti transfer di bawah ini</p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Proof of Payment -->
            @if($transaction->payment_status === 'pending' || ($transaction->payment_status === 'verif' && !$transaction->proof_of_payment))
                <div class="metal-card rounded-3xl overflow-hidden border-white/5 shadow-xl">
                    <div class="p-6 md:p-8 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-brand-neon/10 rounded-xl flex items-center justify-center text-brand-neon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black uppercase text-white">Upload Bukti</h3>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Kirim bukti transfer</p>
                            </div>
                        </div>

                        <form action="{{ route('checkout.proof', $transaction->order_id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-4" x-on:submit="isLoading = true">
                            @csrf
                            @if($errors->any())
                                <div
                                    class="bg-red-500/10 border border-red-500/20 text-red-500 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div>
                                <input type="file" name="proof_of_payment" id="proof_of_payment" accept="image/*" class="hidden"
                                    @change="handleFileChange" required>
                                <label for="proof_of_payment"
                                    class="flex flex-col items-center justify-center w-full aspect-video rounded-2xl border-2 border-dashed border-white/10 bg-white/[0.02] hover:border-brand-neon/30 transition-all cursor-pointer overflow-hidden">
                                    <div x-show="imagePreview"
                                        class="absolute inset-0 w-full h-full bg-[#050505] flex items-center justify-center"
                                        x-cloak>
                                        <div x-show="imageLoading">
                                            <svg class="animate-spin h-8 w-8 text-brand-neon" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </div>
                                        <img :src="imagePreview" class="w-full h-full object-contain" @load="imageLoading = false">
                                    </div>
                                    <div x-show="!imagePreview" class="flex flex-col items-center py-8 space-y-2">
                                        <div
                                            class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center text-gray-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>
                                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Klik untuk upload
                                            bukti</p>
                                    </div>
                                </label>
                            </div>

                            <button type="submit"
                                class="btn-metal relative w-full py-4 rounded-xl font-black uppercase tracking-widest text-[11px] disabled:opacity-50"
                                :disabled="!imagePreview || isLoading">
                                <span x-show="!isLoading">Konfirmasi Pembayaran</span>
                                <span x-show="isLoading">Memproses...</span>
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($transaction->payment_status === 'verif' && $transaction->proof_of_payment)
                <div class="bg-brand-neon/10 border border-brand-neon/30 p-6 rounded-2xl text-center space-y-3">
                    <div class="w-12 h-12 bg-brand-neon text-white rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-black uppercase text-white">Bukti Terkirim!</h4>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Tunggu 3-5 menit untuk verifikasi</p>
                    <a href="{{ route('index') }}"
                        class="inline-block text-[10px] font-bold text-brand-neon uppercase tracking-widest mt-2">Kembali ke
                        Beranda</a>
                </div>
            @endif

            <!-- Footer -->
            <div class="text-center space-y-3 pt-2">
                <p class="text-[10px] text-gray-600 font-bold uppercase tracking-widest">* Simpan halaman ini atau catat ID
                    Transaksi</p>
                <div class="flex justify-center gap-4 text-[10px]">
                    <a href="{{ route('index') }}" class="text-gray-500 hover:text-white uppercase tracking-wider">Beranda</a>
                    <span class="text-gray-800">|</span>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $webSettings['contact_wa'] ?? '') }}" target="_blank"
                        class="text-gray-500 hover:text-white uppercase tracking-wider">Bantuan CS</a>
                </div>
            </div>
        </div>
    @endsection