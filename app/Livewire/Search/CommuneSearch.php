<?php
/**
 * Commune search component
 * @author    Jatniel Guzmán https://jatniel.dev
 * @copyright    2025
 * @license    MIT
 */

declare(strict_types=1);

namespace App\Livewire\Search;

use App\Services\HubEau\HubEauClient;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * Commune search component with autocomplete
 */
class CommuneSearch extends Component
{
    public string $query = '';
    public bool $showResults = false;
    public ?array $selectedCommune = null;

    private HubEauClient $client;

    /**
     * Inject dependencies on component boot
     */
    public function boot(HubEauClient $client): void
    {
        $this->client = $client;
    }

    /**
     * Get search results based on query
     */
    #[Computed]
    public function results(): array
    {
        if (strlen($this->query) < 2) {
            return [];
        }

        // Add lazy evaluation
        $results = Cache::flexible(
            "hubeau.communes.search.{$this->query}.10",
            [5, 3600], // Fresh for 5 seconds, serve stale for up to 1 hour
            fn () => $this->client->searchCommunes($this->query, 10)
        );

        return collect($results)
            ->unique('code_commune')
            ->values()
            ->all();
    }

    /**
     * Handle query updates
     */
    public function updatedQuery(): void
    {
        $this->showResults = strlen($this->query) >= 2;
    }

    /**
     * Select a commune and navigate to details page
     */
    public function selectCommune(string $codeCommune, string $nomCommune): void
    {
        $this->selectedCommune = [
            'code' => $codeCommune,
            'nom' => $nomCommune,
        ];

        $this->query = $nomCommune;
        $this->showResults = false;

        $this->redirect(
            route('commune.show', ['code' => $codeCommune]),
            navigate: true
        );
    }

    /**
     * Hide search results dropdown
     */
    public function hideResults(): void
    {
        $this->showResults = false;
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.search.commune-search');
    }
}
