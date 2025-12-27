<div class="relative w-full max-w-2xl mx-auto">
    {{-- Search input with icon --}}
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
            {{-- Search icon --}}
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <input
            type="text"
            wire:model.live.debounce.150ms="query"
            placeholder="Rechercher votre commune..."
            class="w-full pl-12 pr-12 py-4 text-base text-slate-900 placeholder-slate-400 bg-white/80 backdrop-blur-xl border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all duration-200"
            autocomplete="off"
        >

        {{-- Loading spinner --}}
        <div wire:loading class="absolute inset-y-0 right-0 flex items-center pr-4">
            <svg class="w-5 h-5 text-sky-500 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    {{-- Helper text --}}
    <p class="mt-2 text-sm text-slate-500 text-center">
        Entrez le nom de votre commune ou son code INSEE (ex: 40088 pour Dax, différent du code postal)
    </p>

    {{-- Search results dropdown --}}
    @if($showResults && strlen($query) >= 2)
        <div
            class="absolute z-50 w-full mt-2 bg-white/95 backdrop-blur-xl border border-slate-200 rounded-2xl shadow-xl overflow-hidden"
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-1"
        >
            @if(count($this->results) > 0)
                <ul class="max-h-80 overflow-y-auto">
                    @foreach($this->results as $commune)
                        <li>
                            <button
                                type="button"
                                wire:click="selectCommune(@js($commune['code_commune']), @js($commune['nom_commune']))"
                                class="w-full px-4 py-3 flex items-center justify-between hover:bg-sky-50 transition-colors duration-150 group"
                            >
                                <div class="flex-1 text-left">
                                    <div class="font-medium text-slate-900">
                                        {{ $commune['nom_commune'] }}
                                    </div>
                                    <div class="text-sm text-slate-500">
                                        ({{ $commune['code_commune'] }})
                                    </div>
                                </div>

                                {{-- Arrow icon --}}
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-sky-500 transition-colors duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="px-4 py-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-slate-500 font-medium">
                        Aucune commune trouvée
                    </p>
                    <p class="text-sm text-slate-400 mt-1">
                        Essayez avec un autre nom ou code INSEE
                    </p>
                </div>
            @endif
        </div>
    @endif
</div>
