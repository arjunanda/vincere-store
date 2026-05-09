@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('dashboard.users') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-brand-neon flex items-center gap-2 mb-2 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
        <h1 class="text-2xl font-black  uppercase tracking-tight text-white">Edit <span class="text-brand-neon">User</span></h1>
        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">{{ $user->name }}</p>
    </div>

    <form action="{{ route('dashboard.users.update', $user) }}" method="POST" class="space-y-6" novalidate>
        @csrf
        @method('PUT')
        
        <div class="stat-card">
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Nama Lengkap <span class="text-brand-neon">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full input-metal py-3 px-4 rounded-xl text-xs" required>
                        @error('name') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Username <span class="text-brand-neon">*</span></label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full input-metal py-3 px-4 rounded-xl text-xs" required>
                        @error('username') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Email Address <span class="text-brand-neon">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full input-metal py-3 px-4 rounded-xl text-xs" required>
                        @error('email') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="0812xxxxxxxx">
                        @error('whatsapp') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Role Akses <span class="text-brand-neon">*</span></label>
                        <select name="role" class="w-full input-metal py-3 px-4 rounded-xl text-xs appearance-none" required>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User / Pelanggan</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @error('role') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="p-4 bg-white/5 rounded-xl border border-white/5">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ">Ganti Password (Opsional)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Password Baru</label>
                            <input type="password" name="password" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="Kosongkan jika tidak diganti">
                            @error('password') <p class="text-brand-neon text-[10px]  mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full input-metal py-3 px-4 rounded-xl text-xs" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-metal py-4 px-12 rounded-xl font-black uppercase tracking-widest text-xs">
                Perbarui Data User
            </button>
        </div>
    </form>
</div>
@endsection
