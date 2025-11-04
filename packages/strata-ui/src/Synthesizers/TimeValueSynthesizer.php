<?php

namespace Stratos\StrataUI\Synthesizers;

use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;
use Stratos\StrataUI\Data\TimeValue;

class TimeValueSynthesizer extends Synth
{
    public static $key = 'timevalue';

    public static function match($target): bool
    {
        return $target instanceof TimeValue;
    }

    public static function matchByType($type): bool
    {
        return $type === TimeValue::class || is_subclass_of($type, TimeValue::class);
    }

    public static function hydrateFromType($type, $value): ?TimeValue
    {
        if ($value === null || $value === '' || $value === []) {
            return null;
        }

        try {
            if (is_string($value)) {
                return TimeValue::make($value);
            }

            if (is_array($value)) {
                return TimeValue::fromArray($value);
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function dehydrate(TimeValue $target): array
    {
        return [$target->toLivewire(), ['class' => get_class($target)]];
    }

    public function hydrate($value, $meta): ?TimeValue
    {
        if ($value === null || $value === '' || $value === []) {
            return null;
        }

        try {
            if (is_string($value)) {
                return TimeValue::make($value);
            }

            if (is_array($value)) {
                return TimeValue::fromArray($value);
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
