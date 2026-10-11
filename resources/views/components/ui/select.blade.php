@props([
    'name' => null,
    'disabled' => false,
    'invalid' => false,
])

@php
    $baseClasses = 'w-full bg-surface text-content-primary rounded-md px-3.5 py-2 text-sm transition-all duration-fast focus:outline-none focus:ring-2 focus:ring-brand-accent/70 disabled:opacity-50 disabled:bg-action-hover disabled:cursor-not-allowed';

    $borderClass = $invalid
        ? 'border border-status-error focus:border-status-error focus:ring-status-error/30'
        : 'border border-edge focus:border-brand-primary';
@endphp

<select
    @if ($name) name="{{ $name }}" @endif
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => "{$baseClasses} {$borderClass}"]) }}
>
    {{ $slot }}
</select>
