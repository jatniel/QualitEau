@props(['type' => 'text'])

@php
    // Type-specific classes
    $typeClasses = match ($type) {
        'text' => 'h-4 w-full rounded',
        'card' => 'h-32 w-full rounded-2xl',
        'circle' => 'h-12 w-12 rounded-full',
        default => 'h-4 w-full rounded',
    };

    // Base skeleton classes
    $baseClasses = "animate-pulse bg-slate-200 {$typeClasses}";
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }}></div>
