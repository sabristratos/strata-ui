<?php

declare(strict_types=1);

namespace Strata\UI;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Strata\UI\Facades\Strata;
use Strata\UI\Synthesizers\DateRangeSynth;
use Strata\UI\View\Components\Form\Editor;

class StrataServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'strata');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'strata');

        Blade::componentNamespace('Strata\\UI\\View\\Components', 'strata');
        
        Blade::component('strata::editor', Editor::class);
        
        Livewire::propertySynthesizer(DateRangeSynth::class);
        
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->registerBladeDirectives();

        if ($this->app->runningInConsole()) {
            // Publish CSS theme files
            $this->publishes([
                __DIR__.'/../resources/css' => resource_path('css/vendor/strata-ui'),
            ], 'strata-ui-assets');

            // Publish compiled JavaScript assets
            $this->publishes([
                __DIR__.'/../resources/dist' => public_path('vendor/strata-ui'),
            ], 'strata-ui-assets');

            // Publish views for customization
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/strata-ui'),
            ], 'strata-ui-views');

            // Publish language files
            $this->publishes([
                __DIR__.'/../resources/lang' => $this->app->langPath('vendor/strata-ui'),
            ], 'strata-ui-lang');

            // Publish configuration file
            $this->publishes([
                __DIR__.'/../config/strata-ui.php' => config_path('strata-ui.php'),
            ], 'strata-ui-config');
        }
    }

    public function register(): void
    {
        $this->app->singleton(StrataUIService::class, function () {
            return new StrataUIService();
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('Strata', Strata::class);
    }


    /**
     * Register the custom Blade directive.
     */
    protected function registerBladeDirectives(): void
    {
        Blade::directive('strataScripts', function () {
            $route = route('strata.scripts');
            return "<?php echo '<script src=\"{$route}\" defer></script>'; ?>";
        });
    }
}