<?php

namespace Stratos\StrataUI\Support;

use Illuminate\View\ComponentAttributeBag;

class ComponentHelpers
{
    /**
     * Generate a unique component ID with fallback logic.
     *
     * Priority order:
     * 1. Custom $id parameter
     * 2. ID from component attributes
     * 3. Auto-generated ID using prefix + uniqid()
     *
     * @param  string  $prefix  The component prefix (e.g., 'date-picker', 'select')
     * @param  string|null  $id  Custom ID passed as prop
     * @param  ComponentAttributeBag|null  $attributes  Component attribute bag
     * @return string The generated component ID
     */
    public static function generateId(
        string $prefix,
        ?string $id = null,
        ?ComponentAttributeBag $attributes = null
    ): string {
        return $id ?? $attributes?->get('id') ?? $prefix.'-'.uniqid();
    }
}
