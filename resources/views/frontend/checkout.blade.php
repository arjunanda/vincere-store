@extends('layouts.frontend')

@section('title', 'Invoice Pembelian - ' . ($game->name ?? 'Ventuz Store'))

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
    <div class="space-y-6 md:space-y-10">
        <!-- Main Invoice Card -->
        <div class="metal-card rounded-[2.5rem] overflow-hidden border-white/5 shadow-2xl relative">
            <!-- Decorative Stamps for Success/Fail -->
            @if(in_array($transaction->payment_status, ['success', 'paid', 'completed']))
                <div class="stamp stamp-success text-2xl md:text-4xl">SUCCESS</div>
            @elseif($transaction->payment_status === 'failed' || $transaction->delivery_status === 'failed')
                <div class="stamp stamp-failed text-2xl md:text-4xl">FAILED</div>
            @endif

            <div class="p-6 md:p-12 space-y-8 md:space-y-12">
                <!-- 1. Title and Transaction Number -->
                <div class="text-center space-y-3">
                    <h1
                        class="text-3xl md:text-5xl font-black  uppercase tracking-tighter metallic-text leading-none">
                        Invoice <span class="text-brand-neon">Pembelian</span>
                    </h1>
                    <div class="flex flex-col items-center gap-1">
                        <div class="flex items-center justify-center gap-2 group cursor-pointer active:scale-95 transition-transform"
                            onclick="navigator.clipboard.writeText('{{ $transaction->order_id }}'); alert('ID Transaksi berhasil disalin!')">
                            <p class="text-[11px] md:text-sm text-gray-500 font-bold uppercase tracking-[0.3em]">
                                #{{ $transaction->order_id }}
                            </p>
                            <svg class="w-3.5 h-3.5 text-gray-600 group-hover:text-brand-neon transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                        </div>
                        @if($transaction->payment_status === 'pending')
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-brand-neon animate-pulse">Menunggu Pembayaran</p>
                        @elseif($transaction->payment_status === 'verif')
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-amber-500">Menunggu Verifikasi</p>
                        @endif
                    </div>
                </div>

                <!-- 2. Game, Item, Target, and Bill Details -->
                <div class="space-y-6 md:space-y-8">
                    <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

                    <div class="grid grid-cols-1 gap-5 md:gap-6">
                        <div class="flex justify-between items-center px-1">
                            <span class="text-[10px] md:text-xs font-bold text-gray-500 uppercase tracking-widest">Game /
                                Product</span>
                            <span
                                class="text-xs md:text-base font-black text-white  uppercase">{{ $game->name }}</span>
                        </div>
                        <div class="flex justify-between items-center px-1">
                            <span class="text-[10px] md:text-xs font-bold text-gray-500 uppercase tracking-widest">Item /
                                Variant</span>
                            <span
                                class="text-xs md:text-base font-black text-brand-neon  uppercase">{{ $variant->name }}</span>
                        </div>

                        <div class="py-2 space-y-3">
                            @foreach($transaction->input_data as $label => $value)
                                <div class="flex justify-between items-start px-1 gap-4">
                                    <span
                                        class="text-[10px] md:text-xs font-bold text-gray-500 uppercase tracking-widest pt-1 leading-none">{{ $label }}</span>
                                    <span
                                        class="text-xs md:text-base font-black text-white uppercase text-right leading-tight">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div
                            class="mt-4 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 bg-white/[0.03] -mx-6 md:-mx-12 px-8 md:px-12 py-8 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1 h-full bg-brand-neon"></div>
                            <span class="text-xs md:text-sm font-black text-gray-400 uppercase tracking-[0.3em]">Total
                                Tagihan</span>
                            <div class="flex items-center gap-3 group cursor-pointer active:scale-95 transition-all"
                                onclick="navigator.clipboard.writeText('{{ $transaction->total_price }}'); alert('Total bayar berhasil disalin!')">
                                <span class="text-2xl md:text-4xl font-black  text-white leading-none">
                                    <span
                                        class="text-brand-neon text-lg md:text-xl mr-1">Rp</span>{{ number_format($transaction->total_price, 0, ',', '.') }}
                                </span>
                                <div
                                    class="p-2 bg-white/5 rounded-lg text-gray-500 group-hover:text-brand-neon transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Account Information (Dashed Box) -->
                @if($transaction->payment_status === 'pending' || $transaction->payment_status === 'verif')
                    <div class="space-y-6">
                        <p class="text-center text-[10px] font-black text-gray-500 uppercase tracking-[0.3em]">Instruksi
                            Pembayaran</p>
                        <div
                            class="border-2 border-dashed border-white/10 rounded-[2rem] p-6 md:p-10 bg-white/[0.01] relative overflow-hidden group hover:border-brand-neon/30 transition-all shadow-inner">
                            <div class="flex flex-col items-center gap-6">
                                <div class="text-center space-y-4">
                                    <p
                                        class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest leading-relaxed px-4">
                                        Anda memilih bayar via <span class="text-brand-neon">{{ $paymentMethod->name }}</span>,
                                        silahkan transfer tepat sesuai tagihan ke rekening utama kami:
                                    </p>
                                    <div class="inline-block bg-white/5 p-2 rounded-2xl border border-white/5">
                                        <img src="{{ asset('storage/' . $paymentMethod->image) }}"
                                            class="w-12 h-12 md:w-16 md:h-16 object-contain" alt="{{ $paymentMethod->name }}">
                                    </div>
                                </div>

                                @if($paymentMethod->type === 'qris')
                                    <div
                                        class="bg-white p-5 rounded-3xl shadow-[0_0_50px_rgba(255,255,255,0.1)] relative group/qris">
                                        <img src="{{ asset('storage/' . $paymentMethod->qris_image) }}" class="w-56 md:w-72 h-auto"
                                            alt="QRIS">
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover/qris:opacity-100 transition-opacity flex items-center justify-center rounded-3xl backdrop-blur-[2px]">
                                            <span class="text-xs font-black uppercase tracking-widest text-white">Scan to Pay</span>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em] animate-pulse">Silakan
                                        scan kode QR di atas</p>
                                @else
                                    <div class="text-center space-y-4 w-full">
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-center gap-3 group cursor-pointer active:scale-95 transition-all"
                                                onclick="navigator.clipboard.writeText('{{ $paymentMethod->account_number }}'); alert('Nomor rekening berhasil disalin!')">
                                                <h3 class="text-2xl md:text-4xl font-black  text-white tracking-tight break-all leading-none"
                                                    id="acc_number">
                                                    {{ $paymentMethod->account_number }}
                                                </h3>
                                                <div
                                                    class="p-2 bg-white/5 rounded-xl text-gray-500 group-hover:text-brand-neon transition-colors shrink-0">
                                                    <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-center gap-2 pt-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-brand-neon"></span>
                                                <p class="text-xs md:text-sm font-bold text-gray-400 uppercase tracking-widest">A/N
                                                    {{ $paymentMethod->account_name }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($transaction->payment_status === 'pending')
                            <div class="bg-brand-neon/5 border border-white/5 p-4 rounded-2xl flex items-center gap-4">
                                <div
                                    class="w-8 h-8 bg-brand-neon/20 rounded-full flex items-center justify-center text-brand-neon shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-[10px] md:text-xs text-gray-400 font-medium ">
                                    Pembayaran akan dibatalkan otomatis jika dalam <span class="text-white font-black">24 Jam</span>
                                    tagihan tidak dibayar.
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Proof of Payment Card -->
        @if($transaction->payment_status === 'pending' || ($transaction->payment_status === 'verif' && !$transaction->proof_of_payment))
            <div class="metal-card rounded-3xl overflow-hidden border-white/5 shadow-2xl">
                <div class="p-8 md:p-10 space-y-8">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-brand-neon/10 rounded-2xl flex items-center justify-center text-brand-neon border border-brand-neon/20 shadow-lg shadow-brand-neon/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-xl font-black  uppercase text-white leading-tight">Upload Bukti</h3>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Kirim bukti transfer agar
                                pesanan segera diproses</p>
                        </div>
                    </div>

                    <form action="{{ route('checkout.proof', $transaction->order_id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6" x-on:submit="isLoading = true">
                        @csrf
                        @if($errors->any())
                            <div
                                class="bg-red-500/10 border border-red-500/20 text-red-500 px-6 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="relative group">
                            <input type="file" name="proof_of_payment" id="proof_of_payment" accept="image/*" class="hidden"
                                @change="handleFileChange" required>
                            <label for="proof_of_payment"
                                class="flex flex-col items-center justify-center w-full aspect-video rounded-[2rem] border-2 border-dashed border-white/10 bg-white/[0.02] hover:bg-white/[0.04] hover:border-brand-neon/30 transition-all cursor-pointer group relative overflow-hidden">
                                <div x-show="imagePreview"
                                    class="absolute inset-0 w-full h-full bg-[#050505] flex items-center justify-center"
                                    x-cloak>
                                    <div x-show="imageLoading" class="flex flex-col items-center gap-3">
                                        <svg class="animate-spin h-8 w-8 text-brand-neon" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>
                                    <img :src="imagePreview" class="w-full h-full object-contain" @load="imageLoading = false">
                                    <div
                                        class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-white">Ganti
                                            Gambar</span>
                                    </div>
                                </div>
                                <div x-show="!imagePreview" class="flex flex-col items-center text-center px-10 space-y-4">
                                    <div
                                        class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center text-gray-600 group-hover:text-brand-neon transition-all">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Klik untuk upload
                                        bukti</p>
                                </div>
                            </label>
                        </div>

                        <button type="submit"
                            class="btn-metal relative w-full py-5 rounded-2xl font-black uppercase tracking-[0.3em] text-[11px] group disabled:opacity-50 shadow-2xl shadow-brand-neon/20 overflow-hidden"
                            :disabled="!imagePreview || isLoading">
                            <div class="flex items-center justify-center gap-3 transition-all"
                                :class="isLoading ? 'opacity-0' : 'opacity-100'">
                                <span>Konfirmasi Pembayaran</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center gap-3 transition-all opacity-0"
                                :class="isLoading ? 'opacity-100' : 'opacity-0'">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span>Memproses...</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        @elseif($transaction->payment_status === 'verif' && $transaction->proof_of_payment)
            <div class="bg-brand-neon/10 border-2 border-brand-neon/30 p-8 rounded-3xl text-center space-y-4 shadow-2xl">
                <div class="flex justify-center">
                    <div
                        class="w-16 h-16 bg-brand-neon text-white rounded-full flex items-center justify-center animate-bounce shadow-xl shadow-brand-neon/40">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xl font-black  uppercase text-white">Bukti Terkirim!</h4>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Tunggu sekitar 3-5 menit untuk
                        verifikasi otomatis.</p>
                </div>
                <a href="{{ route('index') }}"
                    class="inline-block text-[10px] font-black text-brand-neon uppercase tracking-[0.3em] mt-4 hover:text-white transition-colors">Kembali
                    ke Beranda</a>
            </div>
        @endif

        <!-- Footer Actions -->
        <div class="flex flex-col items-center gap-4 pt-4">
            <p class="text-[10px] text-gray-600 font-bold uppercase tracking-widest ">* Simpan halaman ini atau catat
                ID Transaksi Anda</p>
            <div class="flex gap-6">
                <a href="{{ route('index') }}"
                    class="text-[10px] font-black text-gray-500 hover:text-white transition-colors uppercase tracking-[0.2em]">Beranda</a>
                <span class="text-gray-800">|</span>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $webSettings['contact_wa'] ?? '') }}" target="_blank"
                    class="text-[10px] font-black text-gray-500 hover:text-white transition-colors uppercase tracking-[0.2em]">Bantuan
                    CS</a>
            </div>
        </div>
    </div>
@endsection