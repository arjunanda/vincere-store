@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div>
        <a href="{{ route('dashboard.articles') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-brand-neon flex items-center gap-2 mb-4 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
        <h1 class="text-3xl font-black  uppercase tracking-tight text-white">Tulis <span class="text-brand-neon">Artikel Baru</span></h1>
    </div>

    <form action="{{ route('dashboard.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Content -->
            <div class="lg:col-span-2 space-y-6">
                <div class="stat-card space-y-6">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Judul Artikel</label>
                        <input type="text" name="title" required placeholder="Contoh: Update Patch Note MLBB v1.2" class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 px-6 focus:outline-none focus:border-brand-neon/50 text-white font-bold text-lg">
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Konten Lengkap</label>
                        <textarea name="content" id="content-editor" rows="15" required class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-6 px-6 focus:outline-none focus:border-brand-neon/50 text-white font-medium leading-relaxed" placeholder="Tulis artikel di sini..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div class="lg:col-span-1 space-y-6">
                <div class="stat-card space-y-6 sticky top-24">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Tipe Konten</label>
                        <select name="type" required class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 px-6 focus:outline-none focus:border-brand-neon/50 text-white font-medium appearance-none">
                            <option value="berita" class="bg-black">Berita / Update</option>
                            <option value="promo" class="bg-black">Promo / Event</option>
                        </select>
                    </div>

                    <div class="space-y-3" x-data="{ 
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
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Thumbnail Artikel</label>
                        <div class="flex flex-col items-center gap-4 p-6 bg-white/[0.02] rounded-2xl border border-dashed border-white/10 group hover:border-brand-neon/50 transition-all">
                            <div class="w-full aspect-video rounded-xl bg-white/5 flex items-center justify-center overflow-hidden border border-white/10">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z" /></svg>
                                        <p class="text-[9px] text-gray-700 font-black uppercase tracking-widest text-center">Pratinjau Thumbnail</p>
                                    </div>
                                </template>
                            </div>
                            <label class="cursor-pointer">
                                <span class="btn-upload">Pilih Gambar</span>
                                <input type="file" name="image" @change="handleFile($event)" class="hidden" accept="image/*" required>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Ringkasan (Excerpt)</label>
                        <textarea name="excerpt" rows="3" class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 px-6 focus:outline-none focus:border-brand-neon/50 text-white text-xs leading-relaxed" placeholder="Ringkasan singkat artikel..."></textarea>
                    </div>

                    <button type="submit" class="btn-metal w-full py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-lg shadow-brand-neon/20">
                        <span class="btn-text">Terbitkan Artikel</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function initTinyMCE() {
        if (typeof tinymce === 'undefined') return;
        tinymce.remove('#content-editor');
        tinymce.init({
            selector: '#content-editor',
            skin: 'oxide-dark',
            content_css: 'dark',
            height: 500,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold  underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            menubar: false,
            setup: function (editor) {
                editor.on('change', function () { editor.save(); });
            }
        });
    }
    initTinyMCE();

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('placeholder-icon');
        const img = preview.querySelector('img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
