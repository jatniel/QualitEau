@props(['grade', 'size' => 'md'])

@php
    // Size classes
    $boxSize = match ($size) {
        'sm' => 'w-12 h-12 text-lg',
        'md' => 'w-16 h-16 text-2xl',
        'lg' => 'w-20 h-20 text-3xl',
        default => 'w-16 h-16 text-2xl',
    };

    // Grade definitions with colors and labels
    $grades = [
        'A' => ['color' => 'emerald', 'label' => 'Excellente'],
        'B' => ['color' => 'sky', 'label' => 'Bonne'],
        'C' => ['color' => 'amber', 'label' => 'Acceptable'],
        'D' => ['color' => 'orange', 'label' => 'Médiocre'],
        'E' => ['color' => 'red', 'label' => 'Non conforme'],
    ];
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col items-center']) }}>
    {{-- Grade boxes --}}
    <div class="flex gap-2">
        @foreach($grades as $letter => $info)
            @php
                $isActive = $grade === $letter;
                $color = $info['color'];
            @endphp
            <div class="relative {{ $isActive ? 'scale-110 z-10' : 'opacity-40' }} transition-all duration-200">
                <div class="
                    {{ $boxSize }}
                    flex items-center justify-center
                    font-bold
                    rounded-xl
                    {{ $isActive ? 'bg-' . $color . '-500 text-white shadow-xl' : 'bg-' . $color . '-100 text-' . $color . '-700' }}
                ">
                    {{ $letter }}
                </div>
            </div>
        @endforeach
    </div>

    {{-- Active grade label --}}
    @if(isset($grades[$grade]))
        <div class="mt-4 text-center">
            <p class="text-lg font-semibold text-slate-900">
                Qualité {{ $grades[$grade]['label'] }}
            </p>
        </div>
    @endif
</div>
