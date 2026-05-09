@extends('layouts.dashboard')

@section('content')
<div class="space-y-8" x-data="{ 
    openRename: false, 
    openAddField: false,
    openFieldEdit: false,
    editData: { id: '', label: '', type: '', placeholder: '', max_length: '' },
    openEditModal(field) {
        this.editData = field;
        this.openFieldEdit = true;
    }
}">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <a href="{{ route('dashboard.inputs') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-brand-neon flex items-center gap-2 mb-4 transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <h1 class="text-3xl font-black  uppercase tracking-tight text-white">Kelola <span class="text-brand-neon">Field</span></h1>
                <button @click="openRename = true" class="flex items-center gap-3 px-4 py-2 bg-white/5 border border-white/10 rounded-xl hover:border-brand-neon/50 transition-all group w-fit">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-hover:text-white">{{ $group->name }}</span>
                    <svg class="w-4 h-4 text-brand-neon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </button>
            </div>
        </div>

        <button @click="openAddField = true" class="btn-metal py-3 px-8 rounded-xl font-black uppercase tracking-widest text-[10px] flex items-center gap-3 w-fit md:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Field Baru
        </button>
    </div>

    <!-- Table Section (Full Width) -->
    <div class="stat-card overflow-hidden !p-0 max-w-full !rounded-xl">
        <div class="w-full overflow-x-auto scrollbar-hide">
            <table class="w-full text-left border-collapse min-w-[700px] md:min-w-full table-auto">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Label / Name</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Tipe</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Placeholder</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Max</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($group->fields as $field)
                    <tr class="hover:bg-white/[0.01] transition-colors group">
                        <td class="p-6">
                            <p class="font-bold text-white">{{ $field->label }}</p>
                            <p class="text-[10px] text-gray-500 font-medium ">Key: <span class="text-brand-neon">{{ $field->name }}</span></p>
                        </td>
                        <td class="p-6">
                            <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 bg-white/5 rounded-full text-gray-400 border border-white/10">
                                {{ $field->type }}
                            </span>
                        </td>
                        <td class="p-6">
                            <span class="text-xs text-gray-500 ">{{ $field->placeholder ?? '-' }}</span>
                        </td>
                        <td class="p-6">
                            @if($field->max_length)
                                <span class="text-xs font-bold text-gray-400">{{ $field->max_length }} Karakter</span>
                            @else
                                <span class="text-[10px] text-gray-600 uppercase tracking-widest">No Limit</span>
                            @endif
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <button type="button" @click="openEditModal({ id: {{ $field->id }}, label: '{{ addslashes($field->label) }}', type: '{{ $field->type }}', placeholder: '{{ addslashes($field->placeholder ?? '') }}', max_length: '{{ $field->max_length ?? '' }}' })" class="p-1.5 hover:text-brand-neon transition-colors text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                <form action="{{ route('dashboard.inputs.fields.destroy', $field) }}" method="POST" onsubmit="return confirm('Hapus field ini?')">
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
                        <td colspan="5" class="p-12 text-center text-gray-600 font-medium ">Belum ada field untuk template ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Rename Template Modal -->
    <template x-if="openRename">
        <div class="fixed inset-0 z-[9999] flex items-center justify-center p-6">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="openRename = false" x-transition.opacity></div>
            <div class="stat-card relative w-full max-w-md shadow-2xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                <h3 class="text-lg font-black  uppercase text-white mb-6">Ubah Nama <span class="text-brand-neon">Template</span></h3>
                <form action="{{ route('dashboard.inputs.update', $group) }}" method="POST" novalidate>
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1 block mb-2">Nama Template <span class="text-brand-neon">*</span></label>
                            <input type="text" name="name" value="{{ $group->name }}" class="w-full input-metal rounded-xl py-4 px-6 text-sm" required>
                            @error('name') <p class="text-brand-neon text-[10px]  mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex gap-3">
                            <button type="button" @click="openRename = false" class="flex-1 py-3 px-6 bg-white/5 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500">Batal</button>
                            <button type="submit" class="flex-1 py-3 px-6 btn-metal rounded-xl text-[10px] font-black uppercase tracking-widest">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <!-- Add Field Modal -->
    <template x-if="openAddField">
        <div class="fixed inset-0 z-[9999] flex items-center justify-center p-6">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="openAddField = false" x-transition.opacity></div>
            <div class="stat-card relative w-full max-w-md shadow-2xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                <h3 class="text-lg font-black  uppercase text-white mb-6">Tambah <span class="text-brand-neon">Field Baru</span></h3>
                <form action="{{ route('dashboard.inputs.fields.store', $group) }}" method="POST" class="space-y-5" novalidate>
                    @csrf
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Label Input <span class="text-brand-neon">*</span></label>
                        <input type="text" name="label" required placeholder="Contoh: Masukkan User ID" class="w-full input-metal rounded-xl py-3 px-4 text-xs">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Tipe Input <span class="text-brand-neon">*</span></label>
                        <select name="type" required class="w-full input-metal rounded-xl py-3 px-4 text-xs appearance-none">
                            <option value="text">Text / Angka</option>
                            <option value="number">Hanya Angka</option>
                            <option value="tel">Telepon / WhatsApp</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Placeholder</label>
                        <input type="text" name="placeholder" placeholder="Contoh: 12345678" class="w-full input-metal rounded-xl py-3 px-4 text-xs">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Max Karakter (Opsional)</label>
                        <input type="number" name="max_length" placeholder="Tanpa batas" class="w-full input-metal rounded-xl py-3 px-4 text-xs">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="openAddField = false" class="flex-1 py-4 bg-white/5 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500">Batal</button>
                        <button type="submit" class="flex-1 py-4 btn-metal rounded-xl text-[10px] font-black uppercase tracking-widest">Simpan Field</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <!-- Field Edit Modal (Global) -->
    <template x-if="openFieldEdit">
        <div class="fixed inset-0 z-[9999] flex items-center justify-center p-6">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="openFieldEdit = false" x-transition.opacity></div>
            <div class="stat-card relative w-full max-w-md shadow-2xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                <h3 class="text-lg font-black  uppercase text-white mb-6">Edit <span class="text-brand-neon">Field</span></h3>
                <form :action="'{{ url('dashboard/inputs/fields') }}/' + editData.id" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Label Input <span class="text-brand-neon">*</span></label>
                        <input type="text" name="label" x-model="editData.label" class="w-full input-metal rounded-xl py-3 px-4 text-xs" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Tipe Input <span class="text-brand-neon">*</span></label>
                        <select name="type" x-model="editData.type" required class="w-full input-metal rounded-xl py-3 px-4 text-xs appearance-none">
                            <option value="text">Text / Angka</option>
                            <option value="number">Hanya Angka</option>
                            <option value="tel">Telepon / WhatsApp</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Placeholder</label>
                        <input type="text" name="placeholder" x-model="editData.placeholder" class="w-full input-metal rounded-xl py-3 px-4 text-xs">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Max Karakter (Opsional)</label>
                        <input type="number" name="max_length" x-model="editData.max_length" class="w-full input-metal rounded-xl py-3 px-4 text-xs" placeholder="Tanpa batas">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="openFieldEdit = false" class="flex-1 py-4 bg-white/5 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500">Batal</button>
                        <button type="submit" class="flex-1 py-4 btn-metal rounded-xl text-[10px] font-black uppercase tracking-widest">Update Field</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
@endsection
