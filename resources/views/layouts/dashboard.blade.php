<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $webSettings['web_title'] ?? 'Ventuz Store - Dashboard' }}</title>
    @if(isset($webSettings['web_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $webSettings['web_favicon']) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;

            const icon = type === 'success' ?
                `<div class="w-8 h-8 rounded-full bg-brand-red/10 flex items-center justify-center text-brand-red">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                </div>` :
                `<div class="w-8 h-8 rounded-full bg-red-500/10 flex items-center justify-center text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>`;

            toast.innerHTML = `
                ${icon}
                <div class="flex-1">
                    <p class="text-[10px] font-black uppercase tracking-[0.15em] text-white">${message}</p>
                </div>
            `;

            container.appendChild(toast);

            // Auto remove
            setTimeout(() => {
                toast.style.animation = 'toast-out 0.4s ease forwards';
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }
    </script>
</head>

<body class="dashboard-layout" x-data="{ sidebarOpen: false }" @close-sidebar.window="sidebarOpen = false">

    <!-- Sidebar Overlay (Mobile) -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden" x-transition:fade></div>

    <!-- Sidebar -->
    <aside class="sidebar" :class="sidebarOpen ? 'open' : ''">
        <div class="p-8 border-b border-white/5 flex items-center justify-between">
            <x-logo size="sm" />
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 py-8 overflow-y-auto custom-scrollbar">
            <!-- Common Menus -->
            <div class="px-6 mb-6">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 ml-4">Navigasi</p>
            </div>

            <a href="{{ route('dashboard.index') }}"
                class="sidebar-item {{ Route::is('dashboard.index') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Ringkasan
            </a>

            @if(auth()->user() && auth()->user()->role === 'admin')
                <!-- Admin Specific Menus -->
                <div class="px-6 mt-10 mb-6">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 ml-4">Manajemen Konten</p>
                </div>

                <a href="{{ route('dashboard.games') }}"
                    class="sidebar-item {{ Route::is('dashboard.games*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Kelola Game
                </a>
                <a href="{{ route('dashboard.categories.index') }}"
                    class="sidebar-item {{ Route::is('dashboard.categories.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Master Kategori
                </a>
                <a href="{{ route('dashboard.inputs') }}"
                    class="sidebar-item {{ Route::is('dashboard.inputs') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13l-3 3m0 0l-3-3m3 3V8" />
                    </svg>
                    Master Input
                </a>
                <a href="{{ route('dashboard.banners') }}"
                    class="sidebar-item {{ Route::is('dashboard.banners') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Kelola Banner
                </a>
                <a href="{{ route('dashboard.articles') }}"
                    class="sidebar-item {{ Route::is('dashboard.articles') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v4a2 2 0 002 2h4" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h3" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12h8" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16h8" />
                    </svg>
                    Kelola Artikel
                </a>

                <div class="px-6 mt-10 mb-6">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 ml-4">Transaksi & Keuangan</p>
                </div>

                <a href="{{ route('dashboard.orders') }}"
                    class="sidebar-item {{ Route::is('dashboard.orders') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Semua Pesanan
                </a>
                <a href="{{ route('dashboard.payments') }}"
                    class="sidebar-item {{ Route::is('dashboard.payments') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Metode Bayar
                </a>

                <!-- System Specific Menus -->
                <div class="px-6 mt-10 mb-6">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 ml-4">Sistem & Keamanan</p>
                </div>
                <a href="{{ route('dashboard.users') }}"
                    class="sidebar-item {{ Route::is('dashboard.users') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Kelola User
                </a>
                <a href="{{ route('dashboard.logs') }}"
                    class="sidebar-item {{ Route::is('dashboard.logs') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Aktivitas
                </a>
            @else
                <!-- User Specific Menus -->
                <a href="{{ route('dashboard.my-orders') }}"
                    class="sidebar-item {{ Route::is('dashboard.my-orders') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Pesanan Saya
                </a>
            @endif

            <div class="px-6 mt-10 mb-6">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 ml-4">Akun</p>
            </div>

            <a href="{{ route('dashboard.profile') }}"
                class="sidebar-item {{ Route::is('dashboard.profile') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Profil
            </a>

            <a href="{{ route('dashboard.security') }}"
                class="sidebar-item {{ Route::is('dashboard.security') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Keamanan
            </a>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard.settings') }}"
                    class="sidebar-item {{ Route::is('dashboard.settings') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan
                </a>
            @endif
        </nav>

        <div class="p-6 border-t border-white/[0.06]">
            <div class="flex items-center gap-2.5">

                {{-- Avatar --}}
                <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center
                    text-[12px] font-semibold text-white shrink-0 tracking-wide">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-medium text-white/80 truncate leading-tight">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-[11px] text-white/30 truncate leading-snug">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                {{-- Logout button (icon only) --}}
                <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" class="w-[30px] h-[30px] rounded-lg border border-white/[0.08] bg-transparent
                       flex items-center justify-center text-white/25
                       hover:bg-red-500/10 hover:text-red-400 hover:border-red-500/20
                       transition-all duration-150">
                        <svg class="w-[15px] h-[15px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>

            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                @if(session('success'))
                    showToast('{{ session('success') }}', 'success');
                @endif
                @if(session('error'))
                    showToast('{{ session('error') }}', 'error');
                @endif
            });
        </script>

        <!-- Top Bar Mobile -->
        <header
            class="flex items-center justify-between mb-8 lg:hidden bg-brand-dark/50 backdrop-blur-md p-4 -mx-4 border-b border-white/5 sticky top-0 z-40">
            <x-logo size="xs" />
            <button @click="sidebarOpen = true"
                class="p-2 bg-brand-red rounded-lg text-white shadow-lg shadow-brand-red/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </header>

        <!-- Dynamic Content -->
        @yield('content')
    </main>

    <!-- SPA Navigation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mainContent = document.querySelector('.main-content');

            document.body.addEventListener('click', async (e) => {
                if (e.defaultPrevented) return; // Allow other scripts to prevent navigation

                const link = e.target.closest('a');
                if (!link) return;

                const url = link.getAttribute('href');

                // Intercept only internal dashboard GET links
                if (!url || url.startsWith('#') || url.startsWith('javascript:') || link.target === '_blank' || !url.startsWith(window.location.origin + '/dashboard')) {
                    return;
                }

                // Allow new tab actions
                if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;

                e.preventDefault();

                mainContent.style.opacity = '0.3';
                mainContent.style.transition = 'opacity 0.2s ease';

                try {
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    });

                    // If it redirects (e.g. login), follow normal navigation
                    if (response.redirected) {
                        window.location.href = response.url;
                        return;
                    }

                    const html = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Replace main content
                    const newMain = doc.querySelector('.main-content');
                    if (newMain) {
                        mainContent.innerHTML = newMain.innerHTML;
                    }

                    // Update Page Title
                    if (doc.title) document.title = doc.title;

                    // Update Sidebar Active Links
                    document.querySelectorAll('.sidebar-item').forEach(el => {
                        el.classList.remove('active');
                        // Exact match or sub-route logic
                        if (url.includes(el.getAttribute('href')) && el.getAttribute('href') !== window.location.origin + '/dashboard') {
                            el.classList.add('active');
                        } else if (url === el.getAttribute('href')) {
                            el.classList.add('active');
                        }
                    });

                    // Update Browser URL
                    history.pushState(null, '', url);

                    // Scroll to top
                    window.scrollTo(0, 0);

                    // Dispatch event to close sidebar on mobile (caught by Alpine)
                    window.dispatchEvent(new Event('close-sidebar'));

                    // Re-evaluate newly injected scripts
                    const scripts = mainContent.querySelectorAll('script');
                    scripts.forEach(script => {
                        const newScript = document.createElement('script');
                        Array.from(script.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                        newScript.appendChild(document.createTextNode(script.innerHTML));
                        script.parentNode.replaceChild(newScript, script);
                    });

                } catch (error) {
                    console.error('SPA Load Error:', error);
                    window.location.href = url; // Fallback to normal loading on error
                } finally {
                    mainContent.style.opacity = '1';
                }
            });

            // Handle Browser Back/Forward buttons smoothly
            window.addEventListener('popstate', () => {
                window.location.reload();
            });

            // Global Form Submit Loading Handler
            document.addEventListener('submit', (e) => {
                const form = e.target;
                const submitBtn = form.querySelector('button[type="submit"]');

                if (submitBtn && !submitBtn.hasAttribute('data-no-loading')) {
                    // Prevent double clicks
                    if (submitBtn.classList.contains('btn-loading')) {
                        e.preventDefault();
                        return;
                    }

                    submitBtn.classList.add('btn-loading');

                    // If button doesn't have btn-text wrapper, wrap content to hide it
                    if (!submitBtn.querySelector('.btn-text')) {
                        const originalContent = submitBtn.innerHTML;
                        submitBtn.innerHTML = `<span class="btn-text">${originalContent}</span>`;
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>