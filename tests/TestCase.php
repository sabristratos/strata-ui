<?php

namespace Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithViews;

    public function renderComponent(string $component, array $attributes = [], string $slot = ''): string
    {
        $attributeString = collect($attributes)
            ->map(fn ($value, $key) => is_bool($value) ? $key : sprintf('%s="%s"', $key, $value))
            ->implode(' ');

        $tag = "x-strata::{$component}";

        if ($slot) {
            return $this->blade(
                "<{$tag} {$attributeString}>{$slot}</{$tag}>"
            )->render();
        }

        return $this->blade(
            "<{$tag} {$attributeString} />"
        )->render();
    }
}
