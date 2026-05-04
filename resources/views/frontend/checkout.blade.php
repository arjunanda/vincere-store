@extends('layouts.frontend')

@section('title', 'Checkout - ' . ($game->name ?? 'Ventuz Store'))

@section('body_attr')
    x-data="{
    imagePreview: null,
    isLoading: false,
    handleFileChange(event) {
    const file = event.target.files[0];
    if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
    this.imagePreview = e.target.result;
    };
    reader.readAsDataURL(file);
    }
    }
    }"
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderId = "{{ $transaction->order_id }}";
        const initialStatus = "{{ $transaction->delivery_status }}";
        const initialPaymentStatus = "{{ $transaction->payment_status }}";

        // Only listen if status is NOT final
        if (['success', 'completed', 'failed'].includes(initialStatus) || initialPaymentStatus === 'paid') {
            return;
        }

        // Listen via Laravel Echo (Reverb)
        if (window.Echo) {
            window.Echo.channel(`order.${orderId}`)
                .listen('OrderStatusUpdated', (e) => {
                    console.log('Order update received:', e);
                    // Status changed, reload the page to show stamps and details
                    if (['success', 'completed', 'failed'].includes(e.delivery_status) || e.payment_status === 'paid') {
                        window.location.reload();
                    }
                });
        }
    });
</script>
@endpush

@section('main_class', 'pt-12 md:pt-24 pb-20 px-4 md:px-6 max-w-3xl mx-auto')

