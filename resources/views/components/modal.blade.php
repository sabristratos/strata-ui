@props([
    'name' => null,
    'variant' => 'default',
    'size' => 'md',
    'position' => 'center',
    'dismissible' => true
])

@php
    $modalId = $name ? 'modal-' . $name : uniqid('modal-');
    $isWireModel = $attributes->has('wire:model') || $attributes->has('wire:model.self');
    
    $backdropClasses = 'fixed inset-0 z-50 bg-black/50 backdrop-blur-sm';
    
    $containerClasses = [
        'fixed inset-0 z-50 flex',
        $variant === 'flyout' && $position === 'left' ? 'justify-start' : '',
        $variant === 'flyout' && $position === 'right' ? 'justify-end' : '',
        $variant === 'flyout' && $position === 'bottom' ? 'items-end' : '',
        $variant !== 'flyout' ? 'items-center justify-center p-4' : '',
    ];
    
    $modalClasses = [
        'relative w-full',
        $getSizeClasses(),
        $getVariantClasses(),
        $variant === 'flyout' ? $getFlyoutPositionClasses() : '',
        $variant !== 'bare' ? 'overflow-hidden' : '',
    ];
@endphp

<div
    x-data="strataModal({
        name: '{{ $name }}',
        dismissible: {{ $dismissible ? 'true' : 'false' }}
    })"
    x-show="show"
    @if($name)
        @strata-modal-show-{{ $name }}.window="showModal($event.detail)"
        @strata-modal-hide-{{ $name }}.window="hideModal()"
        @strata-modal-toggle-{{ $name }}.window="toggleModal($event.detail)"
    @endif
    @if($isWireModel)
        x-model="show"
    @endif
    @keydown.escape.window="dismissible && hideModal()"
    style="display: none;"
    {{ $attributes->except(['name', 'variant', 'size', 'position', 'dismissible', 'wire:model', 'wire:model.self']) }}
>
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @if($dismissible)
            @click="hideModal()"
        @endif
        @class([$backdropClasses])
    ></div>
    
    <div 
        @class(array_filter($containerClasses))
        @if($dismissible && $variant === 'flyout')
            @click="hideModal()"
        @endif
    >
        <div
            x-show="show"
            @click.stop
            x-trap.noscroll="show"
            role="dialog"
            aria-modal="true"
            :aria-labelledby="name ? 'modal-title-' + name : null"
            :aria-describedby="name ? 'modal-description-' + name : null"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 {{ $variant === 'flyout' ? ($position === 'bottom' ? 'translate-y-full' : ($position === 'left' ? '-translate-x-full' : 'translate-x-full')) : 'scale-95' }}"
            x-transition:enter-end="opacity-100 {{ $variant === 'flyout' ? 'translate-x-0 translate-y-0' : 'scale-100' }}"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 {{ $variant === 'flyout' ? 'translate-x-0 translate-y-0' : 'scale-100' }}"
            x-transition:leave-end="opacity-0 {{ $variant === 'flyout' ? ($position === 'bottom' ? 'translate-y-full' : ($position === 'left' ? '-translate-x-full' : 'translate-x-full')) : 'scale-95' }}"
            @class(array_filter($modalClasses))
        >
            @if($dismissible && $variant !== 'bare')
                <div class="absolute right-4 top-4 z-10">
                    <x-strata::button
                        variant="ghost"
                        size="sm"
                        icon="heroicon-o-x-mark"
                        @click="hideModal()"
                        class="!p-1.5 hover:bg-muted"
                        aria-label="Close modal"
                    />
                </div>
            @endif
            
            @if($variant !== 'bare')
                <div class="p-6">
                    {{ $slot }}
                </div>
            @else
                {{ $slot }}
            @endif
        </div>
    </div>
</div>


@once
<script>
document.addEventListener('alpine:initializing', () => {
    
    /**
     * Strata Modal Component
     * @param {Object} config - Configuration object
     * @param {string|null} config.name - Unique modal identifier
     * @param {boolean} config.dismissible - Whether modal can be dismissed
     * @returns {Object} Alpine component object
     */
    Alpine.data('strataModal', (config) => ({
        show: false,
        name: config.name || null,
        dismissible: config.dismissible !== false,

        /**
         * Initialize component
         */
        init() {
            if (this.$wire && this.$el.hasAttribute('x-model')) {
                this.$watch('show', value => {
                    this.$wire.set(this.$el.getAttribute('x-model'), value);
                });
            }
        },

        /**
         * Show the modal
         * @param {Object} data - Optional data to pass with modal opening
         */
        showModal(data = {}) {
            const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
            
            document.body.style.overflow = 'hidden';
            if (scrollbarWidth > 0) {
                document.body.style.paddingRight = `${scrollbarWidth}px`;
            }
            
            this.show = true;
            this.$dispatch('strata-modal-opened', { name: this.name, data });
            
            this.$nextTick(() => {
                const focusable = this.$el.querySelector(
                    'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
                );
                if (focusable) {
                    focusable.focus();
                }
            });
        },

        /**
         * Hide the modal
         */
        hideModal() {
            this.show = false;
            this.$dispatch('strata-modal-closed', { name: this.name });
            this.$dispatch('close');
            this.$dispatch('cancel');
            
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        },

        /**
         * Toggle modal visibility
         * @param {Object} data - Optional data to pass when opening
         */
        toggleModal(data = {}) {
            if (this.show) {
                this.hideModal();
            } else {
                this.showModal(data);
            }
        }
    }));
});
</script>
@endonce

{{-- Session modal data for JavaScript API --}}
@if (session()->has('strata_modal'))
    <script data-strata-session-modal>
        @json(session('strata_modal'))
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sessionModalScript = document.querySelector('script[data-strata-session-modal]');
            if (sessionModalScript) {
                try {
                    const modalData = JSON.parse(sessionModalScript.textContent);
                    if (modalData.id) {
                        // Delay slightly to ensure modals are rendered
                        setTimeout(() => {
                            window.dispatchEvent(new CustomEvent(`strata-modal-show-${modalData.id}`, { detail: modalData }));
                        }, 100);
                    }
                } catch (e) {
                    console.warn('Failed to parse session modal data:', e);
                }
            }
        });
    </script>
@endif