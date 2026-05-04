@extends('layouts.frontend')

@section('title', 'Masuk -')

@section('main_class', 'min-h-[80vh] flex items-center justify-center p-4 md:p-6')

@section('hide_layout_elements', true)

@section('content')
<!-- Background Decoration -->
<div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-[radial-gradient(circle,rgba(225,29,72,0.1)_0%,transparent_70%)] -z-10 pointer-events-none"></div>

<div class="w-full max-w-lg" x-data="{ loading: false }">
    <!-- Logo Outside Card -->
    <div class="flex justify-center mb-8">
        <x-logo size="lg" fetchpriority="high" />
    </div>

    <!-- Card -->
    <div class="metal-card p-6 md:p-14 rounded-2xl relative overflow-hidden shadow-2xl">
        <!-- Glass Overlay -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-brand-red/5 blur-3xl rounded-full"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-black tracking-tighter metallic-text uppercase italic mb-2 text-center">Selamat Datang</h1>
            <p class="text-gray-500 text-sm font-medium mb-12 text-center">Masuk ke akun Anda untuk melanjutkan transaksi premium.</p>

            <form action="{{ route('login.post') }}" method="POST" @submit="loading = true" class="space-y-8">
                @csrf
                
                @if($errors->any())
                    <div class="bg-brand-red/10 border border-brand-red/20 text-brand-red text-[10px] p-4 rounded-2xl font-bold uppercase tracking-widest text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Email -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Alamat Email</label>
                    <div class="relative group">
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-red transition-colors pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" required placeholder="admin@ventuz.com" 
                            class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 pl-16 pr-6 text-sm font-medium focus:outline-none focus:border-brand-red/50 transition-all">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-3" x-data="{ show: false }">
                    <div class="flex items-center justify-between px-1">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Kata Sandi</label>
                        <a href="#" class="text-[10px] text-brand-red font-black uppercase tracking-widest hover:brightness-125">Lupa Password?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-red transition-colors pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" required placeholder="••••••••" 
                            class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 pl-16 pr-14 text-sm font-medium focus:outline-none focus:border-brand-red/50 transition-all">
                        <button type="button" @click="show = !show" class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition-colors">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.04m5.813-5.117A10.01 10.01 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.101-2.101L3 3m10 10a3 3 0 11-4.243-4.243" /></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center gap-3 px-1">
                    <input type="checkbox" name="remember" class="w-4 h-4 accent-brand-red rounded bg-white/5 border-white/10">
                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Ingat Perangkat Ini</span>
                </div>

                <!-- Submit -->
                <button type="submit" 
                    class="btn-metal w-full py-5 rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl flex items-center justify-center gap-3">
                    <span x-show="!loading">Masuk Sekarang</span>
                    <div x-show="loading" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                </button>
            </form>

            <div class="mt-12 pt-8 border-t border-white/5 text-center">
                <p class="text-gray-500 text-xs font-medium">Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-white font-bold hover:text-brand-red transition-colors">Daftar Akun</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
