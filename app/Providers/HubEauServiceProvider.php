<?php
/**
 * Hub'Eau service provider
 * @author    Jatniel Guzmán https://jatniel.dev
 * @copyright    2025
 * @license    MIT
 */

declare(strict_types=1);

namespace App\Providers;

use App\Services\HubEau\HubEauClient;
use App\Services\HubEau\WaterQualityService;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider for Hub'Eau water quality services
 */
class HubEauServiceProvider extends ServiceProvider
{
    /**
     * Register services
     */
    public function register(): void
    {
        // Register HTTP client as singleton
        $this->app->singleton(HubEauClient::class, function ($app) {
            return new HubEauClient();
        });

        // Register water quality service with dependency injection
        $this->app->singleton(WaterQualityService::class, function ($app) {
            return new WaterQualityService(
                $app->make(HubEauClient::class)
            );
        });
    }

    /**
     * Bootstrap services
     */
    public function boot(): void
    {
        //
    }
}
