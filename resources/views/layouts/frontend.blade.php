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

    <!-- Resource Hints -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">

    <!-- JSON-LD Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "{{ $webSettings['web_title'] ?? 'Ventuz Store' }}",
      "url": "{{ url('/') }}",
      "logo": "{{ isset($webSettings['web_logo']) ? asset('storage/' . $webSettings['web_logo']) : asset('assets/img/logo.png') }}",
      "description": "{{ $webSettings['web_description'] ?? '' }}",
      "address": {
        "@@type": "PostalAddress",
        "addressCountry": "ID"
      },
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "{{ $webSettings['contact_wa'] ?? '' }}",
        "contactType": "customer service"
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "WebSite",
      "url": "{{ url('/') }}",
      "potentialAction": {
        "@@type": "SearchAction",
        "target": "{{ url('/games') }}?search={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>

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
            background: #2A2F3A !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
            overflow: hidden;
            border-radius: 12px;
        }

        .metal-card:hover {
            transform: translateY(-4px);
            border-color: rgba(124, 255, 0, 0.4) !important;
            box-shadow: 0 10px 30px rgba(124, 255, 0, 0.1);
        }

        .section-header {
            background: rgba(42, 47, 58, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 12px 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, #7CFF00, transparent);
            opacity: 0.3;
        }

        .item-title {
            color: #FFFFFF;
            transition: all 0.3s ease;
        }

        .group:hover .item-title {
            color: #7CFF00 !important;
        }

        .premium-glow {
            box-shadow: 0 0 40px rgba(124, 255, 0, 0.1);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .float-icon {
            animation: float 4s ease-in-out infinite;
        }

        .btn-metal {
            background: #7CFF00;
            color: #000;
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
            background: #7CFF00;
            border-radius: 10px;
        }

        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 50;
        }

        .cs-main-btn {
            background: #7CFF00;
            color: #000;
            padding: 12px 24px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(124, 255, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .cs-main-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(124, 255, 0, 0.3);
        }

        .cs-main-btn.active {
            background: #1A1A1A;
            color: #7CFF00;
            border-color: rgba(124, 255, 0, 0.3);
        }

        .cs-menu-item {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            background: #1A1A1A;
        }

        .cs-menu-item:hover {
            transform: scale(1.05);
            border-color: #7CFF00;
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
            color: #7CFF00;
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

<body class="bg-[#050505] text-white selection:bg-brand-neon selection:text-white overflow-x-hidden"
    @yield('body_attr')>
    @unless(View::hasSection('hide_layout_elements'))
        @include('layouts.partials.navbar')
    @endunless

    <main class="@yield('main_class', 'max-w-7xl mx-auto px-6 py-12')">
        @yield('content')
    </main>

    @unless(View::hasSection('hide_layout_elements'))
        @include('layouts.partials.footer')
    @endunless

    @stack('scripts')
</body>

</html>