<?php

namespace Stratos\StrataUI;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Stratos\StrataUI\Commands\BuildCommand;
use Stratos\StrataUI\Services\FileService;

class StrataUIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/strata-ui.php',
            'strata-ui'
        );

        $this->app->singleton(FileService::class);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'strata-ui');

        $this->registerBladeDirectives();
        $this->registerComponentNamespace();
        $this->registerPublishing();
        $this->registerCommands();
    }

    protected function registerBladeDirectives(): void
    {
        Blade::directive('strataStyles', function () {
            return "<?php echo '<link rel=\"stylesheet\" href=\"' . asset('vendor/strata-ui/strata-css.css') . '\">'; ?>";
        });

        Blade::directive('strataScripts', function () {
            return "<?php echo '<script src=\"' . asset('vendor/strata-ui/strata.js') . '\" defer></script>'; ?>";
        });
    }

    protected function registerComponentNamespace(): void
    {
        Blade::anonymousComponentNamespace('strata-ui::components', 'strata');
    }

    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/strata-ui.php' => config_path('strata-ui.php'),
            ], 'strata-ui-config');

            $this->publishes([
                __DIR__.'/../public/build' => public_path('vendor/strata-ui'),
            ], 'strata-ui-assets');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/strata-ui'),
            ], 'strata-ui-views');
        }
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BuildCommand::class,
            ]);
        }
    }

    protected function getAssetPath(string $file): string
    {
        $basePath = config('strata-ui.asset_path', 'vendor/strata-ui');

        return asset("{$basePath}/{$file}");
    }
}
