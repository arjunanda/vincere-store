@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl space-y-8">
    <div>
        <h1 class="text-3xl font-black  uppercase tracking-tight text-white">Keamanan <span class="text-brand-neon">Akun</span></h1>
        <p class="text-gray-500 font-medium mt-1">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan.</p>
    </div>

    <form action="{{ route('dashboard.security.update') }}" method="POST" class="space-y-6">
        @csrf @method('PUT')
        
        <div class="stat-card space-y-6">
            <div class="grid grid-cols-1 gap-6 max-w-xl">
                <!-- Current Password -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Kata Sandi Saat Ini <span class="text-brand-neon">*</span></label>
                    <input type="password" name="current_password" required class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="••••••••">
                    @error('current_password') <p class="text-brand-neon text-[10px]  mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <!-- New Password -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Kata Sandi Baru <span class="text-brand-neon">*</span></label>
                    <input type="password" name="password" required class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="••••••••">
                    @error('password') <p class="text-brand-neon text-[10px]  mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Konfirmasi Kata Sandi Baru <span class="text-brand-neon">*</span></label>
                    <input type="password" name="password_confirmation" required class="w-full input-metal rounded-2xl py-4 px-6 text-sm" placeholder="••••••••">
                </div>
            </div>

            <div class="pt-4 border-t border-white/5">
                <button type="submit" class="btn-metal py-4 px-10 rounded-xl font-black uppercase tracking-widest text-xs w-full md:w-auto">
                    Perbarui Kata Sandi
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
