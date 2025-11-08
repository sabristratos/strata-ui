<?php

use Stratos\StrataUI\Tests\TestCase;

require_once __DIR__.'/helpers.php';

pest()->extend(TestCase::class)->in(__DIR__);

expect()->extend('toHaveClasses', function (string ...$classes) {
    foreach ($classes as $class) {
        \PHPUnit\Framework\Assert::assertStringContainsString($class, $this->value);
    }

    return $this;
});

expect()->extend('toHaveDataAttribute', function (string $attribute, ?string $value = null) {
    $pattern = $value !== null
        ? sprintf('data-%s="%s"', $attribute, $value)
        : sprintf('data-%s', $attribute);

    \PHPUnit\Framework\Assert::assertStringContainsString($pattern, $this->value);

    return $this;
});

expect()->extend('toRenderSlot', function (string $content) {
    \PHPUnit\Framework\Assert::assertStringContainsString($content, $this->value);

    return $this;
});

expect()->extend('toHaveAttribute', function (string $attribute, ?string $value = null) {
    if ($value !== null) {
        $pattern = sprintf('%s="%s"', $attribute, $value);
    } else {
        $pattern = $attribute;
    }

    // Debug: Check what we're working with
    if (! is_string($this->value)) {
        throw new \RuntimeException('Expected value to be a string, got: '.gettype($this->value));
    }

    \PHPUnit\Framework\Assert::assertStringContainsString($pattern, $this->value);

    return $this;
});

expect()->extend('toHaveTag', function (string $tag) {
    \PHPUnit\Framework\Assert::assertMatchesRegularExpression(
        sprintf('/<%s[>\s]/', preg_quote($tag, '/')),
        $this->value
    );

    return $this;
});
