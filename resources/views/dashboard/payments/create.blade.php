@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('dashboard.payments') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-brand-neon flex items-center gap-2 mb-2 transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
            <h1 class="text-2xl font-black  uppercase tracking-tight">Tambah <span class="text-brand-neon">Metode</span></h1>
        </div>
    </div>

    <form action="{{ route('dashboard.payments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" novalidate
        x-data="{ 
            paymentType: 'bank',
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
        
        <div class="stat-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tipe & Nama -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Tipe Metode <span class="text-brand-neon">*</span></label>
                    <select name="type" x-model="paymentType" class="w-full input-metal py-3 px-4 rounded-xl text-xs appearance-none" required>
                        <option value="bank">Bank Transfer</option>
                        <option value="ewallet">E-Wallet</option>
                        <option value="qris">QRIS</option>
                    </select>
                    @error('type') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Nama Provider (BCA, OVO, dll) <span class="text-brand-neon">*</span></label>
                    <input type="text" name="name" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="Contoh: BCA, BNI, BRI, dll" required>
                    @error('name') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Biaya Layanan (Fee) <span class="text-brand-neon">*</span></label>
                    <input type="number" name="fee" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="0" required>
                    @error('fee') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Info Rekening -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Nomor Rekening / HP</label>
                    <input type="text" name="account_number" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="0000000000">
                    @error('account_number') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Atas Nama</label>
                    <input type="text" name="account_name" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="PT. Vincere Media">
                    @error('account_name') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2" x-show="paymentType === 'bank'" x-cloak x-transition>
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Nama Bank Resmi</label>
                    <input type="text" name="bank_name" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="Bank Central Asia">
                    @error('bank_name') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Upload Logo -->
            <div class="stat-card space-y-4">
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 block">Logo Metode <span class="text-brand-neon">*</span></label>
                <div class="flex flex-col items-center gap-4 p-6 bg-white/[0.02] rounded-2xl border border-dashed border-white/10 group hover:border-brand-neon/50 transition-all">
                    <div class="w-20 h-20 rounded-xl bg-white/5 flex items-center justify-center overflow-hidden border border-white/10">
                        <template x-if="logoPreview">
                            <img :src="logoPreview" class="w-full h-full object-contain">
                        </template>
                        <template x-if="!logoPreview">
                            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                        </template>
                    </div>
                    <label class="cursor-pointer">
                        <span class="btn-upload">Pilih Logo</span>
                        <input type="file" name="image" @change="handleFile($event, 'logo')" class="hidden" accept="image/*" required>
                    </label>
                </div>
                @error('image') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Upload QRIS -->
            <div class="stat-card space-y-4 border-brand-neon/10" x-show="paymentType === 'qris'" x-cloak x-transition>
                <label class="text-[10px] font-black uppercase tracking-widest text-brand-neon block">Gambar QRIS (Wajib jika QRIS)</label>
                <div class="flex flex-col items-center gap-4 p-6 bg-white/[0.02] rounded-2xl border border-dashed border-white/10 group hover:border-brand-neon/50 transition-all">
                    <div class="w-20 h-20 rounded-xl bg-white/5 flex items-center justify-center overflow-hidden border border-white/10">
                        <template x-if="qrisPreview">
                            <img :src="qrisPreview" class="w-full h-full object-contain">
                        </template>
                        <template x-if="!qrisPreview">
                            <svg class="w-8 h-8 text-brand-neon/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M5 8V2.1m12.9 15.9l1.4 1.4M5 4.1L4.1 5m15.9 2.1l1.4 1.4M4.9 19.9l1.4 1.4" /></svg>
                        </template>
                    </div>
                    <label class="cursor-pointer">
                        <span class="btn-upload">Pilih Gambar QRIS</span>
                        <input type="file" name="qris_image" @change="handleFile($event, 'qris')" class="hidden" accept="image/*">
                    </label>
                </div>
                @error('qris_image') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-metal py-4 px-12 rounded-xl font-black uppercase tracking-widest text-xs">
                Simpan Metode Pembayaran
            </button>
        </div>
    </form>
</div>
@endsection
