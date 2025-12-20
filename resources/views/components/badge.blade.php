@props(['status', 'size' => 'md'])

@php
    // Size classes
    $sizeClasses = match ($size) {
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-4 py-2 text-base',
        default => 'px-3 py-1.5 text-sm',
    };

    // Get semantic color from enum
    $color = $status->color();
    
    // Construct alpha-based classes
    // We use semantic colors defined in app.css (safe, pure, caution, contaminated, mist)
    // We rely on the app.css @theme definition making these available as utilities
    $bgClass = "bg-{$color}/10";
    $textClass = "text-{$color}";
    $borderClass = "border-{$color}/20";
    
    // Safelist hack to ensure JIT picks them up if they aren't scanning this dynamic string
    // @see https://tailwindcss.com/docs/content-configuration#dynamic-class-names
    $safelist = match($color) {
        'safe' => 'bg-safe/10 text-safe border-safe/20',
        'pure' => 'bg-pure/10 text-pure border-pure/20',
        'caution' => 'bg-caution/10 text-caution border-caution/20',
        'contaminated' => 'bg-contaminated/10 text-contaminated border-contaminated/20',
        'mist' => 'bg-mist/10 text-mist border-mist/20',
        default => '',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-medium rounded-lg border {$sizeClasses} {$bgClass} {$textClass} {$borderClass}"]) }}>
    {{ $slot }}
</span>
