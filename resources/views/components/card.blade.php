@props(['hover' => false, 'padding' => 'md'])

@php
    // Padding classes
    $paddingClasses = match ($padding) {
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
        'none' => '',
        default => 'p-6',
    };

    // Hover classes
    $hoverClasses = $hover ? 'hover:shadow-md hover:border-slate-300 cursor-pointer transition-all duration-200' : '';

    // Base card classes
    $baseClasses = "bg-white rounded-2xl border border-slate-200 shadow-sm {$paddingClasses} {$hoverClasses}";
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</div>
