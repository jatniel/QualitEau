<?php
/**
 * Hub'Eau configuration
 * @author    Jatniel Guzmán https://jatniel.dev
 * @copyright    2025
 * @license    MIT
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Hub'Eau API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Hub'Eau water quality API.
    |
    */

    'base_url' => env('HUBEAU_BASE_URL', 'https://hubeau.eaufrance.fr/api/v1/qualite_eau_potable'),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    |
    | Available endpoints for the Hub'Eau API.
    |
    */

    'endpoints' => [
        'communes_udi' => '/communes_udi',
        'resultats_dis' => '/resultats_dis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Cache settings for API responses.
    |
    */

    'cache' => [
        'enabled' => env('HUBEAU_CACHE_ENABLED', true),
        'ttl' => env('HUBEAU_CACHE_TTL', 3600), // 1 hour in seconds
        'prefix' => 'hubeau_',
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Configuration
    |--------------------------------------------------------------------------
    |
    | HTTP client timeout and retry settings.
    |
    */

    'http' => [
        'timeout' => 30, // seconds
        'retry' => [
            'times' => 3,
            'sleep' => 100, // milliseconds
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Default and maximum pagination sizes for API requests.
    |
    */

    'pagination' => [
        'default_size' => 1000,
        'max_size' => 20000,
    ],

];
