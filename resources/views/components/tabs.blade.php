@props([
    'defaultValue' => null,
    'orientation' => 'horizontal',
    'activationMode' => 'automatic',
    'variant' => 'default'
])

@php
    $containerId = uniqid('tabs-');
    $isWireModel = $attributes->has('wire:model') || $attributes->has('wire:model.self');
    
    $containerClasses = [
        $getOrientationClasses(),
        $getVariantClasses()
    ];
@endphp

<div
    x-data="strataTabs({
        defaultValue: '{{ $defaultValue }}',
        orientation: '{{ $orientation }}',
        activationMode: '{{ $activationMode }}',
        variant: '{{ $variant }}',
        id: '{{ $containerId }}'
    })"
    x-init="init()"
    @if($isWireModel)
        x-model="activeTab"
    @endif
    data-tabs-container="{{ $containerId }}"
    {{ $attributes->except(['defaultValue', 'orientation', 'activationMode', 'variant', 'wire:model', 'wire:model.self'])->merge([
        'class' => implode(' ', array_filter($containerClasses))
    ]) }}
>
    {{ $slot }}
</div>

@once
<script>
document.addEventListener('alpine:init', () => {
    /**
     * Strata Tabs Component
     * @param {Object} config - Configuration object
     * @param {string|null} config.defaultValue - Initial active tab
     * @param {string} config.orientation - Tab orientation (horizontal|vertical)
     * @param {string} config.activationMode - Activation mode (automatic|manual)
     * @param {string} config.variant - Tab visual variant
     * @param {string} config.id - Unique container identifier
     * @returns {Object} Alpine component object
     */
    Alpine.data('strataTabs', (config) => ({
        activeTab: config.defaultValue || null,
        orientation: config.orientation || 'horizontal',
        activationMode: config.activationMode || 'automatic',
        variant: config.variant || 'default',
        containerId: config.id,
        triggers: [],
        contents: [],

        /**
         * Initialize component
         */
        init() {
            this.$nextTick(() => {
                this.discoverTabElements();
                this.setupKeyboardNavigation();
                this.setupAriaAttributes();
                
                if (!this.activeTab && this.triggers.length > 0) {
                    const firstEnabledTrigger = this.triggers.find(t => !t.disabled);
                    if (firstEnabledTrigger) {
                        this.activeTab = firstEnabledTrigger.value;
                    }
                }
            });

            if (this.$wire && this.$el.hasAttribute('x-model')) {
                this.$watch('activeTab', value => {
                    this.$wire.set(this.$el.getAttribute('x-model'), value);
                });
            }
        },

        /**
         * Discover and catalog tab elements
         */
        discoverTabElements() {
            const triggerElements = this.$el.querySelectorAll('[data-tab-trigger]');
            const contentElements = this.$el.querySelectorAll('[data-tab-content]');
            
            this.triggers = Array.from(triggerElements).map(el => ({
                element: el,
                value: el.dataset.tabTrigger,
                disabled: el.hasAttribute('disabled') || el.getAttribute('aria-disabled') === 'true'
            }));
            
            this.contents = Array.from(contentElements).map(el => ({
                element: el,
                value: el.dataset.tabContent,
                forceMount: el.hasAttribute('data-force-mount')
            }));
        },

        /**
         * Setup keyboard navigation
         */
        setupKeyboardNavigation() {
            this.triggers.forEach(trigger => {
                trigger.element.addEventListener('keydown', (e) => {
                    this.handleKeyboardNavigation(e, trigger.value);
                });
            });
        },

        /**
         * Handle keyboard navigation events
         */
        handleKeyboardNavigation(event, currentValue) {
            const enabledTriggers = this.triggers.filter(t => !t.disabled);
            const currentIndex = enabledTriggers.findIndex(t => t.value === currentValue);
            
            let targetIndex = currentIndex;
            
            switch (event.key) {
                case 'ArrowLeft':
                case 'ArrowUp':
                    event.preventDefault();
                    targetIndex = currentIndex > 0 ? currentIndex - 1 : enabledTriggers.length - 1;
                    break;
                case 'ArrowRight':
                case 'ArrowDown':
                    event.preventDefault();
                    targetIndex = currentIndex < enabledTriggers.length - 1 ? currentIndex + 1 : 0;
                    break;
                case 'Home':
                    event.preventDefault();
                    targetIndex = 0;
                    break;
                case 'End':
                    event.preventDefault();
                    targetIndex = enabledTriggers.length - 1;
                    break;
                case 'Enter':
                case ' ':
                    event.preventDefault();
                    this.activateTab(currentValue);
                    return;
                default:
                    return;
            }
            
            const targetTrigger = enabledTriggers[targetIndex];
            if (targetTrigger) {
                targetTrigger.element.focus();
                if (this.activationMode === 'automatic') {
                    this.activateTab(targetTrigger.value);
                }
            }
        },

        /**
         * Setup ARIA attributes for accessibility
         */
        setupAriaAttributes() {
            this.triggers.forEach(trigger => {
                const content = this.contents.find(c => c.value === trigger.value);
                if (content) {
                    const triggerId = `${this.containerId}-trigger-${trigger.value}`;
                    const contentId = `${this.containerId}-content-${trigger.value}`;
                    
                    trigger.element.id = triggerId;
                    trigger.element.setAttribute('aria-controls', contentId);
                    trigger.element.setAttribute('role', 'tab');
                    
                    content.element.id = contentId;
                    content.element.setAttribute('aria-labelledby', triggerId);
                    content.element.setAttribute('role', 'tabpanel');
                }
            });
            
            const tabList = this.$el.querySelector('[role="tablist"]');
            if (tabList) {
                tabList.setAttribute('aria-orientation', this.orientation);
            }
        },

        /**
         * Activate a specific tab
         */
        activateTab(value) {
            if (!value) return;
            
            const trigger = this.triggers.find(t => t.value === value);
            if (!trigger || trigger.disabled) return;
            
            this.activeTab = value;
            this.updateAriaStates();
            this.$dispatch('strata-tab-change', { activeTab: value, containerId: this.containerId });
            this.$dispatch('strata-tab-activated', { tab: value, containerId: this.containerId });
        },

        /**
         * Update ARIA states based on active tab
         */
        updateAriaStates() {
            this.triggers.forEach(trigger => {
                const isActive = trigger.value === this.activeTab;
                trigger.element.setAttribute('aria-selected', isActive ? 'true' : 'false');
                trigger.element.setAttribute('tabindex', isActive ? '0' : '-1');
            });
            
            this.contents.forEach(content => {
                const isActive = content.value === this.activeTab;
                content.element.setAttribute('aria-hidden', isActive ? 'false' : 'true');
            });
        },

        /**
         * Check if a tab is active
         */
        isActive(value) {
            return this.activeTab === value;
        },

        /**
         * Check if content should be shown
         */
        shouldShowContent(value, forceMount) {
            return forceMount || this.isActive(value);
        }
    }));
});
</script>
@endonce