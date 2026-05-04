@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black italic uppercase tracking-tight text-white">Kelola <span class="text-brand-red">User</span></h1>
            <p class="text-gray-500 font-medium mt-1">Kelola data pelanggan dan hak akses administrator.</p>
        </div>
        <a href="{{ route('dashboard.users.create') }}" class="btn-metal py-3 px-8 rounded-xl font-black uppercase tracking-widest text-[10px] flex items-center gap-3 w-fit md:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            Tambah User
        </a>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('dashboard.users') }}" class="flex flex-col md:flex-row gap-3">
        <div class="relative flex-1">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-red">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama, username, atau email..."
                class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-3 pl-11 pr-4 text-sm font-medium focus:outline-none focus:border-brand-red/50 transition-all">
        </div>
        <select name="role" onchange="this.form.submit()"
            class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-sm font-bold focus:outline-none focus:border-brand-red/50 transition-all text-white appearance-none cursor-pointer min-w-[150px]">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>🔑 Admin</option>
            <option value="user"  {{ request('role') === 'user'  ? 'selected' : '' }}>👤 User</option>
        </select>
        <button type="submit" class="btn-metal px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Cari</button>
        @if(request()->hasAny(['search', 'role']))
            <a href="{{ route('dashboard.users') }}" class="px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 transition-colors whitespace-nowrap flex items-center">Reset</a>
        @endif
    </form>

    <!-- Table Card -->
    <div class="stat-card overflow-hidden !p-0 max-w-full !rounded-xl">
        <div class="w-full overflow-x-auto scrollbar-hide">
            <table class="w-full text-left border-collapse min-w-[600px] md:min-w-full table-auto">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest">Nama User</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest">Email</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest">Role</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest">Terdaftar</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                    <tr class="hover:bg-white/[0.01] transition-colors group">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-brand-red/10 flex items-center justify-center text-brand-red font-black">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-white">{{ $user->name }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest">ID: #{{ $user->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6">
                            <span class="text-xs font-bold text-gray-400">{{ $user->email }}</span>
                        </td>
                        <td class="p-6">
                            @if($user->role === 'admin')
                                <span class="px-3 py-1 bg-brand-red/10 text-brand-red text-[9px] font-black uppercase tracking-widest rounded-full border border-brand-red/20">Admin</span>
                            @else
                                <span class="px-3 py-1 bg-white/5 text-gray-500 text-[9px] font-black uppercase tracking-widest rounded-full border border-white/5">User</span>
                            @endif
                        </td>
                        <td class="p-6">
                            <span class="text-xs font-bold text-gray-500">{{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('dashboard.users.edit', $user) }}" class="p-1.5 hover:text-brand-red transition-colors text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 hover:text-red-500 transition-colors text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-600 font-medium italic">Belum ada user yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        {{ $users->links() }}
    </div>
</div>
@endsection
