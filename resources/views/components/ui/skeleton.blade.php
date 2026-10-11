@props([
    'shape' => 'text',
    'class' => '',
])

@php
    $baseClasses = 'animate-pulse bg-action-hover rounded';

    $shapes = [
        'text' => 'h-4 w-3/4 rounded-sm',
        'heading' => 'h-7 w-1/2 rounded-md',
        'avatar' => 'h-10 w-10 rounded-full',
        'button' => 'h-10 w-28 rounded-md',
        'card' => 'h-40 w-full rounded-lg',
    ];

    $shapeClass = $shapes[$shape] ?? $shapes['text'];
    $classes = "{$baseClasses} {$shapeClass} {$class}";
@endphp

<div {{ $attributes->merge(['class' => $classes]) }} aria-hidden="true"></div>
