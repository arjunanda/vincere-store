@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black  uppercase tracking-tight text-white">Kelola <span class="text-brand-neon">Banner</span></h1>
            <p class="text-gray-500 font-medium mt-1">Atur slider promo di halaman depan.</p>
        </div>
        <a href="{{ route('dashboard.banners.create') }}" class="btn-metal py-3 px-8 rounded-xl font-black uppercase tracking-widest text-[10px] flex items-center gap-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Banner
        </a>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('dashboard.banners') }}" class="flex flex-col md:flex-row gap-3">
        <div class="relative flex-1">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-neon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari judul banner..."
                class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-3 pl-11 pr-4 text-sm font-medium focus:outline-none focus:border-brand-neon/50 transition-all">
        </div>
        <select name="status" onchange="this.form.submit()"
            class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-sm font-bold focus:outline-none focus:border-brand-neon/50 transition-all text-white appearance-none cursor-pointer min-w-[150px]">
            <option value="">Semua Status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>✅ Aktif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>❌ Non-Aktif</option>
        </select>
        <button type="submit" class="btn-metal px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Cari</button>
        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('dashboard.banners') }}" class="px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 transition-colors whitespace-nowrap flex items-center">Reset</a>
        @endif
    </form>

    <div class="stat-card overflow-hidden !p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Preview</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Judul & Link</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-center">Posisi</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-center">Status</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($banners as $banner)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="p-6">
                            <img src="{{ asset('storage/' . $banner->image) }}" class="w-32 h-16 object-cover rounded-lg border border-white/10" alt="">
                        </td>
                        <td class="p-6">
                            <p class="font-bold text-white">{{ $banner->title ?? 'Tanpa Judul' }}</p>
                            <p class="text-[10px] text-gray-500 ">{{ $banner->link ?? 'No Link' }}</p>
                        </td>
                        <td class="p-6 text-center">
                            <span class="text-xs font-bold text-gray-400">#{{ $banner->order_position }}</span>
                        </td>
                        <td class="p-6 text-center">
                            @if($banner->is_active)
                                <span class="px-3 py-1 bg-green-500/10 text-green-500 text-[8px] font-black uppercase tracking-widest rounded-full border border-green-500/20">Aktif</span>
                            @else
                                <span class="px-3 py-1 bg-red-500/10 text-red-500 text-[8px] font-black uppercase tracking-widest rounded-full border border-red-500/20">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('dashboard.banners.edit', $banner) }}" class="p-2 hover:text-brand-neon transition-colors text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('dashboard.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
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
                        <td colspan="5" class="p-12 text-center text-gray-600 font-medium ">Belum ada banner yang dipasang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $banners->links() }}
    </div>
</div>
@endsection
