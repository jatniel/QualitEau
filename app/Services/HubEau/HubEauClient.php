<?php
/**
 * Hub'Eau client
 * @author    Jatniel Guzmán https://jatniel.dev
 * @copyright    2025
 * @license    MIT
 */

declare(strict_types=1);

namespace App\Services\HubEau;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * HTTP client for Hub'Eau water quality API
 */
class HubEauClient
{
    private readonly string $baseUrl;
    private readonly int $cacheTtl;
    private readonly int $timeout;
    private readonly int $retryAttempts;
    private readonly int $retryDelay;

    public function __construct()
    {
        $this->baseUrl = config('hubeau.base_url');
        $this->cacheTtl = (int) config('hubeau.cache.ttl');
        $this->timeout = (int) config('hubeau.http.timeout');
        $this->retryAttempts = (int) config('hubeau.http.retry.times');
        $this->retryDelay = (int) config('hubeau.http.retry.sleep');
    }

    /**
     * Search communes by name with autocomplete
     */
    public function searchCommunes(string $query, int $limit = 10): array
    {
        $cacheKey = "hubeau.communes.search.{$query}.{$limit}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($query, $limit) {
            $response = $this->makeRequest('/communes_udi', [
                'nom_commune' => $query,
                'size' => $limit,
                'annee' => date('Y'),
            ]);

            return $response['data'] ?? [];
        });
    }

    /**
     * Get commune details by code
     */
    public function getCommune(string $codeCommune): ?array
    {
        $cacheKey = "hubeau.commune.{$codeCommune}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($codeCommune) {
            $response = $this->makeRequest('/communes_udi', [
                'code_commune' => $codeCommune,
                'annee' => date('Y'),
            ]);

            $data = $response['data'] ?? [];

            return !empty($data) ? $data[0] : null;
        });
    }

    /**
     * Get water quality results for a commune
     */
    public function getWaterQualityResults(
        string $codeCommune,
        ?string $codeParametre = null,
        ?string $dateMin = null,
        ?string $dateMax = null,
        int $size = 1000
    ): array {
        $params = [
            'code_commune' => $codeCommune,
            'size' => $size,
        ];

        if ($codeParametre !== null) {
            $params['code_parametre'] = $codeParametre;
        }

        if ($dateMin !== null) {
            $params['date_min_prelevement'] = $dateMin;
        }

        if ($dateMax !== null) {
            $params['date_max_prelevement'] = $dateMax;
        }

        $cacheKey = 'hubeau.results.' . md5(serialize($params));

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($params) {
            $response = $this->makeRequest('/resultats_dis', $params);

            return $response['data'] ?? [];
        });
    }

    /**
     * Get latest results grouped by parameter for a commune
     */
    public function getLatestResultsByParameter(string $codeCommune): array
    {
        $startDate = date('Y-m-d', strtotime('-5 years'));
        $today = date('Y-m-d');

        $results = $this->getWaterQualityResults(
            codeCommune: $codeCommune,
            dateMin: $startDate,
            dateMax: $today,
            size: 5000
        );

        if (empty($results)) {
            return [];
        }

        // Group by parameter and get the most recent result for each
        $latestByParameter = [];

        foreach ($results as $result) {
            $codeParam = $result['code_parametre'] ?? null;
            $datePrelevement = $result['date_prelevement'] ?? null;

            if ($codeParam === null || $datePrelevement === null) {
                continue;
            }

            // If parameter not seen or this result is more recent
            if (
                !isset($latestByParameter[$codeParam]) ||
                $datePrelevement > $latestByParameter[$codeParam]['date_prelevement']
            ) {
                $latestByParameter[$codeParam] = $result;
            }
        }

        return $latestByParameter;
    }

    /**
     * Get parameter history for time series analysis
     */
    public function getParameterHistory(
        string $codeCommune,
        string $codeParametre,
        int $months = 12
    ): array {
        $dateMin = date('Y-m-d', strtotime("-{$months} months"));
        $dateMax = date('Y-m-d');

        $results = $this->getWaterQualityResults(
            codeCommune: $codeCommune,
            codeParametre: $codeParametre,
            dateMin: $dateMin,
            dateMax: $dateMax,
            size: 5000
        );

        // Sort by date ascending
        usort($results, function ($a, $b) {
            return ($a['date_prelevement'] ?? '') <=> ($b['date_prelevement'] ?? '');
        });

        return $results;
    }

    /**
     * Make HTTP request to Hub'Eau API with retry logic
     */
    private function makeRequest(string $endpoint, array $params = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $response = Http::timeout($this->timeout)
            ->withOptions([
                'version' => 2.0, // Force HTTP/2
                'verify' => true,
            ])
            ->retry($this->retryAttempts, $this->retryDelay, function ($exception) {
                return $exception instanceof RequestException;
            })
            ->get($url, $params);
        if ($response->failed()) {
            throw new \RuntimeException(
                "Hub'Eau API request failed: {$response->status()}"
            );
        }
        return $response->json();
    }
}
