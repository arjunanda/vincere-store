@extends('layouts.dashboard')

@section('content')
    <div x-data="{ 
        showModal: false, 
        isEdit: false, 
        formAction: '', 
        categoryId: '', 
        categoryName: '',

        openCreate() {
            this.isEdit = false;
            this.formAction = '{{ route('dashboard.categories.store') }}';
            this.categoryId = '';
            this.categoryName = '';
            this.showModal = true;
        },
        openEdit(id, name) {
            this.isEdit = true;
            this.formAction = '/dashboard/categories/' + id;
            this.categoryId = id;
            this.categoryName = name;
            this.showModal = true;
        }
    }" class="space-y-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black italic uppercase tracking-tight text-white">Master <span
                        class="text-brand-red">Kategori</span></h1>
                <p class="text-gray-500 font-medium mt-1">Kelola daftar kategori game yang tersedia.</p>
            </div>
            <button @click="openCreate()"
                class="btn-metal py-3 px-8 rounded-xl font-black uppercase tracking-widest text-[10px] flex items-center gap-3 w-fit md:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
            </button>
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('dashboard.categories.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1 max-w-xl">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-red">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau slug kategori..."
                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-3 pl-11 pr-4 text-sm font-medium focus:outline-none focus:border-brand-red/50 transition-all">
            </div>
            <button type="submit" class="btn-metal px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Cari</button>
            @if(request('search'))
                <a href="{{ route('dashboard.categories.index') }}" class="px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 transition-colors whitespace-nowrap flex items-center">Reset</a>
            @endif
        </form>

        <!-- Categories Table -->
        <div class="stat-card overflow-hidden !p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/[0.02]">
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 w-16">ID</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Nama Kategori
                            </th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Slug</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-center">
                                Jumlah Game</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($categories as $category)
                            <tr class="hover:bg-white/[0.01] transition-colors">
                                <td class="p-6 text-sm text-gray-400 font-mono">#{{ $category->id }}</td>
                                <td class="p-6">
                                    <div class="font-bold text-white">{{ $category->name }}</div>
                                </td>
                                <td class="p-6 text-sm text-gray-500 font-mono">{{ $category->slug }}</td>
                                <td class="p-6 text-center">
                                    <span
                                        class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-bold text-gray-300">
                                        {{ $category->games_count }}
                                    </span>
                                </td>
                                <td class="p-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="openEdit('{{ $category->id }}', '{{ $category->name }}')"
                                            class="p-2 bg-white/5 rounded-lg text-gray-400 hover:text-white transition-colors"
                                            title="Edit Kategori">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('dashboard.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Hapus kategori ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-white/5 rounded-lg text-gray-400 hover:text-red-500 transition-colors"
                                                title="Hapus Kategori">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-600 font-medium italic">Belum ada kategori
                                    yang ditambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            {{ $categories->links() }}
        </div>

        <!-- Modal Form (Lazy Loaded) -->
        <template x-if="showModal">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="showModal = false" x-transition.opacity>
                </div>

                <div class="stat-card relative w-full max-w-lg shadow-2xl"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-black italic tracking-tight text-white">
                            <span x-text="isEdit ? 'EDIT' : 'TAMBAH'"></span> 
                            <span class="text-brand-red">KATEGORI</span>
                        </h3>
                        <button @click="showModal = false" class="text-gray-500 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form :action="formAction" method="POST">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1 block mb-2">Nama
                                    Kategori <span class="text-brand-red">*</span></label>
                                <input type="text" name="name" x-model="categoryName" required
                                    placeholder="Contoh: Mobile Legends"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-3 px-4 focus:outline-none focus:border-brand-red/50 text-white font-medium text-sm transition-colors">
                                @error('name') <p class="text-brand-red text-[10px] italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 flex gap-3">
                            <button type="button" @click="showModal = false"
                                class="flex-1 py-4 rounded-xl font-bold text-sm text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 btn-metal py-4 rounded-xl font-black uppercase tracking-widest text-sm shadow-lg shadow-brand-red/20">
                                <span class="btn-text" x-text="isEdit ? 'Simpan Perubahan' : 'Tambahkan Kategori'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
@endsection