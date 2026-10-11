@props([
    'name',
    'size' => 'md',
    'label' => null,
    'mirrorRtl' => null,
    'class' => '',
])

@php
    $sizes = [
        'xs' => 'w-3.5 h-3.5',
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
        'xl' => 'w-8 h-8',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];

    // Directional icons that automatically flip in RTL
    $directionalIcons = [
        'arrow-right', 'arrow-left', 'arrow-up-right',
        'chevron-right', 'chevron-left',
        'external-link', 'quote', 'send', 'pencil', 'file-text'
    ];

    $shouldMirror = $mirrorRtl ?? in_array($name, $directionalIcons);
    $mirrorClass = $shouldMirror ? 'rtl:-scale-x-100 transition-transform' : '';
@endphp

<svg
    {{ $attributes->merge([
        'class' => "inline-block shrink-0 fill-current {$sizeClass} {$mirrorClass} {$class}",
        'aria-hidden' => $label ? 'false' : 'true',
        'role' => $label ? 'img' : 'presentation',
        'aria-label' => $label,
        'focusable' => 'false'
    ]) }}
>
    <use href="#icon-{{ $name }}"></use>
</svg>
