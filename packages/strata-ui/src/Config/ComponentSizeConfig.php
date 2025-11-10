<?php

namespace Stratos\StrataUI\Config;

class ComponentSizeConfig
{
    public static function inputSizes(): array
    {
        return [
            'sm' => 'h-9 px-3 text-sm',
            'md' => 'h-10 px-3 text-base',
            'lg' => 'h-11 px-4 text-lg',
        ];
    }

    public static function datePickerSizesWithChips(): array
    {
        return [
            'sm' => 'min-h-9 px-3 py-1.5 text-sm',
            'md' => 'min-h-10 px-3 py-2 text-base',
            'lg' => 'min-h-11 px-4 py-2.5 text-lg',
        ];
    }

    public static function textareaSizes(): array
    {
        return [
            'sm' => 'px-3 py-2 text-sm',
            'md' => 'px-3 py-2.5 text-base',
            'lg' => 'px-4 py-3 text-lg',
        ];
    }

    public static function buttonSizes(): array
    {
        return [
            'sm' => 'h-9 px-3 text-sm gap-1.5',
            'md' => 'h-10 px-3 text-base gap-2',
            'lg' => 'h-11 px-4 text-lg gap-2.5',
        ];
    }

    public static function buttonIconSizes(): array
    {
        return [
            'sm' => 'p-1.5',
            'md' => 'p-2',
            'lg' => 'p-2.5',
        ];
    }

    public static function iconSizes(): array
    {
        return [
            'sm' => 'w-4 h-4',
            'md' => 'w-5 h-5',
            'lg' => 'w-6 h-6',
        ];
    }

    public static function checkboxSizes(): array
    {
        return [
            'sm' => 'w-4 h-4',
            'md' => 'w-5 h-5',
            'lg' => 'w-6 h-6',
        ];
    }

    public static function checkboxIconSizes(): array
    {
        return [
            'sm' => 'w-3 h-3',
            'md' => 'w-3.5 h-3.5',
            'lg' => 'w-4 h-4',
        ];
    }

    public static function labelSizes(): array
    {
        return [
            'sm' => 'text-sm',
            'md' => 'text-base',
            'lg' => 'text-lg',
        ];
    }

    public static function descriptionSizes(): array
    {
        return [
            'sm' => 'text-xs',
            'md' => 'text-sm',
            'lg' => 'text-base',
        ];
    }

    public static function badgeSizes(): array
    {
        return [
            'sm' => 'px-2 py-0.5 text-xs gap-1',
            'md' => 'px-2.5 py-1 text-sm gap-1.5',
            'lg' => 'px-3 py-1.5 text-base gap-2',
        ];
    }

    public static function badgeIconSizes(): array
    {
        return [
            'sm' => 'w-3 h-3',
            'md' => 'w-4 h-4',
            'lg' => 'w-5 h-5',
        ];
    }

    public static function badgeDotSizes(): array
    {
        return [
            'sm' => 'w-1.5 h-1.5',
            'md' => 'w-2 h-2',
            'lg' => 'w-2.5 h-2.5',
        ];
    }

    public static function badgeDotTextSizes(): array
    {
        return [
            'sm' => 'text-xs gap-1.5',
            'md' => 'text-sm gap-2',
            'lg' => 'text-base gap-2.5',
        ];
    }

    public static function badgeContainerDotSizes(): array
    {
        return [
            'sm' => 'w-3 h-3',
            'md' => 'w-4 h-4',
            'lg' => 'w-5 h-5',
        ];
    }

    public static function avatarSizes(): array
    {
        return [
            'xs' => 'w-6 h-6 text-xs',
            'sm' => 'w-8 h-8 text-sm',
            'md' => 'w-10 h-10 text-base',
            'lg' => 'w-12 h-12 text-lg',
            'xl' => 'w-14 h-14 text-xl',
            '2xl' => 'w-16 h-16 text-2xl',
        ];
    }

    public static function toggleSizes(): array
    {
        return [
            'track' => [
                'sm' => 'h-5 w-9',
                'md' => 'h-7 w-12',
                'lg' => 'h-9 w-16',
            ],
            'handle' => [
                'sm' => 'w-3 h-3',
                'md' => 'w-4 h-4',
                'lg' => 'w-5 h-5',
            ],
        ];
    }

    public static function dropdownSizes(): array
    {
        return [
            'sm' => 'min-w-48 max-w-64',
            'md' => 'min-w-64 max-w-96',
            'lg' => 'min-w-80 max-w-lg',
        ];
    }

