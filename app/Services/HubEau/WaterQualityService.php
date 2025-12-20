<?php
/**
 * Water quality service
 * @author    Jatniel Guzmán https://jatniel.dev
 * @copyright    2025
 * @license    MIT
 */

declare(strict_types=1);

namespace App\Services\HubEau;

use App\Enums\WaterParameter;
use App\Enums\WaterQualityStatus;

/**
 * Service for analyzing water quality data
 */
class WaterQualityService
{
    public function __construct(
        private readonly HubEauClient $client
    ) {}

    /**
     * Get complete quality summary for a commune
     */
    public function getQualitySummary(string $codeCommune): array
    {
        $commune = $this->client->getCommune($codeCommune);

        if ($commune === null) {
            throw new \RuntimeException("Commune not found: {$codeCommune}");
        }

        $latestResults = $this->client->getLatestResultsByParameter($codeCommune);

        if (empty($latestResults)) {
            return [
                'commune' => [
                    'code' => $codeCommune,
                    'nom' => $commune['nom_commune'] ?? 'Commune inconnue',
                    'reseau' => $commune['nom_reseau'] ?? null,
                ],
                'grade' => 'E',
                'score' => 0,
                'parameters' => [],
                'last_update' => null,
                'total_analyses' => 0,
            ];
        }

        // Evaluate each parameter
        $evaluatedParameters = [];
        $scores = [];

        foreach ($latestResults as $codeParam => $result) {
            $parameter = WaterParameter::fromCode((string) $codeParam);

            if ($parameter === null) {
                continue;
            }

            $value = (float) ($result['resultat_alphanumerique'] ?? 0);
            $status = $parameter->evaluate($value);

            $evaluatedParameters[] = [
                'code' => $parameter->value,
                'name' => $parameter->label(),
                'value' => $value,
                'unit' => $parameter->unit(),
                'limit' => $parameter->limit(),
                'status' => $status->value,
                'status_label' => $status->label(),
                'color' => $status->color(),
                'date' => $result['date_prelevement'] ?? null,
                'score' => $status->score(),
            ];

            $scores[] = $status->score();
        }

        $globalScore = $this->calculateGlobalScore($scores);

        return [
            'commune' => [
                'code' => $codeCommune,
                'nom' => $commune['nom_commune'] ?? 'Commune inconnue',
                'reseau' => $commune['nom_reseau'] ?? null,
            ],
            'grade' => $this->scoreToGrade($globalScore),
            'score' => $globalScore,
            'parameters' => $evaluatedParameters,
            'last_update' => $this->getLastUpdateDate($latestResults),
            'total_analyses' => count($latestResults),
        ];
    }

    /**
     * Get only main parameters with their current values
     */
    public function getMainParameters(string $codeCommune): array
    {
        $latestResults = $this->client->getLatestResultsByParameter($codeCommune);

        if (empty($latestResults)) {
            return [];
        }

        $mainParams = [];
        $mainParameterCodes = array_map(
            fn(WaterParameter $p) => $p->value,
            WaterParameter::mainParameters()
        );

        foreach ($latestResults as $codeParam => $result) {
            $codeParamStr = (string) $codeParam;
            if (!in_array($codeParamStr, $mainParameterCodes, true)) {
                continue;
            }

            $parameter = WaterParameter::fromCode((string) $codeParam);

            if ($parameter === null) {
                continue;
            }

            $value = (float) ($result['resultat_alphanumerique'] ?? 0);
            $status = $parameter->evaluate($value);

            $mainParams[] = [
                'parameter' => $parameter,
                'code' => $parameter->value,
                'name' => $parameter->label(),
                'value' => $value,
                'unit' => $parameter->unit(),
                'limit' => $parameter->limit(),
                'status' => $status,
                'status_label' => $status->label(),
                'date' => $result['date_prelevement'] ?? null,
                'description' => $parameter->description(),
            ];
        }

        return $mainParams;
    }

    /**
     * Get parameter history for chart visualization
     */
    public function getParameterHistory(
        string $codeCommune,
        WaterParameter $parameter,
        int $months = 12
    ): array {
        $results = $this->client->getParameterHistory(
            codeCommune: $codeCommune,
            codeParametre: $parameter->value,
            months: $months
        );

        $history = [];

        foreach ($results as $result) {
            $value = (float) ($result['resultat_alphanumerique'] ?? 0);

            $history[] = [
                'date' => $result['date_prelevement'] ?? null,
                'value' => $value,
                'unit' => $parameter->unit(),
                'limit' => $parameter->limit(),
                'status' => $parameter->evaluate($value)->value,
            ];
        }

        return $history;
    }

