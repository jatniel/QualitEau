<x-layouts.app :title="'QualitEau - ' . $commune->nom_commune">
    <livewire:dashboard.quality-dashboard :code-commune="$code" />
</x-layouts.app>
