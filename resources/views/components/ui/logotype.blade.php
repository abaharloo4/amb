@props([
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'text-lg',
        'md' => 'text-2xl',
        'lg' => 'text-3xl',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => "inline-flex items-center font-bold tracking-tight font-mono select-none {$sizeClass}"]) }}>
    <span class="text-brand-primary dark:text-white transition-colors duration-normal">AMB</span>
    <span class="w-1.5 h-1.5 rounded-full bg-brand-accent ms-1 inline-block animate-pulse"></span>
</div>
