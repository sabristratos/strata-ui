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
use Stratos\StrataUI\View\Components\Carousel;
use Stratos\StrataUI\View\Components\FileInput;
use Stratos\StrataUI\View\Components\Image;
use Stratos\StrataUI\View\Components\PhoneInput;
use Stratos\StrataUI\View\Components\Select;

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
        $this->registerViewComposer();
    }

    protected function registerBladeDirectives(): void
    {
        Blade::directive('strataStyles', function () {
            return "<?php echo '<link rel=\"stylesheet\" href=\"' . asset('vendor/strata-ui/strata-css.css') . '\">'; ?>";
        });

        Blade::directive('strataScripts', function () {
            return "<?php echo '<script src=\"' . asset('vendor/strata-ui/strata.js') . '\" defer></script>'; ?>";
        });

        Blade::directive('strataTranslations', function () {
            return <<<'PHP'
<?php
    $locale = config('strata-ui.locale') ?: app()->getLocale();
    $fallbackLocale = config('strata-ui.fallback_locale', 'en');

    $translationPath = __DIR__.'/../../vendor/stratos/strata-ui/lang/'.$locale.'.json';
    $fallbackPath = __DIR__.'/../../vendor/stratos/strata-ui/lang/'.$fallbackLocale.'.json';

    $translations = [];
    if (file_exists($fallbackPath)) {
        $translations = json_decode(file_get_contents($fallbackPath), true) ?: [];
    }
    if (file_exists($translationPath) && $locale !== $fallbackLocale) {
        $localeTranslations = json_decode(file_get_contents($translationPath), true) ?: [];
        $translations = array_merge($translations, $localeTranslations);
    }

    echo '<script>';
    echo 'window.__strataTranslations = ' . json_encode($translations, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) . ';';
    echo 'window.__strataLocale = ' . json_encode($locale) . ';';
    echo '</script>';
?>
PHP;
        });

        Blade::directive('strataLightbox', function () {
            return "<?php echo view('strata-ui::components.lightbox.index')->render(); ?>";
        });
    }

    protected function registerComponentNamespace(): void
    {
        Blade::anonymousComponentNamespace('strata-ui::components', 'strata');

        Blade::component('strata::carousel', Carousel::class);
        Blade::component('strata::file-input', FileInput::class);
        Blade::component('strata::image', Image::class);
        Blade::component('strata::phone-input', PhoneInput::class);
        Blade::component('strata::select', Select::class);
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

    protected function registerViewComposer(): void
    {
        view()->composer('*', function ($view) {
            $locale = config('strata-ui.locale') ?: app()->getLocale();
            $isRTL = in_array($locale, ['ar', 'he', 'fa', 'ur']);

            $view->with('__strataIsRTL', $isRTL);
            $view->with('__strataLocale', $locale);
        });
    }
}
