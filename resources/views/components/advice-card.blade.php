@props(['type', 'title', 'message'])

@php
    // Type-based colors and icons
    $typeConfig = match ($type) {
        'success' => [
            'bg' => 'bg-emerald-50',
            'border' => 'border-emerald-200',
            'icon' => 'text-emerald-500',
            'svg' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        ],
        'warning' => [
            'bg' => 'bg-amber-50',
            'border' => 'border-amber-200',
            'icon' => 'text-amber-500',
            'svg' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
        ],
        'alert' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'icon' => 'text-red-500',
            'svg' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        ],
        'info' => [
            'bg' => 'bg-sky-50',
            'border' => 'border-sky-200',
            'icon' => 'text-sky-500',
            'svg' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        ],
        'tip' => [
            'bg' => 'bg-cyan-50',
            'border' => 'border-cyan-200',
            'icon' => 'text-cyan-500',
            'svg' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>',
        ],
        default => [
            'bg' => 'bg-gray-50',
            'border' => 'border-gray-200',
            'icon' => 'text-gray-500',
            'svg' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        ],
    };
@endphp

<div {{ $attributes->merge(['class' => "bg-white rounded-2xl border-2 p-6 {$typeConfig['bg']} {$typeConfig['border']}"]) }}>
    <div class="flex">
        {{-- Icon --}}
        <div class="flex-shrink-0 {{ $typeConfig['icon'] }}">
            {!! $typeConfig['svg'] !!}
        </div>

        {{-- Content --}}
        <div class="ml-4">
            <h3 class="text-lg font-semibold text-slate-900 mb-1">
                {{ $title }}
            </h3>
            <p class="text-slate-700 leading-relaxed">
                {{ $message }}
            </p>
        </div>
    </div>
</div>