    public static function selectSizes(): array
    {
        return [
            'xs' => [
                'trigger' => 'h-8 px-2.5 text-xs',
                'icon' => 'w-3.5 h-3.5',
                'dropdown' => 'min-w-40 max-w-56',
            ],
            'sm' => [
                'trigger' => 'h-9 px-3 text-sm',
                'icon' => 'w-4 h-4',
                'dropdown' => 'min-w-48 max-w-64',
            ],
            'md' => [
                'trigger' => 'h-10 px-3 text-base',
                'icon' => 'w-5 h-5',
                'dropdown' => 'min-w-64 max-w-96',
            ],
            'lg' => [
                'trigger' => 'h-11 px-4 text-lg',
                'icon' => 'w-6 h-6',
                'dropdown' => 'min-w-80 max-w-lg',
            ],
            'xl' => [
                'trigger' => 'h-12 px-5 text-xl',
                'icon' => 'w-7 h-7',
                'dropdown' => 'min-w-96 max-w-2xl',
            ],
        ];
    }

    public static function selectSizesWithChips(): array
    {
        return [
            'xs' => [
                'trigger' => 'min-h-8 px-2.5 py-1 text-xs',
                'icon' => 'w-3.5 h-3.5',
                'dropdown' => 'min-w-40 max-w-56',
            ],
            'sm' => [
                'trigger' => 'min-h-9 px-3 py-1.5 text-sm',
                'icon' => 'w-4 h-4',
                'dropdown' => 'min-w-48 max-w-64',
            ],
            'md' => [
                'trigger' => 'min-h-10 px-3 py-2 text-base',
                'icon' => 'w-5 h-5',
                'dropdown' => 'min-w-64 max-w-96',
            ],
            'lg' => [
                'trigger' => 'min-h-11 px-4 py-2.5 text-lg',
                'icon' => 'w-6 h-6',
                'dropdown' => 'min-w-80 max-w-lg',
            ],
            'xl' => [
                'trigger' => 'min-h-12 px-5 py-3 text-xl',
                'icon' => 'w-7 h-7',
                'dropdown' => 'min-w-96 max-w-2xl',
            ],
        ];
    }

    public static function modalSizes(): array
    {
        return [
            'sm' => 'max-w-sm',
            'md' => 'max-w-xl',
            'lg' => 'max-w-3xl',
            'xl' => 'max-w-5xl',
        ];
    }

    public static function breadcrumbsSizes(): array
    {
        return [
            'sm' => 'text-sm gap-1.5',
            'md' => 'text-base gap-2',
            'lg' => 'text-lg gap-2.5',
        ];
    }

    public static function breadcrumbsIconSizes(): array
    {
        return [
            'sm' => 'w-3.5 h-3.5',
            'md' => 'w-4 h-4',
            'lg' => 'w-5 h-5',
        ];
    }

    public static function tableSizes(): array
    {
        return [
            'sm' => 'text-sm',
            'md' => 'text-base',
            'lg' => 'text-lg',
        ];
    }

    public static function calendarSizes(): array
    {
        return [
            'sm' => 'text-sm',
            'md' => 'text-base',
            'lg' => 'text-lg',
        ];
    }

    public static function editorSizes(): array
    {
        return [
            'sm' => 'min-h-32 text-sm',
            'md' => 'min-h-60 text-base',
            'lg' => 'min-h-96 text-lg',
        ];
    }

    public static function fileInputSizes(): array
    {
        return [
            'sm' => [
                'wrapper' => 'px-4 py-6 gap-2',
                'icon' => 'w-8 h-8',
                'label' => 'text-sm',
                'hint' => 'text-xs',
            ],
            'md' => [
                'wrapper' => 'px-6 py-8 gap-3',
                'icon' => 'w-10 h-10',
                'label' => 'text-base',
                'hint' => 'text-sm',
            ],
            'lg' => [
                'wrapper' => 'px-8 py-10 gap-4',
                'icon' => 'w-12 h-12',
                'label' => 'text-lg',
                'hint' => 'text-base',
            ],
        ];
    }

    public static function sliderSizes(): array
    {
        return [
            'sm' => [
                'track' => 'h-1',
                'handle' => 'w-4 h-4',
                'text' => 'text-xs',
            ],
            'md' => [
                'track' => 'h-2',
                'handle' => 'w-5 h-5',
                'text' => 'text-sm',
            ],
            'lg' => [
                'track' => 'h-3',
                'handle' => 'w-6 h-6',
                'text' => 'text-base',
            ],
        ];
    }

    public static function bottomNavSizes(): array
    {
        return [
            'sm' => 'px-2 py-2 gap-1',
            'md' => 'px-3 py-2.5 gap-2',
            'lg' => 'px-4 py-3 gap-3',
        ];
    }

