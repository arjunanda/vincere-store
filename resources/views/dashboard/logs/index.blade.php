@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-black italic uppercase tracking-tight text-white">Riwayat <span class="text-brand-red">Aktivitas</span></h1>
        <p class="text-gray-500 font-medium mt-1">Audit log seluruh tindakan administrator di sistem.</p>
    </div>

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
