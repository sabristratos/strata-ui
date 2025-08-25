<?php

declare(strict_types=1);

namespace Strata\UI;

use Strata\UI\ValueObjects\Modal;
use Strata\UI\ValueObjects\Toast;

class StrataUIService
{
    /**
     * Dispatch a standard toast notification with optional action buttons.
     */
    public function toast(
        string $message,
        ?string $title = null,
        string $variant = 'info',
        int $duration = 5000,
        ?string $icon = null,
        ?array $actions = null
    ): void {
        $toast = new Toast(
            message: $message,
            title: $title,
            variant: $variant,
            duration: $duration,
            icon: $icon,
            actions: $actions,
        );

        session()->flash('strata_toast', $toast->toArray());
    }

    /**
     * Dispatch a modal dialog with optional actions.
     */
    public function modal(
        ?string $content = null,
        ?string $title = null,
        string $size = 'md',
        string $variant = 'default',
        bool $closable = true,
        bool $backdrop = true,
        ?array $actions = null,
        ?string $id = null
    ): void {
        $modal = new Modal(
            id: $id,
            title: $title,
            content: $content,
            size: $size,
            variant: $variant,
            closable: $closable,
            backdrop: $backdrop,
            actions: $actions,
        );

        session()->flash('strata_modal', $modal->toArray());
    }

    /**
     * Get modal helper for Livewire components to control specific modals.
     */
    public function modalControl(?string $name = null): object
    {
        return new class($name) {
            public function __construct(private ?string $name = null) {}
            
            public function show(array $data = []): void
            {
                if (!$this->name) {
                    throw new \InvalidArgumentException('Modal name is required to show a modal');
                }
                
                // Store data to dispatch via JavaScript
                session()->put("strata_modal_show_{$this->name}", $data);
                
                // Dispatch Livewire event to trigger the modal
                if (function_exists('dispatch')) {
                    dispatch('strata-modal-show', [
                        'name' => $this->name,
                        'data' => $data
                    ])->self();
                }
            }
            
            public function hide(): void
            {
                if (!$this->name) {
                    throw new \InvalidArgumentException('Modal name is required to hide a modal');
                }
                
                // Dispatch Livewire event to hide the modal
                if (function_exists('dispatch')) {
                    dispatch('strata-modal-hide', [
                        'name' => $this->name
                    ])->self();
                }
            }
            
            public function toggle(array $data = []): void
            {
                if (!$this->name) {
                    throw new \InvalidArgumentException('Modal name is required to toggle a modal');
                }
                
                // Dispatch Livewire event to toggle the modal
                if (function_exists('dispatch')) {
                    dispatch('strata-modal-toggle', [
                        'name' => $this->name,
                        'data' => $data
                    ])->self();
                }
            }
        };
    }

    /**
     * Get modals helper for controlling all modals.
     */
    public function modals(): object
    {
        return new class {
            public function close(): void
            {
                // Dispatch Livewire event to close all modals
                if (function_exists('dispatch')) {
                    dispatch('strata-modals-close-all')->self();
                }
            }
        };
    }
}