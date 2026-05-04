@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('dashboard.payments') }}"
                    class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-brand-red flex items-center gap-2 mb-2 transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-black italic uppercase tracking-tight">Edit <span
                        class="text-brand-red">Metode</span></h1>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">{{ $payment->name }}</p>
            </div>
        </div>

        <form action="{{ route('dashboard.payments.update', $payment) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6" x-data="{ 
                paymentType: '{{ $payment->type }}',
                logoPreview: null,
                qrisPreview: null,
                handleFile(event, type) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => { 
                            if (type === 'logo') this.logoPreview = e.target.result;
                            if (type === 'qris') this.qrisPreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }">
            @csrf
            @method('PUT')

            <div class="stat-card">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tipe & Nama -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Tipe Metode <span
                                class="text-brand-red">*</span></label>
                        <select name="type" x-model="paymentType"
                            class="w-full input-metal py-3 px-4 rounded-xl text-xs appearance-none" required>
                            <option value="bank" {{ $payment->type == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="ewallet" {{ (old('type', $payment->type) == 'ewallet') ? 'selected' : '' }}>E-Wallet</option>
                            <option value="qris" {{ $payment->type == 'qris' ? 'selected' : '' }}>QRIS</option>
                        </select>
                        @error('type') <p class="text-brand-red text-[10px] italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Nama Provider <span
                                class="text-brand-red">*</span></label>
                        <input type="text" name="name" value="{{ $payment->name }}"
                            class="w-full input-metal py-3 px-4 rounded-xl text-xs" required>
                        @error('name') <p class="text-brand-red text-[10px] italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Kode Unik <span
                                class="text-brand-red">*</span></label>
                        <input type="text" name="code" value="{{ $payment->code }}"
                            class="w-full input-metal py-3 px-4 rounded-xl text-xs" required>
                        @error('code') <p class="text-brand-red text-[10px] italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Biaya Layanan (Fee)
                            <span class="text-brand-red">*</span></label>
                        <input type="number" name="fee" value="{{ $payment->fee }}"
                            class="w-full input-metal py-3 px-4 rounded-xl text-xs" required>
                        @error('fee') <p class="text-brand-red text-[10px] italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Nomor Rekening /
                            HP</label>
                        <input type="text" name="account_number" value="{{ $payment->account_number }}"
                            class="w-full input-metal py-3 px-4 rounded-xl text-xs">
                        @error('account_number') <p class="text-brand-red text-[10px] italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Atas Nama</label>
                        <input type="text" name="account_name" value="{{ $payment->account_name }}"
                            class="w-full input-metal py-3 px-4 rounded-xl text-xs">
                        @error('account_name') <p class="text-brand-red text-[10px] italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Edit Logo -->
                <div class="stat-card space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 block">Logo Metode</label>
                    <div
                        class="flex flex-col items-center gap-4 p-6 bg-white/[0.02] rounded-2xl border border-dashed border-white/10 group hover:border-brand-red/50 transition-all">
                        <div
                            class="w-20 h-20 rounded-xl bg-white/5 flex items-center justify-center overflow-hidden border border-white/10">
                            <template x-if="logoPreview">
                                <img :src="logoPreview" class="w-full h-full object-contain">
                            </template>
                            <template x-if="!logoPreview">
                                @if($payment->image)
                                    <img src="{{ asset('storage/' . $payment->image) }}" class="w-full h-full object-contain">
                                @else
                                    <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z" />
                                    </svg>
                                @endif
                            </template>
                        </div>
                        <label class="cursor-pointer">
                            <span class="btn-upload">Ubah Logo</span>
                            <input type="file" name="image" @change="handleFile($event, 'logo')" class="hidden"
                                accept="image/*">
                        </label>
                    </div>
                    @error('image') <p class="text-brand-red text-[10px] italic mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Edit QRIS -->
                <div class="stat-card space-y-4 border-brand-red/10" x-show="paymentType === 'qris'" x-cloak x-transition>
                    <label class="text-[10px] font-black uppercase tracking-widest text-brand-red block">Gambar QRIS</label>
                    <div
                        class="flex flex-col items-center gap-4 p-6 bg-white/[0.02] rounded-2xl border border-dashed border-white/10 group hover:border-brand-red/50 transition-all">
                        <div
                            class="w-20 h-20 rounded-xl bg-white/5 flex items-center justify-center overflow-hidden border border-white/10">
                            <template x-if="qrisPreview">
                                <img :src="qrisPreview" class="w-full h-full object-contain">
                            </template>
                            <template x-if="!qrisPreview">
                                @if($payment->qris_image)
                                    <img src="{{ asset('storage/' . $payment->qris_image) }}"
                                        class="w-full h-full object-contain">
                                @else
                                    <svg class="w-8 h-8 text-brand-red/20" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M5 8V2.1m12.9 15.9l1.4 1.4M5 4.1L4.1 5m15.9 2.1l1.4 1.4M4.9 19.9l1.4 1.4" />
                                    </svg>
                                @endif
                            </template>
                        </div>
                        <label class="cursor-pointer">
                            <span class="btn-upload">Ubah Gambar QRIS</span>
                            <input type="file" name="qris_image" @change="handleFile($event, 'qris')" class="hidden"
                                accept="image/*">
                        </label>
                    </div>
                    @error('qris_image') <p class="text-brand-red text-[10px] italic mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-metal py-4 px-12 rounded-xl font-black uppercase tracking-widest text-xs">
                    Perbarui Metode Pembayaran
                </button>
            </div>
        </form>
    </div>
@endsection