    /**
     * Generate personalized advice based on water quality
     */
    public function getAdvice(array $summary): array
    {
        $advice = [];
        $parameters = $summary['parameters'] ?? [];

        // Check global quality
        $score = $summary['score'] ?? 0;

        if ($score >= 90) {
            $advice[] = [
                'type' => 'success',
                'title' => 'Excellente qualité',
                'message' => 'Votre eau du robinet est d\'excellente qualité. Vous pouvez la consommer sans souci.',
            ];
        } elseif ($score < 50) {
            $advice[] = [
                'type' => 'alert',
                'title' => 'Qualité préoccupante',
                'message' => 'Certains paramètres dépassent les seuils recommandés. Consultez les détails ci-dessous.',
            ];
        }

        // Check specific parameters
        foreach ($parameters as $param) {
            $code = $param['code'] ?? null;
            $status = $param['status'] ?? null;
            $value = $param['value'] ?? 0;

            // Nitrates high - warning for babies
            if ($code === WaterParameter::NITRATES->value && in_array($status, ['acceptable', 'critical'])) {
                $advice[] = [
                    'type' => 'warning',
                    'title' => 'Nitrates élevés',
                    'message' => 'Déconseillé pour la préparation des biberons des nourrissons. Utilisez de l\'eau en bouteille.',
                ];
            }

            // E. coli detected
            if ($code === WaterParameter::ECOLI->value && $value > 0) {
                $advice[] = [
                    'type' => 'alert',
                    'title' => 'Contamination bactériologique',
                    'message' => 'Présence d\'E. coli détectée. Faites bouillir l\'eau avant consommation ou utilisez de l\'eau en bouteille.',
                ];
            }

            // Hard water
            if ($code === WaterParameter::DURETE->value && $status === 'hard') {
                $advice[] = [
                    'type' => 'tip',
                    'title' => 'Eau dure',
                    'message' => 'Votre eau est calcaire. Utilisez un adoucisseur ou du produit anticalcaire pour protéger vos appareils ménagers.',
                ];
            }

            // Soft water
            if ($code === WaterParameter::DURETE->value && $status === 'soft') {
                $advice[] = [
                    'type' => 'info',
                    'title' => 'Eau douce',
                    'message' => 'Votre eau est peu minéralisée. Bon pour les appareils, mais vous pouvez compléter vos apports minéraux par l\'alimentation.',
                ];
            }

            // pH issues
            if ($code === WaterParameter::PH->value && $status === 'critical') {
                $advice[] = [
                    'type' => 'warning',
                    'title' => 'pH anormal',
                    'message' => 'Le pH de votre eau est en dehors de la plage normale. Cela peut affecter le goût et la corrosion des canalisations.',
                ];
            }

            // Chlore high
            if ($code === WaterParameter::CHLORE_LIBRE->value && in_array($status, ['acceptable', 'critical'])) {
                $advice[] = [
                    'type' => 'tip',
                    'title' => 'Chlore élevé',
                    'message' => 'Taux de chlore élevé. Vous pouvez laisser reposer l\'eau dans une carafe au réfrigérateur pour réduire le goût.',
                ];
            }
        }

        // General tip if no issues
        if (empty($advice)) {
            $advice[] = [
                'type' => 'success',
                'title' => 'Eau de qualité',
                'message' => 'Tous les paramètres sont dans les normes. Continuez à profiter de votre eau du robinet.',
            ];
        }

        return $advice;
    }

    /**
     * Calculate global score from individual parameter scores
     */
    private function calculateGlobalScore(array $scores): int
    {
        if (empty($scores)) {
            return 0;
        }

        // Use weighted average (can be adjusted)
        return (int) round(array_sum($scores) / count($scores));
    }

    /**
     * Convert numeric score to letter grade
     */
    private function scoreToGrade(int $score): string
    {
        return match (true) {
            $score >= 90 => 'A',
            $score >= 75 => 'B',
            $score >= 60 => 'C',
            $score >= 40 => 'D',
            default => 'E',
        };
    }

    /**
     * Get most recent analysis date from results
     */
    private function getLastUpdateDate(array $results): ?string
    {
        if (empty($results)) {
            return null;
        }

        $dates = array_filter(
            array_column($results, 'date_prelevement')
        );

        if (empty($dates)) {
            return null;
        }

        rsort($dates);

        return $dates[0];
    }
}
