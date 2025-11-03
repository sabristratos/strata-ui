<?php

namespace Stratos\StrataUI\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Stratos\StrataUI\StrataUIServiceProvider;

abstract class TestCase extends Orchestra
{
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('view:clear')->run();
    }

    protected function getPackageProviders($app): array
    {
        return [
            StrataUIServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
    }

    public function renderComponent(string $component, array $attributes = [], string $slot = ''): string
    {
        $attributeString = collect($attributes)
            ->map(fn ($value, $key) => is_bool($value) ? $key : sprintf('%s="%s"', $key, $value))
            ->implode(' ');

        $tag = "x-strata::{$component}";

        if ($slot) {
            return (string) $this->blade(
                "<{$tag} {$attributeString}>{$slot}</{$tag}>"
            );
        }

        return (string) $this->blade(
            "<{$tag} {$attributeString} />"
        );
    }
}
