<?php

declare(strict_types=1);

namespace Strata\UI\Facades;

use Illuminate\Support\Facades\Facade;
use Strata\UI\StrataUIService;

/**
 * @method static void toast(string $message, string $title = null, string $variant = 'info', int $duration = 5000, string $icon = null, array $actions = null)
 * @method static void modal(string $content = null, string $title = null, string $size = 'md', string $variant = 'default', bool $closable = true, bool $backdrop = true, array $actions = null, string $id = null)
 */
class Strata extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return StrataUIService::class;
    }
}