@section('content')
    <div class="flex flex-col gap-6 md:gap-10 items-start">
        <!-- Left: Payment Process -->
        <div class="w-full flex flex-col gap-6 md:gap-8 order-1">
            <!-- Header Status -->
            <div class="metal-card rounded-xl overflow-hidden border-brand-red/10 shadow-2xl relative order-1">
                <div class="bg-[#0a0a0a] p-6 md:p-8 space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-2 text-center md:text-left">
                            <h1
                                class="text-2xl md:text-4xl font-black italic uppercase tracking-tight metallic-text leading-tight pr-4">
                                Status <span class="text-brand-red">Pembayaran</span>
                            </h1>
                            <div class="flex items-center justify-center md:justify-start gap-2 group cursor-pointer hover:opacity-80 transition-all"
                                onclick="navigator.clipboard.writeText('{{ $transaction->order_id }}'); alert('ID Transaksi berhasil disalin!')">
                                <p class="text-[9px] md:text-[11px] text-gray-400 font-bold uppercase tracking-[0.3em]">
                                    Transaction ID: #{{ $transaction->order_id }}
                                </p>
                                <div
                                    class="p-1.5 bg-white/5 text-gray-500 group-hover:text-white rounded-md transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center md:justify-end">
                            @if($transaction->payment_status === 'pending')
                                <div class="flex flex-col items-center md:items-end gap-2">
                                    <span
                                        class="status-pill bg-amber-500/10 text-amber-500 border-amber-500/20 text-[10px] md:text-xs">Menunggu
                                        Pembayaran</span>
                                    <p class="text-[8px] text-gray-400 font-bold uppercase tracking-widest animate-pulse">
                                        Menunggu Konfirmasi...</p>
                                </div>
                            @elseif($transaction->payment_status === 'verif')
                                <span
                                    class="status-pill bg-brand-red/10 text-brand-red border-brand-red/20 text-[10px] md:text-xs">Sedang
                                    Diverifikasi</span>
                            @elseif($transaction->payment_status === 'paid')
                                <span
                                    class="status-pill bg-emerald-500/10 text-emerald-500 border-emerald-500/20 text-[10px] md:text-xs">Berhasil</span>
                            @else
                                <span
                                    class="status-pill bg-red-500/10 text-red-500 border-red-500/20 text-[10px] md:text-xs">Gagal</span>
                            @endif
                        </div>
                    </div>

                    @if($transaction->payment_status === 'pending')
                        <div class="pt-6 border-t border-white/5">
                            <div class="bg-white/[0.02] border border-white/5 rounded-xl p-4 flex items-start gap-4">
                                <div
                                    class="w-8 h-8 bg-amber-500/10 rounded-full flex items-center justify-center text-amber-500 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-[10px] md:text-xs text-gray-400 font-medium leading-relaxed">
                                    Silakan transfer sesuai nominal yang tertera pada <span
                                        class="text-white font-bold italic">Rincian Pesanan</span> di bawah, kemudian
                                    <span class="text-brand-red font-bold">Upload Bukti Transfer</span> agar pesanan
                                    Anda segera diproses otomatis.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Step 1: Payment Instructions -->
            @if($transaction->payment_status === 'pending' || $transaction->payment_status === 'verif')
                <div class="metal-card rounded-xl overflow-hidden border-white/5 shadow-2xl order-2">
                    <div class="bg-[#0a0a0a] p-6 md:p-10 space-y-8">
                        <div class="flex items-center justify-between gap-4 border-b border-white/5 pb-8">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 md:w-16 md:h-16 bg-brand-red/10 rounded-xl border border-brand-red/20 flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $paymentMethod->image) }}"
                                        class="w-full h-full object-contain rounded-xl" alt="{{ $paymentMethod->name }}">
                                </div>
                                <div>
                                    <p class="text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                        Metode Pembayaran</p>
                                    <h2 class="text-xl md:text-2xl font-black italic uppercase text-white leading-tight">
                                        {{ $paymentMethod->name }}
                                    </h2>
                                </div>
                            </div>
                            <div class="hidden md:block text-right">
                                <p class="text-[10px] font-black text-brand-red uppercase tracking-widest italic">
                                    Langkah 1</p>
                                <p class="text-xs font-black text-white uppercase italic">Selesaikan Pembayaran</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div class="space-y-3">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nominal
                                        Transfer</p>
                                    <div
                                        class="bg-white/[0.03] border border-white/10 rounded-2xl p-5 flex items-center justify-between group hover:border-brand-red/30 transition-all shadow-inner">
                                        <h3 class="text-2xl md:text-3xl font-black italic text-white leading-none">
                                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                        </h3>
                                        <button
                                            onclick="navigator.clipboard.writeText('{{ $transaction->total_price }}'); alert('Total bayar berhasil disalin!')"
                                            class="p-2 bg-brand-red/10 text-brand-red rounded-lg hover:bg-brand-red hover:text-white transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                @if($paymentMethod->type === 'qris')
                                    <div class="space-y-3 text-center md:text-left">
                                        <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Scan QRIS
                                        </p>
                                        <div class="bg-white p-4 rounded-2xl shadow-2xl mx-auto md:mx-0 w-fit">
                                            <img src="{{ asset('storage/' . $paymentMethod->qris_image) }}"
                                                class="w-48 md:w-64 h-auto" alt="QRIS">
                                        </div>
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        <div class="space-y-3">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nomor
                                                Rekening</p>
                                            <div
                                                class="bg-white/[0.03] border border-white/10 rounded-2xl p-5 flex items-center justify-between group hover:border-brand-red/30 transition-all shadow-inner relative overflow-hidden">
                                                <div class="space-y-1">
                                                    <p
                                                        class="text-[8px] font-black text-gray-400 uppercase tracking-widest leading-none">
                                                        Nomor Rekening</p>
                                                    <h3
                                                        class="text-xl md:text-2xl font-black italic text-white leading-none tracking-tight py-1">
                                                        {{ $paymentMethod->account_number }}
                                                    </h3>
                                                    <div class="flex items-center gap-2 pt-1">
                                                        <span class="w-1 h-3 bg-brand-red rounded-full"></span>
                                                        <p
                                                            class="text-[10px] text-gray-400 font-black uppercase tracking-wider leading-none">
                                                            A/N {{ $paymentMethod->account_name }}</p>
                                                    </div>
                                                </div>
                                                <button
                                                    onclick="navigator.clipboard.writeText('{{ $paymentMethod->account_number }}'); alert('Nomor rekening berhasil disalin!')"
                                                    class="p-2 bg-brand-red/10 text-brand-red rounded-lg hover:bg-brand-red hover:text-white transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="bg-white/[0.02] border border-white/5 rounded-2xl p-6 md:p-8 space-y-6">
                                <h4 class="text-[10px] font-black text-white uppercase tracking-widest flex items-center gap-2">
                                    <svg class="w-4 h-4 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Panduan Pembayaran
                                </h4>
                                <ul class="space-y-4">
                                    <li class="flex items-start gap-3 text-[11px] text-gray-300 font-medium leading-relaxed">
                                        <div
                                            class="w-5 h-5 bg-white/5 rounded-full flex items-center justify-center text-[10px] font-black text-gray-400 flex-shrink-0 mt-0.5">
                                            1</div>
                                        <span>Transfer nominal <span
                                                class="text-white font-black underline decoration-brand-red decoration-2">PERSIS</span>
                                            hingga digit terakhir.</span>
                                    </li>
                                    <li class="flex items-start gap-3 text-[11px] text-gray-300 font-medium leading-relaxed">
                                        <div
                                            class="w-5 h-5 bg-white/5 rounded-full flex items-center justify-center text-[10px] font-black text-gray-400 flex-shrink-0 mt-0.5">
                                            2</div>
                                        <span>Pastikan <span class="text-white font-bold">Nama Penerima</span> dan <span
                                                class="text-white font-bold">Nomor Rekening</span> sudah sesuai.</span>
                                    </li>
                                    <li class="flex items-start gap-3 text-[11px] text-gray-300 font-medium leading-relaxed">
                                        <div
                                            class="w-5 h-5 bg-white/5 rounded-full flex items-center justify-center text-[10px] font-black text-gray-400 flex-shrink-0 mt-0.5">
                                            3</div>
                                        <span>Simpan bukti transfer dan upload di bagian bawah.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Step 2: Proof Upload -->
            @if($transaction->payment_status === 'pending' || ($transaction->payment_status === 'verif' && !$transaction->proof_of_payment))
                <div class="metal-card rounded-xl overflow-hidden border-brand-red/10 shadow-2xl order-3">
                    <div class="bg-[#0a0a0a] p-6 md:p-10 space-y-8">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 md:w-14 md:h-14 bg-brand-red/10 rounded-xl flex items-center justify-center text-brand-red shadow-lg shadow-brand-red/10 border border-brand-red/20">
                                    <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="text-xl md:text-2xl font-black italic uppercase text-white leading-tight">
                                        Bukti Transfer</h3>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em]">Konfirmasi
                                        Agar Pesanan Segera Diproses</p>
                                </div>
                            </div>
                            <div class="hidden md:block text-right">
                                <p class="text-[10px] font-black text-brand-red uppercase tracking-widest italic">
                                    Langkah 2</p>
                                <p class="text-xs font-black text-white uppercase italic">Upload & Selesai</p>
                            </div>
                        </div>

                        <form action="{{ route('checkout.proof', $transaction->order_id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-8" x-on:submit="isLoading = true">
                            @csrf

                            @if($errors->any())
                                <div
                                    class="bg-red-500/10 border border-red-500/20 text-red-500 px-6 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest animate-shake">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div class="relative group">
                                <input type="file" name="proof_of_payment" id="proof_of_payment" accept="image/*" class="hidden"
                                    @change="handleFileChange" required>

                                <label for="proof_of_payment"
                                    class="flex flex-col items-center justify-center w-full aspect-[4/3] md:aspect-video rounded-[2rem] border-2 border-dashed border-white/10 bg-white/[0.02] hover:bg-white/[0.04] hover:border-brand-red/30 transition-all cursor-pointer group relative overflow-hidden">

                                    <template x-if="imagePreview">
                                        <div class="absolute inset-0 w-full h-full bg-black">
                                            <img :src="imagePreview" class="w-full h-full object-contain">
                                            <div
                                                class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <span class="text-xs font-black uppercase tracking-[0.2em] text-white">Ganti
                                                    Gambar</span>
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="!imagePreview">
                                        <div class="flex flex-col items-center text-center px-10 space-y-6">
                                            <div
                                                class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center text-gray-600 group-hover:text-brand-red group-hover:scale-110 transition-all">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Klik
                                                untuk upload bukti</p>
                                        </div>
                                    </template>
                                </label>
                            </div>

                            <button type="submit"
                                class="btn-metal relative w-full py-6 rounded-2xl font-black uppercase tracking-[0.3em] text-sm group disabled:opacity-50 disabled:cursor-wait shadow-2xl shadow-brand-red/30 overflow-hidden"
                                :disabled="!imagePreview || isLoading">
                                
                                <!-- Normal State -->
                                <div class="flex items-center justify-center gap-4 transition-all duration-300" 
                                     :class="isLoading ? 'opacity-0 translate-y-4' : 'opacity-100 translate-y-0'">
                                    <span>Selesaikan Pesanan</span>
                                    <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </div>

                                <!-- Loading State -->
                                <div class="absolute inset-0 flex items-center justify-center gap-3 transition-all duration-300" 
                                     :class="isLoading ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-4'">
                                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="tracking-[0.3em] mt-0.5">Memproses...</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>

        <!-- Right: Order Details -->
        <div class="w-full space-y-6 md:space-y-8 order-2">

            @if(session('success'))
                <div
                    class="bg-emerald-500/10 border border-emerald-500/20 p-5 rounded-xl text-emerald-400 text-[10px] font-black uppercase tracking-widest flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="metal-card rounded-xl md:rounded-xl p-1 overflow-hidden relative shadow-2xl">
                @if(in_array($transaction->payment_status, ['success', 'paid', 'completed']))
                    <div class="stamp stamp-success">SUCCESS</div>
                @elseif($transaction->payment_status === 'failed' || $transaction->delivery_status === 'failed')
                    <div class="stamp stamp-failed">FAILED</div>
                @endif
                <div class="p-6 md:p-8 space-y-6 md:space-y-8">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[10px] md:text-sm font-black uppercase tracking-widest text-gray-400 italic">
                                Rincian Pesanan</h3>
                            <div class="h-[1px] flex-1 mx-4 bg-white/5"></div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-1">
                                <span
                                    class="text-[8px] md:text-[10px] font-bold text-gray-400 uppercase tracking-widest">Produk</span>
                                <span
                                    class="text-[10px] md:text-xs font-black text-white italic uppercase">{{ $game->name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span
                                    class="text-[8px] md:text-[10px] font-bold text-gray-400 uppercase tracking-widest">Variant</span>
                                <span
                                    class="text-[10px] md:text-xs font-black text-brand-red italic uppercase">{{ $variant->name }}</span>
                            </div>

                            <div class="pt-3 border-t border-white/5 space-y-2">
                                @foreach($transaction->input_data as $label => $value)
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-[8px] md:text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $label }}</span>
                                        <span class="text-[10px] md:text-xs font-black text-white uppercase">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-4 border-t border-white/10 flex justify-between items-center">
                                <span
                                    class="text-[10px] md:text-xs font-black text-gray-400 uppercase tracking-[0.1em]">Total
                                    Bayar</span>
                                <span class="text-xl md:text-2xl font-black italic text-brand-red">Rp
                                    {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-white/5 space-y-4">
                        @if($transaction->payment_status === 'verif')
                            <div
                                class="bg-brand-red/20 border-2 border-brand-red/30 p-6 rounded-xl text-center space-y-3 relative overflow-hidden">
                                <div class="absolute inset-0 bg-brand-red/5 animate-pulse"></div>
                                <div class="relative z-10 space-y-3">
                                    <div class="flex justify-center">
                                        <div
                                            class="w-10 h-10 bg-brand-red text-white rounded-full flex items-center justify-center animate-bounce">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-white font-bold leading-relaxed">
                                        Bukti diterima. <span class="text-brand-red">Tunggu 3 menit</span>. Jika
                                        belum masuk, hubungi CS.
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-2">
                            @php
                                $waCS = preg_replace('/[^0-9]/', '', $webSettings['contact_wa'] ?? '');
                                if (str_starts_with($waCS, '0'))
                                    $waCS = '62' . substr($waCS, 1);
                            @endphp
                            <a href="https://wa.me/{{ $waCS }}?text=Halo%20Admin%20{{ urlencode($webSettings['web_title'] ?? 'Ventuz Store') }},%20saya%20ingin%20menanyakan%20pesanan%20dengan%20ID%20{{ $transaction->order_id }}"
                                target="_blank"
                                class="flex items-center justify-center gap-2 w-full py-4 glass-panel rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] hover:bg-white/5 transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Hubungi Customer Service
                            </a>
                            <a href="{{ route('index') }}"
                                class="block text-center text-[9px] font-bold text-gray-600 hover:text-white transition-colors uppercase tracking-widest pt-2">
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Small Tip -->
        <div class="bg-brand-red/5 border border-brand-red/10 p-4 rounded-xl w-full ">
                    <p class="text-xs text-gray-500 font-medium italic leading-relaxed">
                        * Gunakan Order ID untuk mengecek status pesanan Anda.
                    </p>
                </div>

            </div>
@endsection