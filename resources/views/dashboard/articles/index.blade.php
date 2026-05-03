@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black italic uppercase tracking-tight text-white">Kelola <span class="text-brand-red">Artikel</span></h1>
            <p class="text-gray-500 font-medium mt-1">Manajemen berita, promo, dan update terbaru.</p>
        </div>
        <a href="{{ route('dashboard.articles.create') }}" class="btn-metal py-3 px-8 rounded-xl font-black uppercase tracking-widest text-[10px] flex items-center gap-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tulis Artikel
        </a>
    </div>

    <div class="stat-card overflow-hidden !p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Gambar</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Judul & Slug</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-center">Tipe</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-center">Status</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-center">Tgl Terbit</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($articles as $article)
                    <tr class="hover:bg-white/[0.01] transition-colors group">
                        <td class="p-6">
                            <img src="{{ asset('storage/' . $article->image) }}" class="w-20 h-12 object-cover rounded border border-white/5" alt="">
                        </td>
                        <td class="p-6">
                            <p class="font-bold text-white leading-snug">{{ $article->title }}</p>
                            <p class="text-[9px] text-brand-red font-mono mt-1">{{ $article->slug }}</p>
                        </td>
                        <td class="p-6 text-center">
                            <span class="px-3 py-1 bg-white/5 text-gray-400 text-[8px] font-black uppercase tracking-widest rounded border border-white/5">
                                {{ $article->type }}
                            </span>
                        </td>
                        <td class="p-6 text-center">
                            <label class="switch mx-auto">
                                <input type="checkbox" 
                                    class="status-toggle"
                                    data-id="{{ $article->id }}"
                                    data-name="{{ $article->title }}"
                                    onchange="toggleArticleStatus(this)" 
                                    {{ $article->is_active ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td class="p-6 text-center">
                            <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest">{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</span>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('dashboard.articles.edit', $article) }}" class="p-2 hover:text-brand-red transition-colors text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('dashboard.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 hover:text-red-500 transition-colors text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-gray-600 font-medium italic">Belum ada artikel yang ditulis.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $articles->links() }}
    </div>

    <script>
    async function toggleArticleStatus(checkbox) {
        const id = checkbox.dataset.id;
        const originalState = !checkbox.checked;
        
        try {
            const response = await fetch(`/dashboard/articles/${id}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Gagal mengubah status');
            }

            showToast(data.message);

        } catch (error) {
            checkbox.checked = originalState;
            showToast(error.message, 'error');
        }
    }
    </script>
</div>
@endsection
