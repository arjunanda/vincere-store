@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('dashboard.games') }}"
                class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-brand-neon flex items-center gap-2 mb-2 transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-black  uppercase tracking-tight text-white">Tambah <span
                    class="text-brand-neon">Game Baru</span></h1>
        </div>

        <form action="{{ route('dashboard.games.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Side: Basic Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="stat-card">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Nama Game <span class="text-brand-neon">*</span></label>
                                <input type="text" name="name" class="w-full input-metal py-3 px-4 rounded-xl text-xs"
                                    placeholder="Contoh: Mobile Legends" required>
                                @error('name') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black uppercase tracking-widest text-gray-500">Platform <span class="text-brand-neon">*</span></label>
                                <select name="platform_type"
                                    class="w-full input-metal py-3 px-4 rounded-xl text-xs appearance-none" required>
                                    <option value="mobile">Mobile</option>
                                    <option value="pc">PC / Desktop</option>
                                    <option value="console">Console</option>
                                </select>
                                @error('platform_type') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black uppercase tracking-widest text-gray-500">Kategori <span class="text-brand-neon">*</span></label>
                                <select name="category_id"
                                    class="w-full input-metal py-3 px-4 rounded-xl text-xs appearance-none" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Master Input
                                    Template <span class="text-brand-neon">*</span></label>
                                <select name="input_group_id"
                                    class="w-full input-metal py-3 px-4 rounded-xl text-xs appearance-none" required>
                                    @foreach($inputGroups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                                @error('input_group_id') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-2 mt-6">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Deskripsi /
                                Petunjuk</label>
                            <textarea name="description" rows="4" class="w-full input-metal py-3 px-4 rounded-xl text-xs"
                                placeholder="Tuliskan petunjuk pengisian atau deskripsi game..."></textarea>
                            @error('description') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Right Side: Image Upload -->
                <div class="space-y-6">
                    <div class="stat-card space-y-4" x-data="{ 
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
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 block">Gambar Game <span class="text-brand-neon">*</span></label>
                        
                        <div class="flex flex-col items-center gap-4 p-6 bg-white/[0.02] rounded-2xl border border-dashed border-white/10">
                            <div class="w-24 h-24 rounded-2xl bg-white/5 flex items-center justify-center overflow-hidden border border-white/10">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                                </template>
                            </div>
                            <label class="cursor-pointer">
                                <span class="btn-upload">Pilih Gambar</span>
                                <input type="file" name="image" @change="handleFile($event)" class="hidden" accept="image/*" required>
                            </label>
                            <p class="text-[9px] text-gray-600 text-center uppercase tracking-widest">Rasio 1:1 (Max 2MB)</p>
                        </div>
                        @error('image') <p class="text-brand-neon text-[10px]  mt-2">{{ $message }}</p> @enderror

                        <div class="p-4 bg-brand-neon/5 rounded-xl border border-brand-neon/10">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-brand-neon mb-1 text-center">Rekomendasi</h4>
                            <p class="text-[9px] text-gray-400 leading-relaxed text-center">Gunakan gambar <strong>600x600 px</strong> untuk katalog yang simetris.</p>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full btn-metal py-4 rounded-xl font-black uppercase tracking-widest text-xs">
                        <span class="btn-text">Simpan Game</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection