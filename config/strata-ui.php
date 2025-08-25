<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Theme
    |--------------------------------------------------------------------------
    |
    | This option controls the default theme that will be used by Strata UI
    | components. You can set this to 'light', 'dark', or 'auto' for
    | automatic theme detection based on user preferences.
    |
    */
    
    'theme' => env('STRATA_UI_THEME', 'auto'),

    /*
    |--------------------------------------------------------------------------
    | Component Prefix
    |--------------------------------------------------------------------------
    |
    | This option allows you to customize the prefix used for Strata UI
    | components. By default, components are accessed via x-strata::
    |
    */

    'prefix' => env('STRATA_UI_PREFIX', 'strata'),

    /*
    |--------------------------------------------------------------------------
    | Asset Serving
    |--------------------------------------------------------------------------
    |
    | Configure how Strata UI serves its compiled JavaScript assets.
    | 'route' serves assets via Laravel route, 'static' expects published assets.
    |
    */

    'assets' => [
        'strategy' => env('STRATA_UI_ASSETS', 'route'), // 'route' or 'static'
        'cache_duration' => 31536000, // 1 year in seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Icon Set
    |--------------------------------------------------------------------------
    |
    | Configure the default icon set used by Strata UI components.
    | Currently supports 'heroicons' out of the box.
    |
    */

    'icons' => [
        'default_set' => 'heroicons',
        'prefix' => 'heroicon',
    ],
];