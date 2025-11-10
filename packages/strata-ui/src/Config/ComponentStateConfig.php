<?php

namespace Stratos\StrataUI\Config;

class ComponentStateConfig
{
    public static function inputStates(): array
    {
        return [
            'default' => 'border-border focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2',
            'success' => 'border-success focus-within:ring-2 focus-within:ring-success/20 focus-within:ring-offset-2',
            'error' => 'border-destructive focus-within:ring-2 focus-within:ring-destructive/20 focus-within:ring-offset-2',
            'warning' => 'border-warning focus-within:ring-2 focus-within:ring-warning/20 focus-within:ring-offset-2',
        ];
    }

    public static function focusableStates(): array
    {
        return [
            'default' => 'border-border focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2',
            'success' => 'border-success focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-success/20 focus-visible:ring-offset-2',
            'error' => 'border-destructive focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-destructive/20 focus-visible:ring-offset-2',
            'warning' => 'border-warning focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-warning/20 focus-visible:ring-offset-2',
        ];
    }

    public static function pickerStates(): array
    {
        return [
            'default' => 'border-border focus-within:ring-ring',
            'success' => 'border-success focus-within:ring-success/20',
            'error' => 'border-destructive focus-within:ring-destructive/20',
            'warning' => 'border-warning focus-within:ring-warning/20',
        ];
    }

    public static function checkableStates(): array
    {
        return [
            'default' => 'border-border hover:border-primary/50 focus:ring-ring accent-primary',
            'success' => 'border-success hover:border-success/80 focus:ring-success accent-success',
            'error' => 'border-destructive hover:border-destructive/80 focus:ring-destructive accent-destructive',
            'warning' => 'border-warning hover:border-warning/80 focus:ring-warning accent-warning',
        ];
    }

    public static function toggleStates(): array
    {
        return [
            'default' => [
                'track' => 'bg-muted group-has-[:checked]:bg-primary focus:ring-primary',
                'thumb' => 'bg-body',
            ],
            'success' => [
                'track' => 'bg-muted group-has-[:checked]:bg-success focus:ring-success',
                'thumb' => 'bg-body',
            ],
            'error' => [
                'track' => 'bg-muted group-has-[:checked]:bg-destructive focus:ring-destructive',
                'thumb' => 'bg-body',
            ],
            'warning' => [
                'track' => 'bg-muted group-has-[:checked]:bg-warning focus:ring-warning',
                'thumb' => 'bg-body',
            ],
        ];
    }

    public static function sliderStates(): array
    {
        return [
            'default' => [
                'track' => 'bg-muted',
                'range' => 'bg-primary',
                'handle' => 'bg-primary border-2 border-background ring-offset-background focus-visible:ring-2 focus-visible:ring-ring',
            ],
            'success' => [
                'track' => 'bg-muted',
                'range' => 'bg-success',
                'handle' => 'bg-success border-2 border-background ring-offset-background focus-visible:ring-2 focus-visible:ring-success/20',
            ],
            'error' => [
                'track' => 'bg-muted',
                'range' => 'bg-destructive',
                'handle' => 'bg-destructive border-2 border-background ring-offset-background focus-visible:ring-2 focus-visible:ring-destructive/20',
            ],
            'warning' => [
                'track' => 'bg-muted',
                'range' => 'bg-warning',
                'handle' => 'bg-warning border-2 border-background ring-offset-background focus-visible:ring-2 focus-visible:ring-warning/20',
            ],
        ];
    }

    public static function ratingStates(): array
    {
        return [
            'default' => 'text-yellow-400',
            'success' => 'text-success',
            'error' => 'text-destructive',
            'warning' => 'text-warning',
        ];
    }

    public static function fileInputStates(): array
    {
        return [
            'default' => 'border-border bg-secondary hover:border-primary hover:bg-muted/50',
            'success' => 'border-success bg-success/5 hover:bg-success/10',
            'error' => 'border-destructive bg-destructive/5 hover:bg-destructive/10',
            'warning' => 'border-warning bg-warning/5 hover:bg-warning/10',
        ];
    }

    public static function carouselStates(): array
    {
        return [
            'default' => [
                'wrapper' => '',
                'control-button' => 'bg-background/80 backdrop-blur-sm hover:bg-background text-foreground border border-border shadow-lg',
                'dot-active' => 'bg-primary',
                'dot-inactive' => 'bg-muted-foreground/30',
                'counter' => 'text-muted-foreground',
            ],
            'primary' => [
                'wrapper' => '',
                'control-button' => 'bg-primary/80 backdrop-blur-sm hover:bg-primary text-primary-foreground shadow-lg',
                'dot-active' => 'bg-primary',
                'dot-inactive' => 'bg-primary/20',
                'counter' => 'text-muted-foreground',
            ],
        ];
    }
}
