<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="{{ $webSettings['web_description'] ?? 'Ventuz Store - Platform top-up game dan voucher murah terpercaya di Indonesia.' }}">
    <meta name="keywords"
        content="{{ $webSettings['web_keywords'] ?? 'top up game, voucher game murah, top up mlbb murah, top up ff murah, voucher valorant, ventuz store, top up game instan' }}">
    <meta name="author" content="{{ $webSettings['web_author'] ?? 'Ventuz Store Team' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title') {{ $webSettings['web_title'] ?? 'Ventuz Store' }}">
    <meta property="og:description"
        content="{{ $webSettings['web_description'] ?? 'Ventuz Store - Platform top-up game dan voucher murah terpercaya di Indonesia.' }}">
    @if(isset($webSettings['web_og_image']))
        <meta property="og:image" content="{{ asset('storage/' . $webSettings['web_og_image']) }}">
    @endif

    <title>
        @hasSection('title')
            @yield('title') {{ 'Ventuz Store' }}
        @else
            {{ $webSettings['web_title'] ?? 'Ventuz Store - Top-up Game & Voucher Murah Instan 24 Jam' }}
        @endif
    </title>
    @if(isset($webSettings['web_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $webSettings['web_favicon']) }}">
    @endif

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .metal-card {
            display: block;
            background: #0f0f0f !important;
            background: linear-gradient(145deg, #121212, #080808) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .metal-card:hover {
            transform: translateY(-10px);
            border-color: #e11d48 !important;
            background: #151515 !important;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.9), 0 0 30px rgba(225, 29, 72, 0.15);
        }

        .item-title {
            background: linear-gradient(to bottom, #ffffff, rgba(255, 255, 255, 0.7));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
        }

        .group:hover .item-title {
            background: none !important;
            -webkit-text-fill-color: #e11d48 !important;
            color: #e11d48 !important;
        }

        .premium-glow {
            box-shadow: 0 0 40px rgba(225, 29, 72, 0.2);
        }

        .btn-metal {
            background: linear-gradient(135deg, #e11d48 0%, #9f1239 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .custom-scrollbar::-webkit-scrollbar {
            height: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e11d48;
            border-radius: 10px;
        }

        .metallic-text {
            background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 25%, #4b5563 50%, #a1a1aa 75%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: shine 8s linear infinite;
        }

        @keyframes shine {
            to {
                background-position: 200% center;
            }
        }

        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 50;
        }

        .cs-main-btn {
            background: linear-gradient(135deg, #e11d48 0%, #9f1239 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(225, 29, 72, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .cs-main-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(225, 29, 72, 0.4);
        }

        .cs-main-btn.active {
            background: #111;
            border-color: rgba(255, 255, 255, 0.1);
        }

        .cs-menu-item {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .cs-ig {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        }

        .cs-wa {
            background: #25D366;
        }

        .cs-menu-item:hover {
            transform: scale(1.1);
        }

        .whatsapp-pulse {
            position: absolute;
            inset: -4px;
            background: #e11d48;
            border-radius: 18px;
            z-index: -1;
            animation: pulse-wa 2s infinite;
            opacity: 0;
        }

        @keyframes pulse-wa {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }

            100% {
                transform: scale(1.3);
                opacity: 0;
            }
        }

        /* Status Stamps */
        .stamp {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            padding: 10px 20px;
            font-family: sans-serif;
            font-size: 2.5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 5px;
            border-radius: 12px;
            opacity: 0.15;
            pointer-events: none;
            z-index: 50;
            white-space: nowrap;
            border: 6px double currentColor;
        }

        .stamp-success {
            color: #10b981;
        }

        .stamp-failed {
            color: #ef4444;
        }

        .status-pill {
            padding: 4px 12px;
            border-radius: 9999px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#050505] text-white selection:bg-brand-red selection:text-white overflow-x-hidden" @yield('body_attr')>
    @include('layouts.partials.navbar')

    <main class="@yield('main_class', 'max-w-7xl mx-auto px-6 py-12')">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @stack('scripts')
</body>

</html>