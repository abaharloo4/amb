@props([
    'type' => 'text',
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'disabled' => false,
    'invalid' => false,
    'iconLeading' => null,
    'iconTrailing' => null,
])

@php
    $baseClasses = 'w-full bg-surface text-content-primary rounded-md px-3.5 py-2 text-sm transition-all duration-fast placeholder:text-content-disabled focus:outline-none focus:ring-2 focus:ring-brand-accent/70 disabled:opacity-50 disabled:bg-action-hover disabled:cursor-not-allowed';

    $borderClass = $invalid
        ? 'border border-status-error focus:border-status-error focus:ring-status-error/30'
        : 'border border-edge focus:border-brand-primary';

    $paddingLeading = $iconLeading ? 'ps-10' : '';
    $paddingTrailing = $iconTrailing ? 'pe-10' : '';
@endphp

<div class="relative flex items-center w-full">
    @if ($iconLeading)
        <div class="absolute start-3 pointer-events-none text-content-secondary">
            <x-ui.icon :name="$iconLeading" size="sm" />
        </div>
    @endif

    <input
        type="{{ $type }}"
        @if ($name) name="{{ $name }}" @endif
        @if ($value !== null) value="{{ $value }}" @endif
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => "{$baseClasses} {$borderClass} {$paddingLeading} {$paddingTrailing}"]) }}
    />

    @if ($iconTrailing)
        <div class="absolute end-3 pointer-events-none text-content-secondary">
            <x-ui.icon :name="$iconTrailing" size="sm" />
        </div>
    @endif
</div>
