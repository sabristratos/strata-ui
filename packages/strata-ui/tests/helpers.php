<?php

use Stratos\StrataUI\Tests\TestCase;

if (! function_exists('expectComponent')) {
    function expectComponent(mixed $test, string $component, array $attributes = [], string $slot = ''): \Pest\Expectation
    {
        try {
            $rendered = $test->renderComponent($component, $attributes, $slot);
        } catch (\Error $e) {
            throw new \RuntimeException(
                'Failed to call renderComponent on test instance. '.
                'Test class: '.get_class($test).'. '.
                'Error: '.$e->getMessage().'. '.
                'Make sure your tests extend '.TestCase::class,
                0,
                $e
            );
        }

        return expect($rendered);
    }
}
