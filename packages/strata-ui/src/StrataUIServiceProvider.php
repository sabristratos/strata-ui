<?php

namespace Stratos\StrataUI;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Stratos\StrataUI\Commands\BuildCommand;
use Stratos\StrataUI\Services\FileService;
use Stratos\StrataUI\Synthesizers\DateRangeSynthesizer;
use Stratos\StrataUI\Synthesizers\DateValueSynthesizer;
use Stratos\StrataUI\Synthesizers\TimeValueSynthesizer;
use Stratos\StrataUI\View\Components\Image;

class StrataUIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/strata-ui.php',
            'strata-ui'
        );

        $this->app->singleton(FileService::class);
        $this->app->singleton('strata', Strata::class);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'strata-ui');
        $this->loadJsonTranslationsFrom(__DIR__.'/../lang');

        $this->registerBladeDirectives();
        $this->registerComponentNamespace();
        $this->registerPublishing();
        $this->registerCommands();
        $this->registerLivewireSynthesizers();
    }

    protected function registerBladeDirectives(): void
    {
        Blade::directive('strataStyles', function () {
            return "<?php echo '<link rel=\"stylesheet\" href=\"' . asset('vendor/strata-ui/strata-css.css') . '\">'; ?>";
        });

        Blade::directive('strataScripts', function () {
            return "<?php echo '<script src=\"' . asset('vendor/strata-ui/strata.js') . '\" defer></script>'; ?>";
        });

        Blade::directive('strataLightbox', function () {
            return "<?php echo view('strata-ui::components.lightbox.index')->render(); ?>";
        });
    }

    protected function registerComponentNamespace(): void
    {
        Blade::anonymousComponentNamespace('strata-ui::components', 'strata');

        Blade::component('strata::image', Image::class);
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

            $this->publishes([
                __DIR__.'/../lang' => $this->app->langPath('vendor/strata-ui'),
            ], 'strata-ui-lang');
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

    protected function registerLivewireSynthesizers(): void
    {
        if (! class_exists(Livewire::class)) {
            return;
        }

        Livewire::propertySynthesizer(DateValueSynthesizer::class);
        Livewire::propertySynthesizer(DateRangeSynthesizer::class);
        Livewire::propertySynthesizer(TimeValueSynthesizer::class);
    }
}
