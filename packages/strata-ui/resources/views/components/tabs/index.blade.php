@props([
    'default' => null,
    'orientation' => 'horizontal',
])

@php
$tabsId = $attributes->get('id') ?? 'tabs-' . uniqid();
$orientations = [
    'horizontal' => 'flex flex-col gap-4',
    'vertical' => 'flex flex-row gap-4',
];
$orientationClasses = $orientations[$orientation] ?? $orientations['horizontal'];
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataTabs', (defaultValue, orientation, tabsId) => ({
        selected: defaultValue,
        orientation: orientation,
        tabsId: tabsId,

        init() {
            if (!this.selected) {
                const firstTrigger = this.$el.querySelector('[data-strata-tabs-trigger]:not([disabled])');
                if (firstTrigger) {
                    this.selected = firstTrigger.dataset.tabValue;
                }
            }

            const activeTrigger = this.$el.querySelector(`[data-tab-value="${this.selected}"]`);
            if (activeTrigger) {
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => this.updateMarker(activeTrigger));
                });
            }

            window.addEventListener('resize', () => {
                const activeTrigger = this.$el.querySelector(`[data-tab-value="${this.selected}"]`);
                if (activeTrigger) this.updateMarker(activeTrigger);
            });
        },

        select(triggerElement) {
            if (!triggerElement) return;
            this.selected = triggerElement.dataset.tabValue;
            this.updateMarker(triggerElement);
        },

        isSelected(value) {
            return this.selected === value;
        },

        updateMarker(triggerElement) {
            const marker = this.$refs.marker;
            const list = this.$el.querySelector('[data-strata-tabs-list]');
            const variant = list?.dataset.variant;

            if (!marker || !triggerElement) return;

            if (this.orientation === 'horizontal') {
                marker.style.width = triggerElement.offsetWidth + 'px';
                marker.style.left = triggerElement.offsetLeft + 'px';

                if (variant === 'pills') {
                    marker.style.height = triggerElement.offsetHeight + 'px';
                    marker.style.top = triggerElement.offsetTop + 'px';
                }
            } else {
                marker.style.width = triggerElement.offsetWidth + 'px';
                marker.style.height = triggerElement.offsetHeight + 'px';
                marker.style.left = triggerElement.offsetLeft + 'px';
                marker.style.top = triggerElement.offsetTop + 'px';
            }
        },
    }));
});
</script>
@endonce

<div
    x-data="strataTabs(@js($default), @js($orientation), @js($tabsId))"
    data-strata-tabs
    {{ $attributes->merge(['class' => $orientationClasses]) }}
>
    {{ $slot }}
</div>
