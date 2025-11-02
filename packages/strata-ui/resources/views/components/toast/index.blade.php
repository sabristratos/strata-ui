@props([
    'position' => 'bottom-right',
    'duration' => 5000,
])

@php
$positionClasses = match($position) {
    'top-left' => 'top-0 left-0',
    'top-center' => 'top-0 left-1/2 -translate-x-1/2',
    'top-right' => 'top-0 right-0',
    'bottom-left' => 'bottom-0 left-0',
    'bottom-center' => 'bottom-0 left-1/2 -translate-x-1/2',
    'bottom-right' => 'bottom-0 right-0',
    default => 'bottom-0 right-0',
};
@endphp

<div
    x-data="strataToast('{{ $position }}', {{ $duration }})"
    data-strata-toast
    {{ $attributes->class('fixed ' . $positionClasses . ' z-50 p-4 pointer-events-none max-w-md') }}
>
    <div class="flex flex-col gap-2">
        <template x-for="toast in toasts" :key="toast.id">
            <div
                :id="`toast-${toast.id}`"
                x-show="!toast.exiting"
                @mouseenter="pauseTimer(toast)"
                @mouseleave="resumeTimer(toast)"
                role="alert"
                class="pointer-events-auto relative bg-card text-card-foreground border rounded-lg shadow-lg overflow-hidden
                       transition-all transition-discrete duration-200 ease-out
                       opacity-100 translate-x-0
                       starting:opacity-0"
                :class="{
                    'translate-x-full opacity-0': toast.exiting && ['top-right', 'bottom-right'].includes('{{ $position }}'),
                    '-translate-x-full opacity-0': toast.exiting && ['top-left', 'bottom-left'].includes('{{ $position }}'),
                    'translate-y-4 opacity-0': toast.exiting && ['top-center', 'bottom-center'].includes('{{ $position }}'),
                    'starting:translate-x-full': ['top-right', 'bottom-right'].includes('{{ $position }}'),
                    'starting:-translate-x-full': ['top-left', 'bottom-left'].includes('{{ $position }}'),
                    'starting:translate-y-4': ['top-center', 'bottom-center'].includes('{{ $position }}'),
                    'border-info/20 bg-info/10': toast.variant === 'info',
                    'border-success/20 bg-success/10': toast.variant === 'success',
                    'border-warning/20 bg-warning/10': toast.variant === 'warning',
                    'border-destructive/20 bg-destructive/10': toast.variant === 'error'
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
                            <x-strata::icon.x-circle class="size-5 text-destructive" />
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
</div>

@once
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

        addToast(options) {
            if (typeof options === 'string') {
                options = { description: options };
            }

            const toast = {
                id: Date.now() + Math.random(),
                variant: options.variant || 'info',
                title: options.title || null,
                description: options.description || options.message || '',
                dismissible: options.dismissible !== false,
                duration: options.duration !== undefined ? options.duration : this.defaultDuration,
                visible: true,
                exiting: false,
                progress: 100,
                timer: null,
                progressTimer: null
            };

            this.toasts.push(toast);

            if (toast.duration > 0) {
                this.startTimer(toast);
            }
        },

        startTimer(toast) {
            const interval = 50;
            const decrement = (100 / toast.duration) * interval;

            toast.progressTimer = setInterval(() => {
                const index = this.toasts.findIndex(t => t.id === toast.id);
                if (index > -1) {
                    this.toasts[index].progress -= decrement;

                    if (this.toasts[index].progress <= 0) {
                        this.removeToast(toast.id);
                    }
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

                toast.exiting = true;

                setTimeout(() => {
                    this.toasts.splice(index, 1);
                }, 200);
            }
        }
    }));
});
</script>
@endonce
