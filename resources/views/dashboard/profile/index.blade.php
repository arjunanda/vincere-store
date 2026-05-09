@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl space-y-8">
    <div>
        <h1 class="text-3xl font-black  uppercase tracking-tight text-white">Profil <span class="text-brand-neon">Saya</span></h1>
        <p class="text-gray-500 font-medium mt-1">Kelola informasi data diri dan kontak akun Anda.</p>
    </div>

    <form action="{{ route('dashboard.profile.update') }}" method="POST" class="space-y-6" novalidate>
        @csrf @method('PUT')
        
        <div class="stat-card space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Nama Lengkap <span class="text-brand-neon">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full input-metal rounded-2xl py-4 px-6 text-sm">
                    @error('name') <p class="text-brand-neon text-[10px]  mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Alamat Email <span class="text-brand-neon">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full input-metal rounded-2xl py-4 px-6 text-sm">
                    @error('email') <p class="text-brand-neon text-[10px]  mt-1 ml-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-white/5">
                <button type="submit" class="btn-metal py-4 px-10 rounded-xl font-black uppercase tracking-widest text-xs w-full md:w-auto">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
