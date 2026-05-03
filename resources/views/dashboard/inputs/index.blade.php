@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black italic uppercase tracking-tight text-white">Master <span class="text-brand-red">Input</span></h1>
            <p class="text-gray-500 font-medium mt-1">Buat template input data pelanggan (ID, Zone, Username, dll).</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Tambah Grup -->
        <div class="lg:col-span-1">
            <form action="{{ route('dashboard.inputs.store') }}" method="POST" class="stat-card space-y-6">
                @csrf
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Nama Template <span class="text-brand-red">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Format MLBB" class="w-full input-metal rounded-2xl py-4 px-6">
                    @error('name') <p class="text-brand-red text-[10px] italic mt-1 ml-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="btn-metal w-full py-4 rounded-xl font-black uppercase tracking-widest text-xs">
                    Buat Template
                </button>
            </form>
        </div>

        <!-- List Template -->
        <div class="lg:col-span-2">
            <div class="stat-card !p-0 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 bg-white/[0.02]">
                                <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Nama Template</th>
                                <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Jumlah Field</th>
                                <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($groups as $group)
                            <tr class="hover:bg-white/[0.01] transition-colors">
                                <td class="p-6">
                                    <p class="font-bold text-white">{{ $group->name }}</p>
                                </td>
                                <td class="p-6">
                                    <span class="text-xs font-bold text-gray-400">{{ $group->fields->count() }} Field</span>
                                </td>
                                <td class="p-6 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('dashboard.inputs.edit', $group) }}" class="p-2 hover:text-brand-red transition-colors text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                                        </a>
                                        <form action="{{ route('dashboard.inputs.destroy', $group) }}" method="POST" onsubmit="return confirm('Hapus template ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 hover:text-red-500 transition-colors text-gray-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-12 text-center text-gray-600 font-medium italic">Belum ada template input.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Pagination -->
            {{ $groups->links() }}
        </div>
    </div>
</div>
@endsection
