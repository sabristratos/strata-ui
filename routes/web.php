<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Strata UI Package Routes
|--------------------------------------------------------------------------
|
| Here we define the routes for the Strata UI package. These routes
| serve the compiled JavaScript assets directly from the package.
|
*/

Route::get('/vendor/strata-ui/strata-ui.js', function () {
    $path = realpath(__DIR__ . '/../resources/dist/strata-ui.iife.js');

    if (!$path || !file_exists($path)) {
        abort(404, 'Strata UI JavaScript bundle not found. Please run: cd packages/strata-ui && npm run build');
    }

    return response(file_get_contents($path), 200, [
        'Content-Type' => 'application/javascript',
        'Cache-Control' => 'public, max-age=31536000', // 1 year cache
    ]);
})->name('strata.scripts');