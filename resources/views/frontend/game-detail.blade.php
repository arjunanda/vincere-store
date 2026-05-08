@extends('layouts.frontend')

@section('title', $game->name . ' -')

@section('body_attr')
x-data="{ 
    selectedVariant: {{ old('variant_id', 'null') }}, 
    selectedPayment: {{ old('payment_method_id', 'null') }},
    variantPrices: {
        @foreach($game->variants as $v)
            '{{ $v->id }}': {{ $v->price }},
        @endforeach
    },
    variantNames: {
        @foreach($game->variants as $v)
            '{{ $v->id }}': '{{ $v->name }}',
        @endforeach
    },
    paymentFees: {
        @foreach($paymentMethods as $p)
            '{{ $p->id }}': {{ $p->fee ?? 0 }},
        @endforeach
    },
    paymentNames: {
        @foreach($paymentMethods as $p)
            '{{ $p->id }}': '{{ $p->name }}',
        @endforeach
    },
    whatsapp: '{{ old('whatsapp') }}',
    @foreach($game->inputGroup->fields as $field)
        {{ $field->name }}: '{{ old($field->name) }}',
    @endforeach
    isReady() {
        let inputsFilled = true;
        @foreach($game->inputGroup->fields as $field)
            if (!this.{{ $field->name }}) inputsFilled = false;
        @endforeach
        return this.selectedVariant && this.selectedPayment && inputsFilled && (@guest this.whatsapp @else true @endguest);
    },
    init() {
        // Crucial: We need to pull values from the DOM that might have been restored by the browser
        // before Alpine's x-model wiped them, or simply to sync with autofill.
        
        // Use a small delay to ensure the browser has finished restoring values
        setTimeout(() => {
            @foreach($game->inputGroup->fields as $field)
                let el_{{ $field->name }} = document.querySelector('[name={{ $field->name }}]');
                if (el_{{ $field->name }} && el_{{ $field->name }}.value && !this.{{ $field->name }}) {
                    this.{{ $field->name }} = el_{{ $field->name }}.value;
                }
            @endforeach

            let waEl = document.querySelector('[name=whatsapp]');
            if (waEl && waEl.value && !this.whatsapp) {
                this.whatsapp = waEl.value;
            }

            // Also check hidden inputs for variant/payment
            let vEl = document.querySelector('input[name=variant_id]');
            if (vEl && vEl.value && !this.selectedVariant) {
                this.selectedVariant = parseInt(vEl.value);
            }
            let pEl = document.querySelector('input[name=payment_method_id]');
            if (pEl && pEl.value && !this.selectedPayment) {
                this.selectedPayment = parseInt(pEl.value);
            }
        }, 100);
    }
}"
@endsection

@section('main_class', 'pt-12 pb-20 px-6 max-w-7xl mx-auto')

