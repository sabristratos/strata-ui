@props([
    'position' => 'bottom-right',
    'duration' => 5000,
])

<div
    x-data="strataToast('{{ $position }}', {{ $duration }})"
    data-strata-toast
    {{ $attributes->class('pointer-events-none') }}
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            :id="`toast-${toast.id}`"
            popover="manual"
            :style="getToastStyles(toast)"
            @mouseenter="pauseTimer(toast)"
            @mouseleave="resumeTimer(toast)"
            role="alert"
            class="pointer-events-auto max-w-md m-0
                   [bottom:var(--toast-bottom)] [right:var(--toast-right)] [left:var(--toast-left)] [top:var(--toast-top)]
                   bg-card text-card-foreground border rounded-lg shadow-lg overflow-hidden
                   [transition:opacity_200ms,transform_200ms,overlay_200ms_allow-discrete,display_200ms_allow-discrete]
                   transition-[opacity,transform,overlay,display] ease-out will-change-[transform,opacity]"
            :class="{
                'border-info/20 bg-info/10': toast.variant === 'info',
                'border-success/20 bg-success/10': toast.variant === 'success',
                'border-warning/20 bg-warning/10': toast.variant === 'warning',
                'border-destructive/20 bg-destructive/10': toast.variant === 'error',
                'toast-slide-right': ['top-right', 'bottom-right'].includes('{{ $position }}'),
                'toast-slide-left': ['top-left', 'bottom-left'].includes('{{ $position }}'),
                'toast-slide-down': ['top-center', 'bottom-center'].includes('{{ $position }}'),
            }"
        >
            <div
                x-show="toast.duration > 0 && toast.progress !== null"
                class="absolute bottom-0 left-0 h-1 transition-all duration-100 rounded-bl-lg rounded-br-lg"
                :class="{
                    'bg-info-subtle': toast.variant === 'info',
                    'bg-success-subtle': toast.variant === 'success',
                    'bg-warning-subtle': toast.variant === 'warning',
                    'bg-destructive-subtle': toast.variant === 'error'
                }"
                :style="`width: ${toast.progress}%`"
            ></div>

            <div class="flex items-start gap-3 p-4">
                <div class="flex-shrink-0 pt-0.5">
                    <div x-show="toast.variant === 'info'">
                        <x-strata::icon.info class="size-5 text-info" />
                    </div>
                    <div x-show="toast.variant === 'success'">
                        <x-strata::icon.check-circle class="size-5 text-success" />
                    </div>
                    <div x-show="toast.variant === 'warning'">
                        <x-strata::icon.alert-triangle class="size-5 text-warning" />
                    </div>
                    <div x-show="toast.variant === 'error'">
                        <x-strata::icon.x-circle class="size-destructive" />
                    </div>
                </div>

                <div class="flex-1 min-w-0">
                    <h5
                        x-show="toast.title"
                        x-text="toast.title"
                        class="font-semibold text-sm mb-1"
                        :class="{
                            'text-info': toast.variant === 'info',
                            'text-success': toast.variant === 'success',
                            'text-warning': toast.variant === 'warning',
                            'text-destructive': toast.variant === 'error'
                        }"
                    ></h5>
                    <p
                        x-show="toast.description"
                        x-text="toast.description"
                        class="text-sm text-muted-foreground"
                    ></p>
                </div>

                <x-strata::button.icon
                    icon="x"
                    size="sm"
                    variant="secondary"
                    appearance="ghost"
                    x-show="toast.dismissible"
                    @click="removeToast(toast.id)"
                    aria-label="Dismiss notification"
                    class="flex-shrink-0 !p-1 -mr-1"
                />
            </div>
        </div>
    </template>
</div>

@once
<style>
@starting-style {
    [popover][id^="toast-"]:popover-open {
        opacity: 0;
    }
    [popover][id^="toast-"]:popover-open.toast-slide-right {
        transform: translateX(100%);
    }
    [popover][id^="toast-"]:popover-open.toast-slide-left {
        transform: translateX(-100%);
    }
    [popover][id^="toast-"]:popover-open.toast-slide-down {
        transform: translateY(1rem);
    }
}

[popover][id^="toast-"]:popover-open {
    opacity: 1;
    transform: translate(0, 0);
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataToast', (position = 'bottom-right', defaultDuration = 5000) => ({
        toasts: [],
        position: position,
        defaultDuration: defaultDuration,

        init() {
            window.addEventListener('strata:toast', (e) => {
                this.addToast(e.detail);
            });
        },

        getToastStyles(toast) {
            const index = this.toasts.indexOf(toast);
            const offset = index * 80;

            const styles = {
                'bottom-right': `--toast-bottom: ${16 + offset}px; --toast-right: 16px; --toast-left: auto; --toast-top: auto;`,
                'bottom-left': `--toast-bottom: ${16 + offset}px; --toast-left: 16px; --toast-right: auto; --toast-top: auto;`,
                'top-right': `--toast-top: ${16 + offset}px; --toast-right: 16px; --toast-left: auto; --toast-bottom: auto;`,
                'top-left': `--toast-top: ${16 + offset}px; --toast-left: 16px; --toast-right: auto; --toast-bottom: auto;`,
                'top-center': `--toast-top: ${16 + offset}px; --toast-left: 50%; --toast-right: auto; --toast-bottom: auto; transform: translateX(-50%);`,
                'bottom-center': `--toast-bottom: ${16 + offset}px; --toast-left: 50%; --toast-right: auto; --toast-top: auto; transform: translateX(-50%);`,
            };

            return styles[this.position] || styles['bottom-right'];
        },

        addToast(options) {
            if (typeof options === 'string') {
                options = { description: options };
            }

            const toast = {
                id: crypto.randomUUID(),
                variant: options.variant || 'info',
                title: options.title || null,
                description: options.description || options.message || '',
                dismissible: options.dismissible !== false,
                duration: options.duration !== undefined ? options.duration : this.defaultDuration,
                progress: 100,
                progressTimer: null
            };

            this.toasts.push(toast);

            this.$nextTick(() => {
                const toastElement = document.getElementById(`toast-${toast.id}`);
                if (toastElement) {
                    toastElement.showPopover();
                }
            });

            if (toast.duration > 0) {
                this.startTimer(toast);
            }
        },

        startTimer(toast) {
            const interval = 50;
            const decrement = (100 / toast.duration) * interval;

            toast.progressTimer = setInterval(() => {
                toast.progress -= decrement;

                if (toast.progress <= 0) {
                    this.removeToast(toast.id);
                }
            }, interval);
        },

        pauseTimer(toast) {
            if (toast.progressTimer) {
                clearInterval(toast.progressTimer);
                toast.progressTimer = null;
            }
        },

        resumeTimer(toast) {
            if (toast.duration > 0 && !toast.progressTimer && toast.progress > 0) {
                this.startTimer(toast);
            }
        },

        removeToast(id) {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index > -1) {
                const toast = this.toasts[index];

                if (toast.progressTimer) {
                    clearInterval(toast.progressTimer);
                }

                const toastElement = document.getElementById(`toast-${id}`);
                if (toastElement) {
                    toastElement.addEventListener('toggle', (e) => {
                        if (e.newState === 'closed') {
                            this.toasts.splice(this.toasts.findIndex(t => t.id === id), 1);
                        }
                    }, { once: true });

                    toastElement.hidePopover();
                } else {
                    this.toasts.splice(index, 1);
                }
            }
        }
    }));
});
</script>
@endonce
