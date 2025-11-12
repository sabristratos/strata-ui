<?php

namespace Stratos\StrataUI\Helpers;

class ButtonVariants
{
    public static function filled(): array
    {
        return [
            'primary' => 'bg-primary text-primary-foreground hover:bg-primary-hover active:bg-primary-active shadow-sm',
            'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary-hover active:bg-secondary-active shadow-sm',
            'success' => 'bg-success text-success-foreground hover:bg-success-hover active:bg-success-active shadow-sm',
            'warning' => 'bg-warning text-warning-foreground hover:bg-warning-hover active:bg-warning-active shadow-sm',
            'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive-hover active:bg-destructive-active shadow-sm',
            'info' => 'bg-info text-info-foreground hover:bg-info-hover active:bg-info-active shadow-sm',
        ];
    }

    public static function outlined(): array
    {
        return [
            'primary' => 'bg-transparent text-primary border border-primary hover:bg-primary/10 active:bg-primary/20',
            'secondary' => 'bg-transparent text-secondary-foreground border border-secondary-foreground hover:bg-secondary-hover/10 active:bg-secondary-hover/20',
            'success' => 'bg-transparent text-success border border-success hover:bg-success/10 active:bg-success/20',
            'warning' => 'bg-transparent text-warning border border-warning hover:bg-warning/10 active:bg-warning/20',
            'destructive' => 'bg-transparent text-destructive border border-destructive hover:bg-destructive/10 active:bg-destructive/20',
            'info' => 'bg-transparent text-info border border-info hover:bg-info/10 active:bg-info/20',
        ];
    }

    public static function ghost(): array
    {
        return [
            'primary' => 'bg-transparent text-primary hover:bg-primary/10 active:bg-primary/20',
            'secondary' => 'bg-transparent text-secondary-foreground hover:bg-accent-hover/40 active:bg-accent-active/60',
            'success' => 'bg-transparent text-success hover:bg-success/10 active:bg-success/20',
            'warning' => 'bg-transparent text-warning hover:bg-warning/10 active:bg-warning/20',
            'destructive' => 'bg-transparent text-destructive hover:bg-destructive/10 active:bg-destructive/20',
            'info' => 'bg-transparent text-info hover:bg-info/10 active:bg-info/20',
        ];
    }

    public static function link(): array
    {
        return [
            'primary' => 'bg-transparent text-primary hover:underline active:opacity-70',
            'secondary' => 'bg-transparent text-secondary-foreground hover:underline active:opacity-70',
            'success' => 'bg-transparent text-success hover:underline active:opacity-70',
            'warning' => 'bg-transparent text-warning hover:underline active:opacity-70',
            'destructive' => 'bg-transparent text-destructive hover:underline active:opacity-70',
            'info' => 'bg-transparent text-info hover:underline active:opacity-70',
        ];
    }
}
