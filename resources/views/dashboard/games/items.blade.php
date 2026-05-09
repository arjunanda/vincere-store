@extends('layouts.dashboard')

@section('content')
    <div x-data="{ copyModal: false }" class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex-1 min-w-0">
                <a href="{{ route('dashboard.games') }}"
                    class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-brand-neon flex items-center gap-2 mb-2 transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <h1 class="text-xl md:text-3xl font-black  uppercase tracking-tight truncate">
                    Set Item: <span class="text-brand-neon">{{ $game->name }}</span>
                </h1>
                <p class="text-gray-500 font-medium mt-1 text-[10px] md:text-sm">Manajemen varian produk dan harga.</p>
            </div>
            <div class="flex items-center gap-3">
                <button @click="copyModal = true"
                    class="px-6 py-3 border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:border-brand-neon hover:text-brand-neon transition-all">
                    Import Item (.csv)
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Form Section (Above on Mobile) -->
            <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-24 order-1">
                <div class="stat-card border-brand-neon/20 border">
                    <div class="mb-8">
                        <h3 class="text-lg font-black  uppercase text-white">Tambah <span class="text-brand-neon">Item Baru</span></h3>
                        <p class="text-[10px] text-gray-500 font-medium uppercase tracking-widest mt-1">Input varian & harga jaring.</p>
                    </div>

                    <form action="{{ route('dashboard.games.items.store', $game) }}" method="POST" class="space-y-6" novalidate>
                        @csrf
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Nama Item (Varian)</label>
                            <input type="text" name="name" required placeholder="Contoh: 86 Diamonds"
                                class="w-full input-metal rounded-2xl py-4 px-6 text-sm">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Harga Jual (Rp)</label>
                            <input type="number" name="price" required placeholder="Contoh: 20000"
                                class="w-full input-metal rounded-2xl py-4 px-6 text-sm">
                        </div>
                        <button type="submit"
                            class="btn-metal w-full py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-brand-neon/20 mt-4">
                            Simpan Item Baru
                        </button>
                    </form>
                </div>
            </div>

            <!-- Table Section -->
            <div class="lg:col-span-2 space-y-6 order-2">
                <div class="stat-card !p-0 overflow-hidden">
                    <div class="p-6 border-b border-white/5 bg-white/[0.01]">
                        <h3 class="text-xs font-black uppercase tracking-widest text-white">Daftar Varian Aktif</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-white/5 bg-white/[0.02]">
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Item</th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Harga</th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($game->variants as $variant)
                                    <tr class="hover:bg-white/[0.01] transition-colors group">
                                        <td class="p-6">
                                            <p class="font-bold text-white uppercase tracking-tight text-sm">{{ $variant->name }}</p>
                                        </td>
                                        <td class="p-6">
                                            <span class="text-brand-neon font-black ">Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="p-6 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('dashboard.items.edit', $variant) }}"
                                                    class="p-2 hover:text-brand-neon transition-colors text-gray-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('dashboard.items.destroy', $variant) }}" method="POST"
                                                    onsubmit="return confirm('Hapus item ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2 hover:text-red-500 transition-colors text-gray-600">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-12 text-center text-gray-600 font-medium  text-xs uppercase tracking-widest">
                                            Belum ada item yang terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Import Item -->
        <div x-show="copyModal" x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div @click.away="copyModal = false" class="stat-card w-full max-w-lg border-white/10 border border-dashed">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-black  uppercase metallic-text">Import <span
                            class="text-brand-neon">Item</span></h3>
                    <button @click="copyModal = false" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="bg-brand-neon/5 border border-brand-neon/20 rounded-2xl p-6 mb-8">
                    <p class="text-[10px] font-black uppercase tracking-widest text-brand-neon mb-3">Format CSV:</p>
                    <div class="bg-black/40 rounded-xl p-4 font-mono text-[10px] text-gray-300">
                        nama_item,harga<br>
                        86 Diamonds,20000<br>
                        172 Diamonds,40000
                    </div>
                    <p class="text-[9px] text-gray-500 mt-4 leading-relaxed uppercase tracking-tighter">
                        * Pastikan kolom pertama adalah Nama Item dan kolom kedua adalah Harga (Angka saja).
                    </p>
                </div>

                <form action="{{ route('dashboard.games.items.import', $game) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Pilih File CSV</label>
                        <input type="file" name="file" required accept=".csv"
                            class="w-full input-metal rounded-2xl py-4 px-6 text-sm file:hidden cursor-pointer">
                    </div>
                    <button type="submit"
                        class="btn-metal w-full py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-brand-neon/20 mt-4">
                        Mulai Import Item
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection