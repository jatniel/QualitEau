<x-layouts.app title="Page non trouvée">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            {{-- Sad face illustration --}}
            <svg class="w-32 h-32 mx-auto text-slate-300 mb-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>

            {{-- 404 Number --}}
            <h1 class="text-6xl font-bold text-slate-900 mb-4">
                404
            </h1>

            {{-- Title --}}
            <h2 class="text-2xl font-semibold text-slate-700 mb-4">
                Page non trouvée
            </h2>

            {{-- Message --}}
            <p class="text-lg text-slate-600 mb-8 max-w-md mx-auto">
                La page que vous recherchez n'existe pas ou a été déplacée.
            </p>

            {{-- Back to home button --}}
            <a
                href="{{ route('home') }}"
                class="inline-flex items-center px-6 py-3 bg-sky-500 text-white font-semibold rounded-xl shadow-lg hover:bg-sky-600 transition-colors duration-200"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Retour à l'accueil
            </a>
        </div>
    </div>
</x-layouts.app>
