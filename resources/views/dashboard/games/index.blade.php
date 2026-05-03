@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black italic uppercase tracking-tight text-white">Kelola <span class="text-brand-red">Game</span></h1>
                <p class="text-gray-500 font-medium mt-1">Manajemen katalog produk dan harga layanan.</p>
            </div>
            <a href="{{ route('dashboard.games.create') }}"
                class="btn-metal py-3 px-8 rounded-xl font-black uppercase tracking-widest text-[10px] flex items-center gap-3 w-fit md:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Game
            </a>
        </div>

        <!-- Filter & Search -->
        <form action="{{ route('dashboard.games') }}" method="GET"
            class="stat-card !py-4 flex flex-col md:flex-row items-center gap-4">
            <div class="relative flex-1 w-full">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama game..."
                    class="w-full input-metal !py-3 !pl-10 !pr-4 !rounded-xl text-xs">
            </div>
            <div class="w-full md:w-64">
                <select name="category_id" onchange="this.form.submit()"
                    class="w-full input-metal !py-3 !px-4 !rounded-xl text-xs appearance-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}
                            class="bg-black">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="btn-metal !py-3 px-6 !rounded-xl text-[10px] font-black uppercase tracking-widest w-full md:w-auto">
                Filter
            </button>
            @if(request('search') || request('category_id'))
                <a href="{{ route('dashboard.games') }}"
                    class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-white px-2">Reset</a>
            @endif
        </form>

        <!-- Table Card -->
        <div class="stat-card overflow-hidden !p-0 max-w-full !rounded-xl">
            <div class="w-full overflow-x-auto scrollbar-hide">
                <table class="w-full text-left border-collapse min-w-[700px] md:min-w-full table-auto">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/[0.02]">
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Game</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Kategori</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Platform</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Status</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($games as $game)
                            <tr class="hover:bg-white/[0.01] transition-colors group">
                                <td class="p-6">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset('storage/' . $game->image) }}"
                                            class="w-12 h-12 rounded-xl object-cover border border-white/10 group-hover:border-brand-red/50 transition-colors">
                                        <div>
                                            <p class="font-bold text-white">{{ $game->name }}</p>
                                            <p class="text-[10px] text-gray-500 uppercase tracking-widest">{{ $game->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <span class="text-xs font-bold text-gray-400">{{ $game->category->name ?? '-' }}</span>
                                </td>
                                <td class="p-6">
                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest px-3 py-1 bg-white/5 rounded-full text-gray-400 border border-white/10">
                                        {{ $game->platform_type }}
                                    </span>
                                </td>
                                <td class="p-6">
                                    <label class="switch">
                                        <input type="checkbox" 
                                            class="status-toggle"
                                            data-id="{{ $game->id }}"
                                            data-name="{{ $game->name }}"
                                            onchange="toggleGameStatus(this)" 
                                            {{ $game->is_active ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td class="p-6 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('dashboard.games.items', $game) }}"
                                            class="btn-metal py-1.5 px-3 !rounded-lg text-[9px] font-black uppercase tracking-widest">
                                            Set Item
                                        </a>
                                        <a href="{{ route('dashboard.games.edit', $game) }}"
                                            class="p-1.5 hover:text-brand-red transition-colors text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('dashboard.games.destroy', $game) }}" method="POST"
                                            onsubmit="return confirm('Hapus game ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 hover:text-red-500 transition-colors text-gray-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-600 font-medium italic">Belum ada game yang
                                    terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            {{ $games->links() }}
        </div>

        <!-- Floating Action Button (Mobile Only) -->
        <a href="{{ route('dashboard.games.create') }}" class="fab lg:hidden">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>

        <script>
        async function toggleGameStatus(checkbox) {
            const id = checkbox.dataset.id;
            const originalState = !checkbox.checked;
            
            try {
                const response = await fetch(`/dashboard/games/${id}/toggle-status`, {
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