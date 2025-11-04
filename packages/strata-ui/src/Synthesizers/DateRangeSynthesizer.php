<?php

namespace Stratos\StrataUI\Synthesizers;

use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;
use Stratos\StrataUI\Data\DateRange;

class DateRangeSynthesizer extends Synth
{
    public static $key = 'daterange';

    public static function match($target): bool
    {
        return $target instanceof DateRange;
    }

    public static function matchByType($type): bool
    {
        return $type === DateRange::class || is_subclass_of($type, DateRange::class);
    }

    public static function hydrateFromType($type, $value): ?DateRange
    {
        if ($value === null || $value === '' || $value === []) {
            return null;
        }

        try {
            if (is_array($value)) {
                return DateRange::fromArray($value);
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function dehydrate(DateRange $target): array
    {
        return [$target->toArray(), ['class' => get_class($target)]];
    }

    public function hydrate($value, $meta): ?DateRange
    {
        if ($value === null || $value === '' || $value === []) {
            return null;
        }

        try {
            if (is_array($value)) {
                return DateRange::fromArray($value);
            }

            return null;
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
