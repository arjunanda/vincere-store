@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('dashboard.users') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-brand-neon flex items-center gap-2 mb-2 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
        <h1 class="text-2xl font-black  uppercase tracking-tight text-white">Tambah <span class="text-brand-neon">User</span></h1>
    </div>

    <form action="{{ route('dashboard.users.store') }}" method="POST" class="space-y-6" novalidate>
        @csrf
        
        <div class="stat-card">
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="Contoh: Admin Vincere" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest">Email Address</label>
                        <input type="email" name="email" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="admin@ventuz.com" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest">Role Akses</label>
                        <select name="role" class="w-full input-metal py-3 px-4 rounded-xl text-xs appearance-none" required>
                            <option value="user">User / Pelanggan</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest">Password</label>
                        <input type="password" name="password" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="********" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="********" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-metal py-4 px-12 rounded-xl font-black uppercase tracking-widest text-xs">
                Simpan Data User
            </button>
        </div>
    </form>
</div>
@endsection
