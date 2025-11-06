@props([
    'label' => null,
    'icon' => null,
    'disabled' => false,
    'trigger' => 'hover',
    'placement' => 'right-start',
    'offset' => 4,
])

@php
use Stratos\StrataUI\Support\ComponentHelpers;

$submenuId = ComponentHelpers::generateId('submenu', null, null);
$itemId = ComponentHelpers::generateId('dropdown-item', null, null);

$baseClasses = 'w-full flex items-center gap-3 px-4 py-2 text-left text-sm transition-colors duration-150 rounded-md';

$stateClasses = $disabled
    ? 'opacity-50 cursor-not-allowed'
    : 'text-foreground hover:bg-muted focus:bg-muted cursor-pointer';

$classes = trim("$baseClasses $stateClasses");
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataSubmenu', (submenuId, placement, offset, trigger, disabled) => ({
        ...window.createPositionableMixin({
            placement: placement,
            offset: offset,
            triggerRef: 'submenuTrigger',
            floatingRef: 'submenuContent'
        }),

        open: false,
        hoverTimeout: null,

        init() {
            if (disabled) return;

            this.initPositionable();

            const contentParent = this.$el.closest('[data-strata-dropdown-content]');
            if (contentParent) {
                contentParent.addEventListener('submenu-opening', (e) => {
                    if (e.detail.id !== submenuId && this.open) {
                        this.close();
                    }
                });
            }
        },

        handleMouseEnter() {
            if (disabled || trigger === 'click') return;

            clearTimeout(this.hoverTimeout);
            this.hoverTimeout = setTimeout(() => {
                this.openSubmenu();
            }, 100);
        },

        handleMouseLeave() {
            if (disabled || trigger === 'click') return;

            clearTimeout(this.hoverTimeout);
            this.hoverTimeout = setTimeout(() => {
                this.open = false;
            }, 200);
        },

        handleClick() {
            if (disabled) return;

            if (trigger === 'click' || trigger === 'both') {
                if (!this.open) {
                    this.openSubmenu();
                } else {
                    this.close();
                }
            }
        },

        handleKeydown(e) {
            if (disabled) return;

            if (e.key === 'ArrowRight' || e.key === 'Enter') {
                e.preventDefault();
                e.stopPropagation();
                this.openSubmenu();
                this.$nextTick(() => {
                    this.$refs.submenuContent?.focus({ preventScroll: true });
                });
            } else if (e.key === 'ArrowLeft') {
                e.preventDefault();
                e.stopPropagation();
                this.close();
            }
        },

        openSubmenu() {
            const contentParent = this.$el.closest('[data-strata-dropdown-content]');
            if (contentParent) {
                contentParent.dispatchEvent(new CustomEvent('submenu-opening', {
                    detail: { id: submenuId },
                    bubbles: false
                }));
            }
            this.open = true;
        },

        close() {
            this.open = false;
        },
    }));
});
</script>
@endonce

<div
    x-data="strataSubmenu('{{ $submenuId }}', '{{ $placement }}', {{ $offset }}, '{{ $trigger }}', {{ $disabled ? 'true' : 'false' }})"
    @mouseenter="handleMouseEnter()"
    @mouseleave="handleMouseLeave()"
    data-strata-dropdown-submenu
>
    <button
        type="button"
        x-ref="submenuTrigger"
        id="{{ $itemId }}"
        data-strata-dropdown-item
        @if($disabled) data-disabled @endif
        role="menuitem"
        aria-haspopup="true"
        :aria-expanded="open"
        tabindex="-1"
        @click.stop="handleClick()"
        @keydown="handleKeydown($event)"
        {{ $attributes->only(['class', 'style'])->merge(['class' => $classes]) }}
    >
        @if($icon)
            <span class="flex-shrink-0">
                <x-dynamic-component :component="'strata::icon.' . $icon" class="w-4 h-4" />
            </span>
        @endif

        <span class="flex-1">
            {{ $label }}
        </span>

        <span class="flex-shrink-0">
            <x-strata::icon.chevron-right class="w-4 h-4" />
        </span>
    </button>

    <div
        x-ref="submenuContent"
        x-cloak
        x-show="open"
        :style="positionable?.styles"
        x-trap.nofocus="open"
        @click.outside="close()"
        @keydown.escape="close()"
        @mouseenter="$dispatch('submenu-enter')"
        @mouseleave="$dispatch('submenu-leave')"
        tabindex="-1"
        data-strata-dropdown-content
        role="menu"
        wire:ignore.self
        class="absolute z-[100] min-w-64 max-w-96 bg-popover text-popover-foreground border border-border rounded-lg shadow-xl backdrop-blur-sm ring-1 ring-black/5 dark:ring-white/10 py-1 transition-all transition-discrete duration-150 ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95"
    >
        <div class="max-h-96 overflow-y-auto overflow-x-hidden p-1 space-y-1">
            {{ $slot }}
        </div>
    </div>
</div>
