<?php
/**
 * Web routes QualitEau
 * @author    Jatniel Guzmán https://jatniel.dev
 * @copyright    2025
 * @license    MIT
 */

declare(strict_types=1);

use App\Services\HubEau\HubEauClient;
use Illuminate\Support\Facades\Route;

/**
 * Home page
 */
Route::get('/', function () {
    return view('pages.home');
})->name('home');

/**
 * Commune water quality details
 */
Route::get('/commune/{code}', function (string $code, HubEauClient $client) {
    $commune = $client->getCommune($code);

    if ($commune === null) {
        abort(404, 'Commune non trouvée');
    }

    return view('pages.commune', [
        'code' => $code,
        'commune' => (object) $commune,
    ]);
})->where('code', '[0-9]{5}')->name('commune.show');
