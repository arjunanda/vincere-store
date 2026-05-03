@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div>
        <a href="{{ route('dashboard.banners') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-brand-red flex items-center gap-2 mb-4 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
        <h1 class="text-3xl font-black italic uppercase tracking-tight text-white">Edit <span class="text-brand-red">Banner</span></h1>
    </div>

    <form action="{{ route('dashboard.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="stat-card space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Judul Banner (Opsional)</label>
                    <input type="text" name="title" value="{{ $banner->title }}" placeholder="Contoh: Promo Ramadhan" class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 px-6 focus:outline-none focus:border-brand-red/50 text-white font-medium">
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Urutan (Position)</label>
                    <input type="number" name="order_position" value="{{ $banner->order_position }}" class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 px-6 focus:outline-none focus:border-brand-red/50 text-white font-medium">
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Link Tujuan (URL)</label>
                <input type="text" name="link" value="{{ $banner->link }}" placeholder="Contoh: https://ventuz.store/promo/abc" class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 px-6 focus:outline-none focus:border-brand-red/50 text-white font-medium">
            </div>
            
            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Status Banner</label>
                <div class="flex items-center gap-4 bg-white/[0.03] border border-white/10 rounded-2xl py-4 px-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="is_active" value="1" {{ $banner->is_active ? 'checked' : '' }} class="text-brand-red focus:ring-brand-red bg-black border-white/20">
                        <span class="text-sm font-bold text-white">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="is_active" value="0" {{ !$banner->is_active ? 'checked' : '' }} class="text-gray-500 focus:ring-gray-500 bg-black border-white/20">
                        <span class="text-sm font-bold text-gray-500">Nonaktif</span>
                    </label>
                </div>
            </div>

            <div class="space-y-4" x-data="{ 
                photoPreview: null,
                handleFile(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.photoPreview = e.target.result; };
                        reader.readAsDataURL(file);
                    }
                }
            }">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">File Gambar Banner (Ganti Opsional)</label>
                
                <div class="flex flex-col items-center gap-4 p-8 bg-white/[0.02] rounded-3xl border border-dashed border-white/10 group hover:border-brand-red/50 transition-all">
                    <div class="w-full aspect-video max-h-48 rounded-2xl bg-white/5 flex items-center justify-center overflow-hidden border border-white/10">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!photoPreview">
                            @if($banner->image)
                                <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                                    <p class="text-[10px] text-gray-700 font-black uppercase tracking-widest">Pratinjau Banner</p>
                                </div>
                            @endif
                        </template>
                    </div>
                    <label class="cursor-pointer">
                        <span class="btn-upload">Ubah Gambar</span>
                        <input type="file" name="image" @change="handleFile($event)" class="hidden" accept="image/*">
                    </label>
                    <p class="text-[9px] text-gray-600 text-center uppercase tracking-widest">Rekomendasi: 1600x587 px (Maks 2MB)</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-metal px-10 py-4 rounded-xl font-black uppercase tracking-widest text-sm shadow-lg shadow-brand-red/20">
                    Perbarui Banner
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
