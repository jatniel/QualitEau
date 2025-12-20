<x-layouts.app>
    {{-- Hero Section --}}
    <section class="relative min-h-screen flex flex-col bg-gradient-to-b from-sky-50 via-white to-cyan-50 overflow-hidden">
        {{-- Background decorations --}}
        <div class="absolute top-20 -left-40 w-96 h-96 bg-sky-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 -right-40 w-96 h-96 bg-cyan-200/30 rounded-full blur-3xl"></div>

        {{-- Header --}}
        <header class="relative z-10 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                {{-- Logo --}}
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-sky-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-2xl font-bold bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent">
                        QualitEau
                    </span>
                </div>

                {{-- Navigation --}}
                <nav class="hidden md:flex items-center space-x-8">

                    <a href="#about" class="text-slate-600 hover:text-slate-900 font-medium transition-colors">
                        À propos
                    </a>
                    <a href="https://hubeau.eaufrance.fr" target="_blank" class="flex items-center text-slate-600 hover:text-slate-900 font-medium transition-colors">
                        API Hub'Eau
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                    <a href="https://devchallenges.yoandev.co/challenge/week-50/" target="_blank" class="flex items-center text-slate-600 hover:text-slate-900 font-medium transition-colors">
                        DevChallenges
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </nav>
            </div>
        </header>

        {{-- Hero Content --}}
        <div class="relative z-10 flex-1 flex items-center">
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center max-w-3xl mx-auto">
                    {{-- Title --}}
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-slate-900 mb-6 leading-tight">
                        L'eau de votre robinet est-elle
                        <span class="bg-gradient-to-r from-sky-500 via-blue-500 to-cyan-500 bg-clip-text text-transparent">
                            de qualité ?
                        </span>
                    </h1>

                    {{-- Description --}}
                    <p class="text-xl text-slate-600 mb-12 max-w-2xl mx-auto leading-relaxed">
                        Consultez les résultats des contrôles sanitaires de votre commune et découvrez la qualité de votre eau potable en temps réel.
                    </p>

                    {{-- Search Component --}}
                    <div class="mb-16">
                        <livewire:search.commune-search />
                    </div>

                    {{-- Trust Badges --}}
                    <div class="flex flex-wrap justify-center gap-6 text-sm text-slate-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Données officielles</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-sky-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span class="font-medium">Mise à jour mensuelle</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span class="font-medium">36,000+ communes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- Features Section --}}
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            {{-- Section Header --}}
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-slate-900 mb-4">
                    Comment ça marche ?
                </h2>
            </div>

            {{-- Features Grid --}}
            <div class="grid md:grid-cols-3 gap-8">
                {{-- Step 1 --}}
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-sky-100 text-sky-600 font-bold text-2xl mb-6 group-hover:bg-sky-500 group-hover:text-white transition-all duration-300">
                        1
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">
                        Recherchez
                    </h3>
                    <p class="text-slate-600 leading-relaxed">
                        Entrez le nom de votre commune pour trouver votre localisation.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-600 font-bold text-2xl mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                        2
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">
                        Analysez
                    </h3>
                    <p class="text-slate-600 leading-relaxed">
                        Consultez les résultats détaillés des analyses : nitrates, pH, bactéries et autres paramètres essentiels.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-amber-100 text-amber-600 font-bold text-2xl mb-6 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                        3
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">
                        Agissez
                    </h3>
                    <p class="text-slate-600 leading-relaxed">
                        Recevez des conseils personnalisés pour améliorer votre consommation d'eau en fonction des résultats.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 text-white rounded-3xl p-8 sm:p-12 shadow-2xl">
                <h2 class="text-3xl sm:text-4xl font-bold mb-6">
                    À propos des données
                </h2>
                <p class="text-lg text-slate-300 leading-relaxed mb-6">
                    Les données présentées sur QualitEau proviennent de l'API Hub'Eau,
                    une plateforme mise en place par le Ministère de la Transition Écologique
                    et l'Office français de la biodiversité.
                </p>
                <p class="text-lg text-slate-300 leading-relaxed mb-8">
                    Les analyses de l'eau potable sont réalisées par les distributeurs d'eau
                    et validées par les Agences Régionales de Santé (ARS). Les résultats sont
                    mis à jour mensuellement pour garantir des informations fiables et actuelles.
                </p>
                <a
                    href="https://hubeau.eaufrance.fr"
                    target="_blank"
                    class="inline-flex items-center px-6 py-3 bg-white text-slate-900 font-semibold rounded-xl hover:bg-slate-100 transition-colors duration-200"
                >
                    En savoir plus sur l'API
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

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


</x-layouts.app>