@section('content')
<form action="{{ route('checkout') }}" method="POST">
    @csrf
    <input type="hidden" name="game_id" value="{{ $game->id }}">
    <input type="hidden" name="variant_id" :value="selectedVariant">
    <input type="hidden" name="payment_method_id" :value="selectedPayment">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Game Info & Input -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Game Info -->
            <div class="rounded-xl overflow-hidden shadow-2xl border border-white/[0.07]" style="background:#1a1d27">
                <div class="rounded-xl p-6 space-y-6">
                    <img src="{{ asset('storage/' . $game->image) }}"
                        class="w-full aspect-square object-cover rounded-xl shadow-2xl" alt="{{ $game->name }}">
                    <div>
                        <h1 class="text-3xl font-black  uppercase tracking-tight text-white leading-none">
                            {{ $game->name }}
                        </h1>
                        <p class="text-gray-500 font-medium text-xs mt-2 uppercase tracking-widest">Top-up
                            Instan 24/7</p>
                    </div>
                    <div class="pt-4 border-t border-white/5 space-y-4 text-xs text-gray-400 leading-relaxed">
                        {!! nl2br(e($game->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle: Variants & Payments -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Step 1: Input Data -->
            <div class="rounded-xl overflow-hidden border border-white/[0.07]" style="background:#1a1d27">
                <div class="rounded-xl p-5 md:p-8 space-y-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="step-number w-8 h-8 rounded-full flex items-center justify-center text-xs font-black bg-brand-neon/10 border border-brand-neon/40 text-brand-neon">
                            1</div>
                        <h2 class="text-lg font-black uppercase tracking-widest ">Input Data <span
                                class="text-brand-neon">Akun</span></h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($game->inputGroup->fields as $field)
                            <div
                                class="space-y-3 {{ count($game->inputGroup->fields) == 1 && !auth()->check() ? '' : (count($game->inputGroup->fields) == 1 ? 'md:col-span-2' : '') }}">
                                <label
                                    class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">{{ $field->label }}</label>
                                @if($field->type === 'select')
                                    <select name="{{ $field->name }}" x-model="{{ $field->name }}"
                                        x-init="$nextTick(() => { if ($el.value) {{ $field->name }} = $el.value })"
                                        class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-4 px-6 focus:outline-none focus:border-brand-neon/50 text-white text-sm appearance-none transition-all">
                                        <option value="" class="bg-black">Pilih...</option>
                                    </select>
                                @else
                                    <input type="{{ $field->type }}" name="{{ $field->name }}"
                                        x-model="{{ $field->name }}" 
                                        x-init="$nextTick(() => { if ($el.value) {{ $field->name }} = $el.value })"
                                        placeholder="{{ $field->placeholder }}"
                                        @if($field->max_length) maxlength="{{ $field->max_length }}" @endif
                                        @if($field->type === 'number') @wheel="$el.blur()" @endif
                                        class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-4 px-6 focus:outline-none focus:border-brand-neon/50 text-white text-sm font-bold placeholder:text-gray-700 transition-all">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Step 2: Select Items -->
            <div class="rounded-xl overflow-hidden border border-white/[0.07]" style="background:#1a1d27">
                <div class="rounded-xl p-5 md:p-8 space-y-8">
                    <div class="flex items-center gap-4">
                        <div
                            class="step-number w-8 h-8 rounded-full flex items-center justify-center text-xs font-black bg-brand-neon/10 border border-brand-neon/40 text-brand-neon">
                            2</div>
                        <h2 class="text-lg font-black uppercase tracking-widest ">Pilih <span
                                class="text-brand-neon">Nominal</span></h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($game->variants as $variant)
                            <button type="button" @click="selectedVariant = {{ $variant->id }}"
                                :class="selectedVariant === {{ $variant->id }}
                                    ? 'border-brand-neon bg-brand-neon/[0.07]'
                                    : 'border-white/[0.06] hover:border-white/20 hover:bg-white/[0.03]'"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-all duration-200 active:scale-[0.98] text-left w-full"
                                style="background: rgba(255,255,255,0.02)">

                                <!-- Check circle -->
                                <div class="flex-shrink-0 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all duration-200"
                                    :class="selectedVariant === {{ $variant->id }}
                                        ? 'border-brand-neon bg-brand-neon'
                                        : 'border-white/20'">
                                    <svg x-show="selectedVariant === {{ $variant->id }}" x-cloak class="w-3 h-3 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>

                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-[13px] font-bold truncate transition-colors"
                                        :class="selectedVariant === {{ $variant->id }} ? 'text-white' : 'text-gray-300'">
                                        {{ $variant->name }}
                                    </p>
                                </div>

                                <!-- Price -->
                                <p class="flex-shrink-0 text-[13px] font-black tabular-nums transition-colors"
                                    :class="selectedVariant === {{ $variant->id }} ? 'text-brand-neon' : 'text-white/70'">
                                    Rp {{ number_format($variant->price, 0, ',', '.') }}
                                </p>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Step 3: Select Payment -->
            <div class="rounded-xl overflow-hidden border border-white/[0.07]" style="background:#1a1d27">
                <div class="rounded-xl p-5 md:p-8 space-y-8">
                    <div class="flex items-center gap-4">
                        <div
                            class="step-number w-8 h-8 rounded-full flex items-center justify-center text-xs font-black bg-brand-neon/10 border border-brand-neon/40 text-brand-neon">
                            3</div>
                        <h2 class="text-lg font-black uppercase tracking-widest ">Metode <span
                                class="text-brand-neon">Pembayaran</span></h2>
                    </div>

                    <div class="flex flex-col gap-2">
                        @foreach($paymentMethods as $payment)
                            <button type="button" @click="selectedPayment = {{ $payment->id }}"
                                :class="selectedPayment === {{ $payment->id }}
                                    ? 'border-brand-neon bg-brand-neon/[0.06]'
                                    : 'border-white/[0.06] hover:border-white/20 hover:bg-white/[0.02]'"
                                class="flex items-center gap-4 px-4 py-3 rounded-xl border transition-all duration-200 active:scale-[0.99] w-full"
                                style="background: rgba(255,255,255,0.02)">

                                <!-- Logo -->
                                <div class="w-10 h-10 rounded-lg overflow-hidden border border-white/[0.07] bg-white/[0.04] flex items-center justify-center flex-shrink-0">
                                    <img src="{{ asset('storage/' . $payment->image) }}"
                                        class="w-full h-full object-contain transition-all"
                                        :class="selectedPayment === {{ $payment->id }} ? 'grayscale-0' : 'grayscale'"
                                        alt="{{ $payment->name }}">
                                </div>

                                <!-- Name & Label -->
                                <div class="flex-1 text-left min-w-0">
                                    <p class="text-[13px] font-bold transition-colors truncate"
                                        :class="selectedPayment === {{ $payment->id }} ? 'text-white' : 'text-gray-400'">
                                        {{ $payment->name }}
                                    </p>
                                    <p class="text-[11px] text-gray-600 font-medium">Otomatis · Instan</p>
                                </div>

                                <!-- Total price when variant selected -->
                                <div class="text-right flex-shrink-0" x-show="selectedVariant" x-cloak>
                                    <p class="text-[11px] text-gray-500 font-medium">Total</p>
                                    <p class="text-[13px] font-black tabular-nums"
                                        :class="selectedPayment === {{ $payment->id }} ? 'text-brand-neon' : 'text-white/70'">
                                        Rp <span x-text="new Intl.NumberFormat('id-ID').format(variantPrices[selectedVariant] + paymentFees[{{ $payment->id }}])"></span>
                                    </p>
                                </div>

                                <!-- Check indicator -->
                                <div class="flex-shrink-0 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all duration-200"
                                    :class="selectedPayment === {{ $payment->id }}
                                        ? 'border-brand-neon bg-brand-neon'
                                        : 'border-white/20'">
                                    <svg x-show="selectedPayment === {{ $payment->id }}" x-cloak class="w-3 h-3 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            @guest
                <!-- Step 4: WhatsApp (Guest Only) -->
                <div class="rounded-xl overflow-hidden border border-white/[0.07]" style="background:#1a1d27">
                    <div class="rounded-xl p-5 md:p-8 space-y-8">
                        <div class="flex items-center gap-4">
                            <div
                                class="step-number w-8 h-8 rounded-full flex items-center justify-center text-xs font-black bg-brand-neon/10 border border-brand-neon/40 text-brand-neon">
                                4</div>
                            <h2 class="text-lg font-black uppercase tracking-widest ">Informasi <span
                                    class="text-brand-neon">Kontak</span></h2>
                        </div>

                        <div class="space-y-4">
                            <p class="text-xs text-gray-500 leading-relaxed">Masukkan nomor WhatsApp Anda untuk
                                menerima notifikasi status pesanan secara otomatis.</p>
                            <div class="space-y-3">
                                <label
                                    class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Nomor
                                    WhatsApp</label>
                                <div class="relative group">
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-brand-neon">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                        </svg>
                                    </div>
                                    <input type="tel" name="whatsapp" x-model="whatsapp"
                                        x-init="$nextTick(() => { if ($el.value) whatsapp = $el.value })"
                                        placeholder="Contoh: 08123456789"
                                        class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-4 pl-14 pr-6 focus:outline-none focus:border-brand-neon/50 text-white text-sm font-bold placeholder:text-gray-700 transition-all">
                                </div>
                                <p class="text-[9px] text-gray-600 font-bold uppercase tracking-widest ml-1">*
                                    Notifikasi akan dikirim ke nomor ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endguest

            <!-- Step {{ auth()->check() ? '4' : '5' }}: Checkout -->
            <div class="rounded-xl overflow-hidden shadow-2xl border border-white/[0.07]" style="background:#1a1d27">
                <div class="rounded-xl p-5 md:p-8 space-y-6 md:space-y-8">
                    <div class="flex items-center gap-4">
                        <div
                            class="step-number w-8 h-8 rounded-full flex items-center justify-center text-xs font-black bg-brand-neon/10 border border-brand-neon/40 text-brand-neon">
                            {{ auth()->check() ? '4' : '5' }}
                        </div>
                        <h2 class="text-lg font-black uppercase tracking-widest ">Konfirmasi <span
                                class="text-brand-neon">Pesanan</span></h2>
                    </div>

                    <div
                        class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-center bg-white/[0.02] border border-white/5 rounded-xl p-5 md:p-8">
                        <div class="md:col-span-7 space-y-5 md:space-y-6">
                            <div class="flex flex-col gap-1">
                                <p
                                    class="text-[9px] md:text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">
                                    Ringkasan Pesanan</p>
                                <h3
                                    class="text-xl md:text-2xl font-black  uppercase tracking-tight text-white leading-none">
                                    {{ $game->name }}</h3>
                            </div>
                            <div x-show="selectedVariant && selectedPayment" x-transition class="space-y-4">
                                <div class="grid grid-cols-1 gap-4 border-t border-white/5 pt-4">
                                    <div
                                        class="flex justify-between items-center bg-white/5 p-3 rounded-lg border border-white/5">
                                        <div class="space-y-1">
                                            <p
                                                class="text-[8px] font-bold text-gray-500 uppercase tracking-widest">
                                                Item Terpilih</p>
                                            <p class="text-[11px] font-black text-brand-neon uppercase  leading-tight"
                                                x-text="variantNames[selectedVariant]"></p>
                                        </div>
                                        <div class="text-right space-y-1">
                                            <p
                                                class="text-[8px] font-bold text-gray-500 uppercase tracking-widest">
                                                Metode Bayar</p>
                                            <p class="text-[11px] font-black text-white uppercase  leading-tight"
                                                x-text="paymentNames[selectedPayment]"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div x-show="!selectedVariant || !selectedPayment"
                                class="text-gray-600  text-xs font-medium py-4">
                                Silakan lengkapi pilihan Anda di atas...
                            </div>
                        </div>

                        <div class="md:col-span-5 flex flex-col gap-4">
                            <div class="bg-white/[0.03] border border-white/5 rounded-xl p-5 space-y-3">
                                <div
                                    class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                    <span>Harga</span>
                                    <span class="text-white">Rp <span
                                            x-text="selectedVariant ? new Intl.NumberFormat('id-ID').format(variantPrices[selectedVariant]) : '0'"></span></span>
                                </div>
                                <div
                                    class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                    <span>Biaya Admin</span>
                                    <span class="text-white">Rp <span
                                            x-text="selectedPayment ? new Intl.NumberFormat('id-ID').format(paymentFees[selectedPayment]) : '0'"></span></span>
                                </div>
                                <div
                                    class="pt-3 mt-1 border-t border-white/10 flex flex-row justify-between items-center gap-2">
                                    <p class="text-[9px] font-black uppercase tracking-widest text-brand-neon shrink-0">
                                        Total Bayar</p>
                                    <h4 class="text-[14px] md:text-2xl font-black  text-white leading-none whitespace-nowrap tracking-tighter">
                                        Rp <span
                                            x-text="selectedVariant && selectedPayment ? new Intl.NumberFormat('id-ID').format(variantPrices[selectedVariant] + paymentFees[selectedPayment]) : '0'"></span>
                                    </h4>
                                </div>
                            </div>

                            <button type="submit"
                                class="btn-metal w-full py-4 md:py-5 rounded-xl font-black uppercase tracking-widest md:tracking-[0.2em] text-[11px] md:text-sm flex items-center justify-center gap-4 group disabled:opacity-30 disabled:cursor-not-allowed shadow-xl shadow-brand-neon/20"
                                :disabled="!isReady()">
                                Beli Sekarang
                                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection