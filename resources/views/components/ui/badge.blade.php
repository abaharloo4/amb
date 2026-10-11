@props([
    'tone' => 'neutral',
    'size' => 'md',
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center font-medium rounded-full';

    $tones = [
        'neutral' => 'bg-action-hover text-content-secondary border border-edge',
        'brand' => 'bg-brand/10 text-brand-primary border border-brand/20 dark:bg-brand/20 dark:text-content-primary',
        'accent' => 'bg-brand-accent/15 text-brand-accent border border-brand-accent/30 font-semibold',
        'success' => 'bg-status-success/15 text-status-success border border-status-success/30',
        'warning' => 'bg-status-warning/15 text-status-warning border border-status-warning/30',
        'error' => 'bg-status-error/15 text-status-error border border-status-error/30',
        'info' => 'bg-status-info/15 text-status-info border border-status-info/30',
    ];

    $sizes = [
        'sm' => 'text-[11px] px-2 py-0.5 gap-1',
        'md' => 'text-xs px-2.5 py-1 gap-1.5',
    ];

    $toneClass = $tones[$tone] ?? $tones['neutral'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $classes = "{$baseClasses} {$toneClass} {$sizeClass}";
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
        <x-ui.icon :name="$icon" size="xs" />
    @endif
    <span>{{ $slot }}</span>
</span>
