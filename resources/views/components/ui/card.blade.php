@props([
    'variant' => 'default',
    'interactive' => false,
])

@php
    $baseClasses = 'rounded-lg transition-all duration-normal';

    $variants = [
        'default' => 'bg-surface border border-edge shadow-sm',
        'elevated' => 'bg-elevated border border-edge-strong shadow-md',
        'outlined' => 'bg-transparent border border-edge',
    ];

    $interactiveClass = $interactive
        ? 'hover:-translate-y-1 hover:shadow-lg hover:border-brand-accent/40 cursor-pointer'
        : '';

    $variantClass = $variants[$variant] ?? $variants['default'];
    $classes = "{$baseClasses} {$variantClass} {$interactiveClass}";
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
