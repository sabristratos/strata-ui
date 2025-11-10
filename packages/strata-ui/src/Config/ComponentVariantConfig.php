<?php

namespace Stratos\StrataUI\Config;

class ComponentVariantConfig
{
    /**
     * Get input variant styling classes.
     *
     * @return array<string, string>
     */
    public static function inputVariants(): array
    {
        return [
            'faded' => 'bg-input border border-border',
            'flat' => 'bg-input border border-transparent',
            'bordered' => 'bg-transparent border border-border',
            'underlined' => 'bg-transparent border-b-0 relative after:absolute after:bottom-0 after:left-0 after:h-px after:w-0 after:bg-border after:transition-all after:duration-200 hover:after:w-full focus-within:after:w-full focus-within:after:bg-ring',
        ];
    }

    /**
     * Get carousel dots variant styling classes.
     *
     * @return array<string, array<string, string>>
     */
    public static function carouselDotsVariants(): array
    {
        return [
            'dots' => [
                'base' => 'rounded-full',
                'active' => 'bg-primary',
                'inactive' => 'bg-neutral-300 dark:bg-neutral-700 hover:bg-neutral-400 dark:hover:bg-neutral-600',
            ],
            'pills' => [
                'base' => 'rounded-full',
                'active' => 'bg-primary w-8',
                'inactive' => 'bg-neutral-300 dark:bg-neutral-700 hover:bg-neutral-400 dark:hover:bg-neutral-600',
            ],
            'numbers' => [
                'base' => 'rounded-full flex items-center justify-center text-xs font-medium',
                'active' => 'bg-primary text-primary-foreground',
                'inactive' => 'bg-neutral-200 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-300 dark:hover:bg-neutral-700',
            ],
        ];
    }

    /**
     * Get carousel progress variant styling classes.
     *
     * @return array<string, array<string, string>>
     */
    public static function carouselProgressVariants(): array
    {
        return [
            'bar' => [
                'wrapper' => 'w-full',
                'track' => 'w-full bg-neutral-200 dark:bg-neutral-800 rounded-full overflow-hidden',
                'fill' => 'bg-primary rounded-full',
            ],
            'percentage' => [
                'wrapper' => 'inline-flex items-center justify-center',
                'text' => 'text-sm font-medium text-neutral-700 dark:text-neutral-300',
            ],
            'ring' => [
                'wrapper' => 'inline-flex items-center justify-center',
                'ring' => 'transform -rotate-90',
                'ring-track' => 'stroke-neutral-200 dark:stroke-neutral-800',
                'ring-fill' => 'stroke-primary transition-all duration-200',
            ],
        ];
    }
}
