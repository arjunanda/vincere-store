@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl space-y-8" x-data="{ 
    faviconPreview: '{{ isset($webSettings['web_favicon']) ? asset('storage/' . $webSettings['web_favicon']) : '' }}',
    logoPreview: '{{ isset($webSettings['web_logo']) ? asset('storage/' . $webSettings['web_logo']) : '' }}',
    ogPreview: '{{ isset($webSettings['web_og_image']) ? asset('storage/' . $webSettings['web_og_image']) : '' }}',
    handleFile(event, type) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                if (type === 'favicon') this.faviconPreview = e.target.result;
                if (type === 'logo') this.logoPreview = e.target.result;
                if (type === 'og') this.ogPreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}">
    <div>
        <h1 class="text-3xl font-black italic uppercase tracking-tight text-white">Pengaturan <span class="text-brand-red">Website</span></h1>
        <p class="text-gray-500 font-medium mt-1">Konfigurasi identitas, SEO, dan kontak official website Anda.</p>
    </div>

    <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Identity & SEO -->
            <div class="lg:col-span-2 space-y-6">
                <div class="stat-card space-y-6">
                    <h3 class="text-sm font-black uppercase tracking-widest text-white border-b border-white/5 pb-4">Identitas & SEO</h3>
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Judul Website (Title)</label>
                            <input type="text" name="web_title" value="{{ $settings['web_title'] ?? '' }}" class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="Contoh: Ventuz Store - Topup Game Termurah">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Deskripsi Website (SEO Meta)</label>
                            <textarea name="web_description" rows="3" class="w-full input-metal rounded-2xl py-4 px-6 text-sm resize-none" placeholder="Masukkan deskripsi singkat untuk pencarian Google...">{{ $settings['web_description'] ?? '' }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Keywords (Pisahkan dengan koma)</label>
                                <input type="text" name="web_keywords" value="{{ $settings['web_keywords'] ?? '' }}" class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="topup, game, voucher, murah">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Author / Pemilik</label>
                                <input type="text" name="web_author" value="{{ $settings['web_author'] ?? '' }}" class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="Ventuz Store Team">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Footer Copyright</label>
                            <input type="text" name="web_footer" value="{{ $settings['web_footer'] ?? '' }}" class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="Contoh: © 2024 Ventuz Store. All rights reserved.">
                        </div>
                    </div>
                </div>

                <div class="stat-card space-y-6">
                    <h3 class="text-sm font-black uppercase tracking-widest text-white border-b border-white/5 pb-4">Social Media & Kontak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">WhatsApp CS</label>
                            <input type="text" name="contact_wa" value="{{ $settings['contact_wa'] ?? '' }}" class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="628123456789">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Email Support</label>
                            <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="support@ventuzstore.com">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Username Instagram</label>
                            <input type="text" name="contact_ig" value="{{ $settings['contact_ig'] ?? '' }}" class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="@ventuzstore">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Link Facebook</label>
                            <input type="text" name="contact_fb" value="{{ $settings['contact_fb'] ?? '' }}" class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="https://facebook.com/ventuzstore">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Visual Assets -->
            <div class="space-y-6">
                <!-- Favicon -->
                <div class="stat-card space-y-4">
                    <h3 class="text-sm font-black uppercase tracking-widest text-white">Favicon</h3>
                    <div class="flex flex-col items-center gap-4 p-6 bg-white/[0.02] rounded-2xl border border-dashed border-white/10">
                        <div class="w-16 h-16 rounded-xl bg-white/5 flex items-center justify-center overflow-hidden border border-white/10">
                            <template x-if="faviconPreview">
                                <img :src="faviconPreview" class="w-full h-full object-contain">
                            </template>
                            <template x-if="!faviconPreview">
                                <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                            </template>
                        </div>
                        <label class="cursor-pointer">
                            <span class="btn-upload">Pilih Favicon</span>
                            <input type="file" name="web_favicon" @change="handleFile($event, 'favicon')" class="hidden" accept="image/*">
                        </label>
                        <p class="text-[9px] text-gray-600 text-center uppercase tracking-widest">Format: ICO, PNG (Max 1MB)</p>
                    </div>
                </div>

                <!-- Logo -->
                <div class="stat-card space-y-4">
                    <h3 class="text-sm font-black uppercase tracking-widest text-white">Logo Website</h3>
                    <div class="flex flex-col items-center gap-4 p-6 bg-white/[0.02] rounded-2xl border border-dashed border-white/10">
                        <div class="w-full h-24 rounded-xl bg-white/5 flex items-center justify-center overflow-hidden border border-white/10 p-4">
                            <template x-if="logoPreview">
                                <img :src="logoPreview" class="w-full h-full object-contain">
                            </template>
                            <template x-if="!logoPreview">
                                <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                            </template>
                        </div>
                        <label class="cursor-pointer">
                            <span class="btn-upload">Pilih Logo</span>
                            <input type="file" name="web_logo" @change="handleFile($event, 'logo')" class="hidden" accept="image/*">
                        </label>
                        <p class="text-[9px] text-gray-600 text-center uppercase tracking-widest">Format: PNG, WEBP (Max 2MB)</p>
                    </div>
                </div>

                <!-- OG Image -->
                <div class="stat-card space-y-4">
                    <h3 class="text-sm font-black uppercase tracking-widest text-white">Social Sharing Image (OG)</h3>
                    <div class="flex flex-col items-center gap-4 p-6 bg-white/[0.02] rounded-2xl border border-dashed border-white/10">
                        <div class="w-full aspect-video rounded-xl bg-white/5 flex items-center justify-center overflow-hidden border border-white/10 p-4">
                            <template x-if="ogPreview">
                                <img :src="ogPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!ogPreview">
                                <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                            </template>
                        </div>
                        <label class="cursor-pointer">
                            <span class="btn-upload">Pilih Gambar OG</span>
                            <input type="file" name="web_og_image" @change="handleFile($event, 'og')" class="hidden" accept="image/*">
                        </label>
                        <p class="text-[9px] text-gray-600 text-center uppercase tracking-widest">Rekomendasi: 1200x630 (Max 2MB)</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-metal py-4 px-12 rounded-xl font-black uppercase tracking-widest text-xs shadow-2xl shadow-brand-red/20">
                Simpan Seluruh Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
