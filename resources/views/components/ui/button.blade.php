@props([
    'variant' => 'primary',
    'size' => 'md',
    'as' => 'button',
    'type' => 'button',
    'iconLeading' => null,
    'iconTrailing' => null,
    'loading' => false,
    'disabled' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-fast select-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2';

    $variants = [
        'primary' => 'bg-brand text-white hover:opacity-90 active:scale-[0.98] shadow-sm',
        'accent' => 'bg-brand-accent text-[#1F1F1F] font-semibold hover:brightness-105 active:scale-[0.98] shadow-sm',
        'secondary' => 'bg-brand-secondary text-white hover:opacity-90 active:scale-[0.98] shadow-sm',
        'outline' => 'border border-edge text-content-primary hover:bg-action-hover active:scale-[0.98]',
        'ghost' => 'text-content-primary hover:bg-action-hover active:scale-[0.98]',
        'danger' => 'bg-status-error text-white hover:opacity-90 active:scale-[0.98] shadow-sm',
    ];

    $sizes = [
        'sm' => 'text-xs px-2.5 py-1.5 rounded-sm gap-1.5 min-h-[32px]',
        'md' => 'text-sm px-4 py-2 rounded-md gap-2 min-h-[40px]',
        'lg' => 'text-base px-6 py-2.5 rounded-lg gap-2.5 min-h-[48px]',
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $classes = "{$baseClasses} {$variantClass} {$sizeClass}";
@endphp

@if ($as === 'a')
    <a {{ $attributes->merge(['class' => $classes]) }}>
        @if ($loading)
            <x-ui.icon name="loader-2" class="animate-spin" />
        @elseif ($iconLeading)
            <x-ui.icon :name="$iconLeading" />
        @endif

        <span>{{ $slot }}</span>

        @if ($iconTrailing && !$loading)
            <x-ui.icon :name="$iconTrailing" />
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $disabled || $loading ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if ($loading)
            <x-ui.icon name="loader-2" class="animate-spin" />
        @elseif ($iconLeading)
            <x-ui.icon :name="$iconLeading" />
        @endif

        <span>{{ $slot }}</span>

        @if ($iconTrailing && !$loading)
            <x-ui.icon :name="$iconTrailing" />
        @endif
    </button>
@endif
