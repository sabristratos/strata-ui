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
                   bg-card text-card-foreground border rounded-lg shadow-lg overflow-hidden"
            :class="{
                'border-secondary/20 bg-secondary-subtle': toast.variant === 'neutral',
                'border-info/20 bg-info-subtle': toast.variant === 'info',
                'border-success/20 bg-success-subtle': toast.variant === 'success',
                'border-warning/20 bg-warning-subtle': toast.variant === 'warning',
                'border-destructive/20 bg-destructive-subtle': toast.variant === 'error',
                'animate-slide-right': ['top-right', 'bottom-right'].includes('{{ $position }}'),
                'animate-slide-left': ['top-left', 'bottom-left'].includes('{{ $position }}'),
                'animate-slide-up': ['top-center', 'bottom-center'].includes('{{ $position }}'),
            }"
        >
            <div
                x-show="toast.duration > 0 && toast.progress !== null"
                class="absolute bottom-0 left-0 h-1 transition-all duration-100 rounded-bl-lg rounded-br-lg"
                :class="{
                    'bg-secondary-subtle': toast.variant === 'neutral',
                    'bg-info-subtle': toast.variant === 'info',
                    'bg-success-subtle': toast.variant === 'success',
                    'bg-warning-subtle': toast.variant === 'warning',
                    'bg-destructive-subtle': toast.variant === 'error'
                }"
                :style="`width: ${toast.progress}%`"
            ></div>

            <div class="flex items-start gap-3 p-4">
                <div class="flex-shrink-0">
                    <div x-show="toast.variant === 'neutral'">
                        <x-strata::icon.bell class="size-5 text-secondary-foreground" />
                    </div>
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

                <div class="flex-1 min-w-0 flex flex-col gap-1">
                    <h5
                        x-show="toast.title"
                        x-text="toast.title"
                        class="font-semibold text-sm"
                        :class="{
                            'text-secondary-foreground': toast.variant === 'neutral',
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
[popover][id^="toast-"] {
    transition:
        opacity var(--animation-duration-slow),
        transform var(--animation-duration-slow),
        overlay var(--animation-duration-slow) allow-discrete,
        display var(--animation-duration-slow) allow-discrete;
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
                    toastElement.hidePopover();

                    setTimeout(() => {
                        this.toasts.splice(this.toasts.findIndex(t => t.id === id), 1);
                    }, 400);
                } else {
                    this.toasts.splice(index, 1);
                }
            }
        }
    }));
});
</script>
@endonce
