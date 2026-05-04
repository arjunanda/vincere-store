@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black italic uppercase tracking-tight text-white">Riwayat <span class="text-brand-red">Aktivitas</span></h1>
            <p class="text-gray-500 font-medium mt-1">Audit log seluruh tindakan administrator di sistem.</p>
        </div>
        <div class="text-sm text-gray-500">Total: <span class="text-white font-black">{{ $logs->total() }}</span> log</div>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('dashboard.logs') }}" class="flex flex-col md:flex-row gap-3">
        <div class="relative flex-1">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-red">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari aksi, keterangan, atau IP..."
                class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-3 pl-11 pr-4 text-sm font-medium focus:outline-none focus:border-brand-red/50 transition-all">
        </div>
        @if($admins->isNotEmpty())
        <select name="user_id" onchange="this.form.submit()"
            class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-sm font-bold focus:outline-none focus:border-brand-red/50 transition-all text-white appearance-none cursor-pointer min-w-[180px]">
            <option value="">Semua Admin</option>
            @foreach($admins as $admin)
                <option value="{{ $admin->id }}" {{ request('user_id') == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
            @endforeach
        </select>
        @endif
        <button type="submit" class="btn-metal px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Cari</button>
        @if(request()->hasAny(['search', 'user_id']))
            <a href="{{ route('dashboard.logs') }}" class="px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 transition-colors whitespace-nowrap flex items-center">Reset</a>
        @endif
    </form>

    <!-- Table Card -->
    <div class="stat-card overflow-hidden !p-0 max-w-full !rounded-xl">
        <div class="w-full overflow-x-auto scrollbar-hide">
            <table class="w-full text-left border-collapse min-w-[700px] md:min-w-full table-auto">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest">Admin</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest">Aksi</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest">Keterangan</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest">IP Address</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($logs as $log)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="p-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-[10px] font-black text-gray-400">
                                    {{ substr($log->user->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-white">{{ $log->user->name ?? 'Deleted User' }}</span>
                            </div>
                        </td>
                        <td class="p-6">
                            <span class="px-2 py-1 bg-brand-red/5 text-brand-red text-[8px] font-black uppercase tracking-tighter border border-brand-red/10 rounded">
                                {{ str_replace('_', ' ', $log->action) }}
                            </span>
                        </td>
                        <td class="p-6">
                            <p class="text-xs text-gray-400 font-medium leading-relaxed max-w-xs">{{ $log->description }}</p>
                        </td>
                        <td class="p-6">
                            <span class="text-[10px] font-mono text-gray-600">{{ $log->ip_address }}</span>
                        </td>
                        <td class="p-6 text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                            {{ $log->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-600 font-medium italic">Belum ada riwayat aktivitas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        {{ $logs->links() }}
    </div>
</div>
@endsection
