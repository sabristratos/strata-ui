<?php

namespace Stratos\StrataUI\Synthesizers;

use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;
use Stratos\StrataUI\Data\DateValue;

class DateValueSynthesizer extends Synth
{
    public static $key = 'datevalue';

    public static function match($target): bool
    {
        return $target instanceof DateValue;
    }

    public static function matchByType($type): bool
    {
        return $type === DateValue::class || is_subclass_of($type, DateValue::class);
    }

    public static function hydrateFromType($type, $value): ?DateValue
    {
        if ($value === null || $value === '' || $value === []) {
            return null;
        }

        try {
            return DateValue::make($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function dehydrate(DateValue $target): array
    {
        return [$target->toDateString(), ['class' => get_class($target)]];
    }

    public function hydrate($value, $meta): ?DateValue
    {
        if ($value === null || $value === '' || $value === []) {
            return null;
        }

        try {
            return DateValue::make($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function get(&$target, $key)
    {
        return $target->$key ?? null;
    }

    public function set(&$target, $key, $value): void
    {
    }
}
