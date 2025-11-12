@props([
    'name' => null,
    'size' => 'md',
    'variant' => 'modal',
    'position' => 'right',
    'dismissible' => true,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$baseClasses = 'fixed @container p-0 border-0 bg-transparent overflow-visible';
$backdropClasses = 'backdrop:bg-neutral-950/80 dark:backdrop:bg-neutral-950/95 backdrop:backdrop-blur-sm backdrop:transition-all backdrop:duration-150';

if ($variant === 'flyout') {
    $flyoutSizes = ComponentSizeConfig::flyoutSizes();

    $sizeClasses = $flyoutSizes[$size] ?? $flyoutSizes['md'];

    $positionClasses = match($position) {
        'left' => 'inset-y-0 left-0 right-auto translate-x-[-100%] open:translate-x-0 starting:open:translate-x-[-100%] border-e border-border',
        'right' => 'inset-y-0 left-auto right-0 translate-x-[100%] open:translate-x-0 starting:open:translate-x-[100%] border-s border-border',
        default => 'inset-y-0 left-auto right-0 translate-x-[100%] open:translate-x-0 starting:open:translate-x-[100%] border-s border-border',
    };

    $baseClasses = 'fixed @container m-0 flex flex-col overflow-hidden bg-dialog text-dialog-foreground shadow-2xl';
    $variantClasses = "w-full min-h-dvh max-h-dvh $sizeClasses transition-all duration-150 ease-out $positionClasses";
} else {
    $sizes = ComponentSizeConfig::modalSizes();

    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $variantClasses = "inset-0 m-auto w-full $sizeClasses opacity-0 scale-95 open:opacity-100 open:scale-100 starting:open:opacity-0 starting:open:scale-95 transition-all duration-150 ease-out";

    $contentClasses = "relative bg-dialog text-dialog-foreground border border-border rounded-lg shadow-2xl w-full";
}

$classes = trim("$baseClasses $variantClasses $backdropClasses");

$wireModelAttrs = $attributes->whereStartsWith('wire:model');
$wireName = $wireModelAttrs->first();

$processedAttributes = $attributes->filter(function($value, $key) {
    return !str_starts_with($key, 'wire:model');
});

if ($wireModelAttrs->isNotEmpty()) {
    $processedAttributes = $processedAttributes->merge(['wire:model.self' => $wireName]);
}
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataModal', (name, dismissible, wireName) => ({
        name: name,
        dismissible: dismissible,
        wireName: wireName,
        dialog: null,

        init() {
            this.dialog = this.$el;

            if (this.wireName) {
                this.$watch('$wire.' + this.wireName, (value) => {
                    if (value) {
                        this.open();
                    } else {
                        this.close();
                    }
                });

                if (this.$wire && this.$wire[this.wireName]) {
                    this.open();
                }
            }

            if (this.name) {
                window.addEventListener('modal-open-' + this.name, () => {
                    this.open();
                });

                window.addEventListener('modal-close-' + this.name, () => {
                    this.close();
                });

                window.addEventListener('modal-toggle-' + this.name, () => {
                    this.toggle();
                });
            }

            this.dialog.addEventListener('click', (e) => {
                if (this.dismissible && e.target === this.dialog) {
                    const rect = this.dialog.getBoundingClientRect();
                    if (
                        e.clientX < rect.left ||
                        e.clientX > rect.right ||
                        e.clientY < rect.top ||
                        e.clientY > rect.bottom
                    ) {
                        this.cancel();
                    }
                }
            });

            this.dialog.addEventListener('cancel', (e) => {
                if (!this.dismissible) {
                    e.preventDefault();
                } else {
                    this.cancel();
                }
            });

            this.dialog.addEventListener('close', () => {
                this.onClose();
            });
        },

        open() {
            if (!this.dialog.open) {
                this.dialog.showModal();
                this.$dispatch('modal-opened', { name: this.name });

                if (this.wireName && this.$wire) {
                    this.$wire.set(this.wireName, true);
                }
            }
        },

        close() {
            if (this.dialog.open) {
                this.dialog.close();
            }
        },

        toggle() {
            if (this.dialog.open) {
                this.close();
            } else {
                this.open();
            }
        },

        cancel() {
            this.$dispatch('modal-cancelled', { name: this.name });
            this.close();
        },

        onClose() {
            this.$dispatch('modal-closed', { name: this.name });

            if (this.wireName && this.$wire) {
                this.$wire.set(this.wireName, false);
            }
        }
    }));
});
</script>
@endonce

<dialog
    wire:ignore.self
    x-data="strataModal(@js($name), @js($dismissible), @js($wireName))"
    data-strata-modal
    @if($name) data-modal-name="{{ $name }}" @endif
    {{ $processedAttributes->merge(['class' => $classes]) }}
>
    @if($variant === 'flyout')
        {{ $slot }}
    @else
        <div class="{{ $contentClasses }}">
            {{ $slot }}
        </div>
    @endif
</dialog>
