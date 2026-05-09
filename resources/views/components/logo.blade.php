@props(['size' => 'md'])

@php
    $sizes = [
        'sm' => [
            'img' => 'h-10',
            'ventuz' => 'text-xl',
            'store' => 'text-[8px]',
            'gap' => 'gap-3',
            'line_w' => 'w-20',
            'line_h' => 'h-[1px]'
        ],
        'md' => [
            'img' => 'h-12',
            'ventuz' => 'text-2xl',
            'store' => 'text-[9px]',
            'gap' => 'gap-4',
            'line_w' => 'w-24',
            'line_h' => 'h-[1px]'
        ],
        'lg' => [
            'img' => 'h-16',
            'ventuz' => 'text-4xl',
            'store' => 'text-xs',
            'gap' => 'gap-6',
            'line_w' => 'w-32',
            'line_h' => 'h-[1.5px]'
        ],
        'xl' => [
            'img' => 'h-24',
            'ventuz' => 'text-6xl',
            'store' => 'text-sm',
            'gap' => 'gap-8',
            'line_w' => 'w-48',
            'line_h' => 'h-[2px]'
        ],
    ];

    $current = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center ' . $current['gap'] . ' group w-fit']) }}>
    <div class="relative shrink-0">
        @if(isset($webSettings['web_logo']))
            <img src="{{ asset('storage/' . $webSettings['web_logo']) }}" 
                alt="{{ $webSettings['web_title'] ?? 'Vincere Store' }}"
                {{ $attributes->only(['fetchpriority', 'loading']) }}
                class="{{ $current['img'] }} w-auto rounded-xl shadow-lg group-hover:scale-105 transition-transform duration-300 border border-white/10">
        @else
            <img src="{{ asset('assets/images-logo/logo.png') }}" 
                alt="Vincere Logo"
                {{ $attributes->only(['fetchpriority', 'loading']) }}
                class="{{ $current['img'] }} w-auto rounded-xl shadow-lg group-hover:scale-105 transition-transform duration-300 border border-white/10">
        @endif
        <div class="absolute inset-0 bg-brand-neon/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
    </div>
</div>
