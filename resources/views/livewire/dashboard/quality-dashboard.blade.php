<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white">
    {{-- Sticky header --}}
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Back button --}}
                <a href="{{ route('home') }}" wire:navigate class="flex items-center text-slate-600 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="font-medium">Retour</span>
                </a>

                {{-- Logo --}}
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-sky-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-2xl font-bold bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent">
                        QualitEau
                    </span>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Commune info & Grade section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
                {{-- Commune name --}}
                <div class="mb-6">
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-2">
                        {{ $this->summary['commune']['nom'] }}
                    </h1>
                    <p class="text-slate-500">
                        Code commune: {{ $this->summary['commune']['code'] }}
                        @if($this->summary['commune']['reseau'])
                            · Réseau: {{ $this->summary['commune']['reseau'] }}
                        @endif
                    </p>
                </div>

                {{-- Nutri-Score style grade display --}}
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-slate-700 mb-4">Qualité globale de l'eau</h2>
                    <div class="flex flex-wrap gap-2">
                        @once
                            <style>
                                @keyframes wave-slide {
                                    0% { transform: translateX(0); }
                                    100% { transform: translateX(-50%); }
                                }
                                .wave-container {
                                    width: 200%;
                                    position: absolute;
                                    bottom: 0;
                                    left: 0;
                                    height: 100%;
                                }
                                .animate-wave-slow {
                                    animation: wave-slide 12s linear infinite;
                                }
                                .animate-wave-fast {
                                    animation: wave-slide 7s linear infinite;
                                }
                            </style>
                        @endonce
                        
                        @foreach(['A', 'B', 'C', 'D', 'E'] as $grade)
                            @php
                                $isActive = $this->summary['grade'] === $grade;
                                $color = $this->getGradeColor($grade);
                                
                                // Explicit class mapping
                                $textClass = match($color) {
                                    'green' => 'text-green-700',
                                    'blue' => 'text-blue-700',
                                    'yellow' => 'text-yellow-700',
                                    'orange' => 'text-orange-700',
                                    'red' => 'text-red-700',
                                    default => 'text-slate-700',
                                };
                                $activeTextClass = match($color) {
                                    'green' => 'text-green-900',
                                    'blue' => 'text-blue-900',
                                    'yellow' => 'text-yellow-900',
                                    'orange' => 'text-orange-900',
                                    'red' => 'text-red-900',
                                    default => 'text-slate-900',
                                };
                                $ringClass = match($color) {
                                    'green' => 'ring-green-500',
                                    'blue' => 'ring-blue-500',
                                    'yellow' => 'ring-yellow-500',
                                    'orange' => 'ring-orange-500',
                                    'red' => 'ring-red-500',
                                    default => 'ring-slate-500',
                                };
                                $inactiveBgClass = match($color) {
                                    'green' => 'bg-green-100',
                                    'blue' => 'bg-blue-100',
                                    'yellow' => 'bg-yellow-100',
                                    'orange' => 'bg-orange-100',
                                    'red' => 'bg-red-100',
                                    default => 'bg-slate-100',
                                };
                                $fillClass = match($color) {
                                    'green' => 'fill-green-500',
                                    'blue' => 'fill-blue-500',
                                    'yellow' => 'fill-yellow-500',
                                    'orange' => 'fill-orange-500',
                                    'red' => 'fill-red-500',
                                    default => 'fill-slate-500',
                                };
                                $lightFillClass = match($color) {
                                    'green' => 'fill-green-300',
                                    'blue' => 'fill-blue-300',
                                    'yellow' => 'fill-yellow-300',
                                    'orange' => 'fill-orange-300',
                                    'red' => 'fill-red-300',
                                    default => 'fill-slate-300',
                                };
                            @endphp
                            <div class="flex-1 min-w-[60px]">
                                <div class="
                                    relative overflow-hidden
                                    rounded-xl p-4 text-center transition-all duration-200 h-16 flex items-center justify-center
                                    {{ $isActive ? 'shadow-md ring-2 ring-offset-2 ' . $ringClass : $inactiveBgClass }}
                                ">
                                    @if($isActive)
                                        {{-- Slow Wave (Background) --}}
                                        <div class="wave-container animate-wave-slow opacity-60">
                                            <svg viewBox="0 0 1440 320" preserveAspectRatio="none" class="w-full h-full {{ $lightFillClass }}">
                                                <path d="M0,160L48,170.7C96,181,192,203,288,202.7C384,203,480,181,576,181.3C672,181,768,203,864,197.3C960,192,1056,160,1152,154.7C1248,149,1344,171,1392,181.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                                            </svg>
                                        </div>

                                        {{-- Fast Wave (Foreground) --}}
                                        <div class="wave-container animate-wave-fast">
                                            <svg viewBox="0 0 1440 320" preserveAspectRatio="none" class="w-full h-full {{ $fillClass }}">
                                                <path d="M0,192L48,176C96,160,192,128,288,138.7C384,149,480,203,576,213.3C672,224,768,192,864,170.7C960,149,1056,139,1152,149.3C1248,160,1344,192,1392,208L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="relative z-10 text-2xl font-bold {{ $isActive ? 'text-blue-700' : $textClass }}">
                                        {{ $grade }}
                                    </div>
                                </div>
                                @if($isActive)
                                    <div class="text-center mt-2 text-sm font-medium text-slate-700">
                                        {{ $this->getGradeLabel($grade) }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Score and last update --}}
                <div class="flex items-center justify-between text-sm text-slate-500 mt-6 pt-6 border-t border-slate-100">
                    <div>
                        Score global: <span class="font-semibold text-slate-700">{{ $this->summary['score'] }}/100</span>
                    </div>
                    @if($this->summary['last_update'])
                        <div>
                            Dernière analyse: {{ \Carbon\Carbon::parse($this->summary['last_update'])->format('d/m/Y') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Parameters grid --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-4">Paramètres analysés</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($this->mainParameters as $param)
                    @php
                        $isSelected = $selectedParameter === $param['code'];
                    @endphp
                    <button
                        type="button"
                        wire:click="selectParameter('{{ $param['code'] }}')"
                        class="
                            bg-white rounded-2xl border-2 p-4 text-left transition-all duration-200 hover:shadow-md
                            {{ $isSelected ? 'border-sky-500 ring-2 ring-sky-200' : 'border-slate-200 hover:border-slate-300' }}
                        "
                    >
                        {{-- Status icon --}}
                        <div class="mb-3">
                            @if($param['status']->value === 'excellent')
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @elseif(in_array($param['status']->value, ['good', 'soft']))
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                </svg>
                            @elseif(in_array($param['status']->value, ['acceptable', 'hard']))
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>

                        {{-- Parameter name --}}
                        <div class="text-xs font-medium text-slate-600 mb-1">
                            {{ $param['name'] }}
                        </div>

                        {{-- Value --}}
                        <div class="text-lg font-bold text-slate-900 mb-1">
                            {{ number_format($param['value'], 2, ',', ' ') }}
                            @if($param['unit'])
                                <span class="text-sm font-normal text-slate-500">{{ $param['unit'] }}</span>
                            @endif
                        </div>

                        {{-- Limit --}}
                        @if($param['limit'] !== null)
                            <div class="text-xs text-slate-500">
                                Limite: {{ $param['limit'] }} {{ $param['unit'] }}
                            </div>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Chart section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">
                    Évolution sur 12 mois
                    @if($selectedParameter)
                        @php
                            $param = \App\Enums\WaterParameter::fromCode($selectedParameter);
                        @endphp
                        - {{ $param?->label() }}
                    @endif
                </h2>

                {{-- Chart placeholder --}}
                {{-- Chart implementation --}}
                <div
                    wire:key="chart-{{ $selectedParameter ?? 'global' }}"
                    x-data="{
                        chart: null,
                        init() {
                            //console.log('Chart Init Triggered');
                            //console.log('Window.Chart available:', !!window.Chart);
                            
                            const rawData = @js($this->history);
                            //console.log('Raw Data received:', rawData);
                            
                            if (!rawData || (Array.isArray(rawData) && rawData.length === 0)) {
                                console.warn('Chart data is empty');
                                return;
                            }

                            // Normalize data: assuming array of {date, value} or similar, 
                            // but coping with potential Object structure (date => value)
                            let labels = [];
                            let values = [];

                            if (Array.isArray(rawData)) {
                                labels = rawData.map(item => window.formatDateFr(item.date || item.created_at));
                                values = rawData.map(item => item.value);
                            } else if (typeof rawData === 'object' && rawData !== null) {
                                labels = Object.keys(rawData).map(date => window.formatDateFr(date));
                                values = Object.values(rawData);
                            }

                            if (this.chart) {
                                this.chart.destroy();
                            }

                            this.chart = new Chart(this.$refs.canvas, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Valeur',
                                        data: values,
                                        borderColor: '#0ea5e9', // sky-500
                                        backgroundColor: 'rgba(14, 165, 233, 0.1)', // sky-500/10
                                        borderWidth: 2,
                                        fill: true,
                                        tension: 0.4,
                                        pointBackgroundColor: '#ffffff',
                                        pointBorderColor: '#0ea5e9',
                                        pointHoverBackgroundColor: '#0ea5e9',
                                        pointHoverBorderColor: '#ffffff'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    interaction: {
                                        intersect: false,
                                        mode: 'index',
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            backgroundColor: '#1e293b',
                                            titleColor: '#f1f5f9',
                                            bodyColor: '#f1f5f9',
                                            padding: 12,
                                            cornerRadius: 8,
                                            displayColors: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            grid: {
                                                display: false
                                            },
                                            ticks: {
                                                color: '#64748b',
                                                font: {
                                                    family: 'inherit'
                                                }
                                            }
                                        },
                                        y: {
                                            border: {
                                                display: false
                                            },
                                            grid: {
                                                color: '#f1f5f9'
                                            },
                                            ticks: {
                                                color: '#64748b',
                                                font: {
                                                    family: 'inherit'
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    }"
                    class="h-80 w-full relative"
                >
                    <canvas x-ref="canvas"></canvas>
                </div>
            </div>
        </div>

        {{-- Advice section --}}
        @if(count($this->advice) > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">Conseils personnalisés</h2>
                <div class="space-y-4">
                    @foreach($this->advice as $item)
                        @php
                            $typeColors = [
                                'success' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'icon' => 'text-green-500'],
                                'warning' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'icon' => 'text-yellow-500'],
                                'alert' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'icon' => 'text-red-500'],
                                'info' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'icon' => 'text-blue-500'],
                                'tip' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'icon' => 'text-purple-500'],
                            ];
                            $colors = $typeColors[$item['type']] ?? $typeColors['info'];
                        @endphp
                        <div class="bg-white rounded-2xl border-2 {{ $colors['border'] }} p-6 {{ $colors['bg'] }}">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    @if($item['type'] === 'success')
                                        <svg class="w-6 h-6 {{ $colors['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @elseif($item['type'] === 'warning')
                                        <svg class="w-6 h-6 {{ $colors['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    @elseif($item['type'] === 'alert')
                                        <svg class="w-6 h-6 {{ $colors['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @elseif($item['type'] === 'tip')
                                        <svg class="w-6 h-6 {{ $colors['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 {{ $colors['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-slate-900 mb-1">
                                        {{ $item['title'] }}
                                    </h3>
                                    <p class="text-slate-700">
                                        {{ $item['message'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>


    {{-- Footer --}}
    <footer class="border-t border-slate-200 py-12 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                {{-- Logo --}}
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-sky-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xl font-bold text-slate-900">
                        QualitEau
                    </span>
                </div>

                {{-- Credits --}}
                <div class="text-center md:text-left">
                    <p class="text-slate-600">
                        Projet réalisé pour Jatniel Guzmán •
                        <a href="https://jatniel.dev" target="_blank" class="text-sky-600 hover:text-sky-700 font-medium">
                            jatniel.dev
                        </a>
                    </p>
                </div>

                {{-- GitHub Link --}}
                <a href="https://github.com/jatniel" target="_blank" class="text-slate-600 hover:text-slate-900 transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
            </div>
        </div>
    </footer>
</div>
