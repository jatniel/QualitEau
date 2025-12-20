<?php
/**
 * Quality dashboard component
 * @author    Jatniel Guzmán https://jatniel.dev
 * @copyright    2025
 * @license    MIT
 */

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use App\Enums\WaterParameter;
use App\Services\HubEau\WaterQualityService;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * Water quality dashboard component
 */
class QualityDashboard extends Component
{
    public string $codeCommune;
    public ?string $selectedParameter = null;

    private WaterQualityService $waterQualityService;

    /**
     * Inject dependencies on component boot
     */
    public function boot(WaterQualityService $waterQualityService): void
    {
        $this->waterQualityService = $waterQualityService;
    }

    /**
     * Initialize component with commune code
     */
    public function mount(string $codeCommune): void
    {
        $this->codeCommune = $codeCommune;
        $this->selectedParameter = WaterParameter::NITRATES->value;
    }

    /**
     * Get complete quality summary
     */
    #[Computed]
    public function summary(): array
    {
        return $this->waterQualityService->getQualitySummary($this->codeCommune);
    }

    /**
     * Get main water parameters
     */
    #[Computed]
    public function mainParameters(): array
    {
        return $this->waterQualityService->getMainParameters($this->codeCommune);
    }

    /**
     * Get personalized advice
     */
    #[Computed]
    public function advice(): array
    {
        return $this->waterQualityService->getAdvice($this->summary);
    }

    /**
     * Get parameter history for chart
     */
    #[Computed]
    public function history(): array
    {
        if ($this->selectedParameter === null) {
            return [];
        }

        $parameter = WaterParameter::fromCode($this->selectedParameter);

        if ($parameter === null) {
            return [];
        }

        return $this->waterQualityService->getParameterHistory(
            codeCommune: $this->codeCommune,
            parameter: $parameter,
            months: 60
        );
    }

    /**
     * Select parameter for chart visualization
     */
    public function selectParameter(string $code): void
    {
        $this->selectedParameter = $code;
    }

    /**
     * Get Tailwind color class for grade
     */
    public function getGradeColor(string $grade): string
    {
        return match ($grade) {
            'A' => 'emerald',
            'B' => 'sky',
            'C' => 'amber',
            'D' => 'orange',
            'E' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get French label for grade
     */
    public function getGradeLabel(string $grade): string
    {
        return match ($grade) {
            'A' => 'Excellente',
            'B' => 'Bonne',
            'C' => 'Acceptable',
            'D' => 'Médiocre',
            'E' => 'Non conforme',
            default => 'Inconnue',
        };
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.dashboard.quality-dashboard');
    }
}