    public static function bottomNavItemSizes(): array
    {
        return [
            'sm' => [
                'container' => 'min-h-11 px-3 py-2 gap-1.5 text-xs',
                'icon' => 'w-4 h-4',
            ],
            'md' => [
                'container' => 'min-h-14 px-4 py-2.5 gap-2 text-sm',
                'icon' => 'w-5 h-5',
            ],
            'lg' => [
                'container' => 'min-h-16 px-5 py-3 gap-2.5 text-base',
                'icon' => 'w-6 h-6',
            ],
        ];
    }

    public static function popoverContentSizes(): array
    {
        return [
            'sm' => 'p-3',
            'normal' => 'p-4',
            'lg' => 'p-6',
        ];
    }

    public static function radioInnerDotSizes(): array
    {
        return [
            'sm' => 'w-[7px] h-[7px]',
            'md' => 'w-[9px] h-[9px]',
            'lg' => 'w-[11px] h-[11px]',
        ];
    }

    public static function getSize(array $sizes, string $size, string $default = 'md'): string
    {
        return $sizes[$size] ?? $sizes[$default] ?? '';
    }

    public static function getSizePart(array $sizes, string $size, string $part, string $default = 'md'): string
    {
        if (isset($sizes[$size][$part])) {
            return $sizes[$size][$part];
        }

        if (isset($sizes[$default][$part])) {
            return $sizes[$default][$part];
        }

        return '';
    }

    public static function carouselSizes(): array
    {
        return [
            'xs' => [
                'wrapper' => 'relative',
                'viewport' => '',
                'container' => 'gap-2',
                'control-button' => 'w-8 h-8',
                'control-icon' => 'w-4 h-4',
                'controls-wrapper' => 'px-2',
                'dot-size' => 'w-1.5 h-1.5',
                'dots-gap' => 'gap-1.5',
                'counter' => 'text-xs',
                'navigation' => 'mt-2',
                'progress-height' => 'h-1',
                'progress-ring-size' => 'w-8 h-8',
            ],
            'sm' => [
                'wrapper' => 'relative',
                'viewport' => '',
                'container' => 'gap-3',
                'control-button' => 'w-9 h-9',
                'control-icon' => 'w-4 h-4',
                'controls-wrapper' => 'px-3',
                'dot-size' => 'w-2 h-2',
                'dots-gap' => 'gap-2',
                'counter' => 'text-sm',
                'navigation' => 'mt-3',
                'progress-height' => 'h-1.5',
                'progress-ring-size' => 'w-10 h-10',
            ],
            'md' => [
                'wrapper' => 'relative',
                'viewport' => '',
                'container' => 'gap-4',
                'control-button' => 'w-10 h-10',
                'control-icon' => 'w-5 h-5',
                'controls-wrapper' => 'px-4',
                'dot-size' => 'w-2.5 h-2.5',
                'dots-gap' => 'gap-2',
                'counter' => 'text-sm',
                'navigation' => 'mt-4',
                'progress-height' => 'h-2',
                'progress-ring-size' => 'w-12 h-12',
            ],
            'lg' => [
                'wrapper' => 'relative',
                'viewport' => '',
                'container' => 'gap-5',
                'control-button' => 'w-12 h-12',
                'control-icon' => 'w-6 h-6',
                'controls-wrapper' => 'px-5',
                'dot-size' => 'w-3 h-3',
                'dots-gap' => 'gap-2.5',
                'counter' => 'text-base',
                'navigation' => 'mt-5',
                'progress-height' => 'h-2.5',
                'progress-ring-size' => 'w-14 h-14',
            ],
            'xl' => [
                'wrapper' => 'relative',
                'viewport' => '',
                'container' => 'gap-6',
                'control-button' => 'w-14 h-14',
                'control-icon' => 'w-7 h-7',
                'controls-wrapper' => 'px-6',
                'dot-size' => 'w-3.5 h-3.5',
                'dots-gap' => 'gap-3',
                'counter' => 'text-lg',
                'navigation' => 'mt-6',
                'progress-height' => 'h-3',
                'progress-ring-size' => 'w-16 h-16',
            ],
        ];
    }

    public static function flyoutSizes(): array
    {
        return [
            'sm' => 'max-w-sm',
            'md' => 'max-w-md',
            'lg' => 'max-w-lg',
            'xl' => 'max-w-xl',
        ];
    }

    public static function kbdSizes(): array
    {
        return [
            'sm' => 'px-1.5 py-0.5 text-xs min-h-5 min-w-5',
            'md' => 'px-2 py-1 text-sm min-h-6 min-w-6',
            'lg' => 'px-3 py-1.5 text-base min-h-8 min-w-8',
        ];
    }
}
