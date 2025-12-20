@props(['label', 'value', 'unit', 'limit' => null, 'status', 'selected' => false])

@php
    // Status icon based on quality
    $iconSvg = match ($status->value) {
        'excellent' => '<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'good', 'soft' => '<svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'acceptable', 'hard' => '<svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
        'critical' => '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        default => '<svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
    };

    // Card classes
    $baseClasses = 'bg-white rounded-2xl border-2 p-4 text-left transition-all duration-200 hover:shadow-md hover:scale-105';
    $selectedClasses = $selected ? 'border-sky-500 ring-2 ring-sky-200' : 'border-slate-200';
@endphp

<button {{ $attributes->merge(['class' => "{$baseClasses} {$selectedClasses}", 'type' => 'button']) }}>
    {{-- Header with label and icon --}}
    <div class="flex items-start justify-between mb-3">
        <div class="text-xs font-medium text-slate-600 uppercase tracking-wide">
            {{ $label }}
        </div>
        <div>
            {!! $iconSvg !!}
        </div>
    </div>

    {{-- Value --}}
    <div class="mb-2">
        <span class="text-2xl font-bold text-slate-900">
            {{ number_format($value, 2, ',', ' ') }}
        </span>
        @if($unit)
            <span class="text-sm font-normal text-slate-500 ml-1">
                {{ $unit }}
            </span>
        @endif
    </div>

    {{-- Limit --}}
    @if($limit !== null)
        <div class="text-xs text-slate-500">
            Limite: {{ $limit }} {{ $unit }}
        </div>
    @endif
</button>
