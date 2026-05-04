@extends('layouts.frontend')

@section('title', 'Daftar -')

@section('main_class', 'min-h-[80vh] flex items-center justify-center p-4 md:p-6')

@section('hide_layout_elements', true)

@section('content')
<!-- Background Decoration -->
<div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-[radial-gradient(circle,rgba(225,29,72,0.1)_0%,transparent_70%)] -z-10 pointer-events-none"></div>

<div class="w-full max-w-2xl" x-data="{ loading: false }">
    <!-- Logo Outside Card -->
    <div class="flex justify-center mb-8">
        <x-logo size="lg" />
    </div>

    <!-- Card -->
    <div class="metal-card p-6 md:p-14 rounded-2xl relative overflow-hidden shadow-2xl">
        <!-- Glass Overlay -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-brand-red/5 blur-3xl rounded-full"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-black tracking-tighter metallic-text uppercase italic mb-2 text-center">Buat Akun</h1>
            <p class="text-gray-500 text-sm font-medium mb-12 text-center">Buat akun Anda dan mulai perjalanan top-up premium.</p>

            <form action="{{ route('register.post') }}" method="POST" @submit="loading = true" class="space-y-10">
                @csrf
                
                @if($errors->any())
                    <div class="bg-brand-red/10 border border-brand-red/20 text-brand-red text-[10px] p-4 rounded-2xl font-bold uppercase tracking-widest text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Nama Lengkap -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-red transition-colors pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="name" required placeholder="Nama Lengkap Anda" 
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 pl-16 pr-6 text-sm font-medium focus:outline-none focus:border-brand-red/50 transition-all">
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Username</label>
                        <div class="relative group">
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-red transition-colors pointer-events-none">
                                <span class="text-sm font-bold ml-0.5">@</span>
                            </div>
                            <input type="text" name="username" required placeholder="username" 
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 pl-16 pr-6 text-sm font-medium focus:outline-none focus:border-brand-red/50 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Alamat Email</label>
                    <div class="relative group">
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-red transition-colors pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" required placeholder="example@gmail.com" 
                            class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 pl-16 pr-6 text-sm font-medium focus:outline-none focus:border-brand-red/50 transition-all">
                    </div>
                </div>

                <!-- Nomor WhatsApp -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Nomor WhatsApp</label>
                    <div class="relative group">
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-red transition-colors pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input type="tel" name="whatsapp" required placeholder="0812xxxxxxxx" 
                            class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 pl-16 pr-6 text-sm font-medium focus:outline-none focus:border-brand-red/50 transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Password -->
                    <div class="space-y-3" x-data="{ show: false }">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Kata Sandi</label>
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

                    <!-- Konfirmasi Password -->
                    <div class="space-y-3" x-data="{ show: false }">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Konfirmasi</label>
                        <div class="relative group">
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-red transition-colors pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <input :type="show ? 'text' : 'password'" name="password_confirmation" required placeholder="••••••••" 
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-4 pl-16 pr-14 text-sm font-medium focus:outline-none focus:border-brand-red/50 transition-all">
                            <button type="button" @click="show = !show" class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition-colors">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.04m5.813-5.117A10.01 10.01 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.101-2.101L3 3m10 10a3 3 0 11-4.243-4.243" /></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Agreement -->
                <div class="flex items-start gap-3 px-1">
                    <input type="checkbox" required class="mt-1 accent-brand-red bg-white/5 border-white/10 rounded">
                    <p class="text-[10px] text-gray-500 leading-relaxed">Saya setuju dengan <a href="#" class="text-white hover:text-brand-red font-bold underline">Syarat & Ketentuan</a> serta <a href="#" class="text-white hover:text-brand-red font-bold underline">Kebijakan Privasi</a> Ventuz Store.</p>
                </div>

                <!-- Submit -->
                <button type="submit" 
                    class="btn-metal w-full py-5 rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl flex items-center justify-center gap-3">
                    <span x-show="!loading">Daftar Akun Sekarang</span>
                    <div x-show="loading" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                </button>
            </form>

            <div class="mt-12 pt-8 border-t border-white/5 text-center">
                <p class="text-gray-500 text-xs font-medium">Sudah menjadi member? 
                    <a href="{{ route('login') }}" class="text-white font-bold hover:text-brand-red transition-colors">Masuk Sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
