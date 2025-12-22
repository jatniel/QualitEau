<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'QualitEau - Qualité de l\'eau potable' }}</title>

    {{-- Google Font Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://analytics.ahrefs.com/analytics.js" data-key="bkSK0ZO2XxtyTsMXo6nVeg" async></script>

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire styles --}}
    @livewireStyles
    <meta name="ahrefs-site-verification" content="ce0fac1989467b21d3ef7b4fb57dff62ce745f9123750dcdcfeb8a4c38f954f7">
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    {{ $slot }}


    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    {{-- Livewire scripts --}}
    @livewireScripts

    {{-- Additional scripts stack --}}
    @stack('scripts')
</body>
</html>
