<?php

namespace Stratos\StrataUI;

use Livewire\Component;

class Strata
{
    protected ?Component $component = null;

    public function __construct(?Component $component = null)
    {
        $this->component = $component;
    }

    public static function toast(?Component $component = null): ToastBuilder
    {
        return new ToastBuilder($component);
    }
}

class ToastBuilder
{
    protected ?Component $component = null;

    public function __construct(?Component $component = null)
    {
        $this->component = $component;
    }

    public function success(string $title, ?string $description = null): void
    {
        $this->dispatch('success', $title, $description);
    }

    public function error(string $title, ?string $description = null): void
    {
        $this->dispatch('error', $title, $description);
    }

    public function warning(string $title, ?string $description = null): void
    {
        $this->dispatch('warning', $title, $description);
    }

    public function info(string $title, ?string $description = null): void
    {
        $this->dispatch('info', $title, $description);
    }

    public function show(array $options): void
    {
        $this->dispatch(
            $options['variant'] ?? 'info',
            $options['title'] ?? null,
            $options['description'] ?? $options['message'] ?? '',
            $options['duration'] ?? null,
            $options['dismissible'] ?? true
        );
    }

    protected function dispatch(
        string $variant,
        ?string $title,
        ?string $description = null,
        ?int $duration = null,
        bool $dismissible = true
    ): void {
        $options = [
            'variant' => $variant,
            'title' => $title,
            'description' => $description,
            'dismissible' => $dismissible,
        ];

        if ($duration !== null) {
            $options['duration'] = $duration;
        }

        $options = array_filter($options, fn ($value) => $value !== null);

        if ($this->component) {
            $this->component->dispatch('strata:toast', ...$options);
        }
    }
}
