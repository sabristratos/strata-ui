<div
    x-data="strataToastGroup({
        position: '{{ $position }}',
        expanded: {{ $expanded ? 'true' : 'false' }}
    })"
    @strata-toast-show.window="addToast($event.detail)"
    @class([
        'fixed z-[99] w-full sm:max-w-sm p-4 space-y-3 pointer-events-none',
        'bottom-0 right-0' => $position === 'bottom-end',
        'bottom-0 left-0' => $position === 'bottom-start',
        'bottom-0 left-1/2 -translate-x-1/2' => $position === 'bottom-center',
        'top-0 right-0' => $position === 'top-end',
        'top-0 left-0' => $position === 'top-start',
        'top-0 left-1/2 -translate-x-1/2' => $position === 'top-center',
    ])
    x-cloak
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-data="{
                show: false,
                timer: null,
                startTimer() {
                    if (toast.duration > 0) {
                        this.timer = setTimeout(() => this.removeToast(), toast.duration);
                    }
                },
                cancelTimer() {
                    clearTimeout(this.timer);
                },
                removeToast() {
                    this.show = false;
                    setTimeout(() => {
                        const index = $data.toasts.findIndex(t => t.id === toast.id);
                        if (index > -1) {
                            $data.toasts.splice(index, 1);
                        }
                    }, 200);
                }
            }"
            x-init="() => {
                $nextTick(() => show = true);
                startTimer();
            }"
            @mouseenter="cancelTimer()"
            @mouseleave="startTimer()"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform"
            x-transition:enter-end="opacity-100 transform"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform"
            x-transition:leave-end="opacity-0 transform"
            :class="{
                'translate-y-full': '{{ str($position)->startsWith('bottom-') }}' && !show,
                '-translate-y-full': '{{ str($position)->startsWith('top-') }}' && !show,
                'translate-y-0': show,
            }"
            class="w-full pointer-events-auto"
        >
            <div class="w-full">
                <x-strata::card class="!p-4" style="border-radius: min(var(--radius-component), var(--radius-component-lg))">
                    <div class="flex items-start gap-3">
                        {{-- Variant icons --}}
                        <div class="w-5 h-5 mt-0.5 shrink-0">
                            <x-icon 
                                name="heroicon-o-check-circle" 
                                x-show="toast.variant === 'success'"
                                class="w-5 h-5 text-success"
                            />
                            <x-icon 
                                name="heroicon-o-exclamation-triangle" 
                                x-show="toast.variant === 'warning'"
                                class="w-5 h-5 text-warning"
                            />
                            <x-icon 
                                name="heroicon-o-x-circle" 
                                x-show="toast.variant === 'destructive'"
                                class="w-5 h-5 text-destructive"
                            />
                            <x-icon 
                                name="heroicon-o-information-circle" 
                                x-show="toast.variant === 'info' || toast.variant === 'primary' || toast.variant === 'accent'"
                                x-bind:class="toast.variant === 'primary' ? 'text-primary' : toast.variant === 'accent' ? 'text-accent' : 'text-info'"
                                class="w-5 h-5"
                            />
                        </div>
                        
                        {{-- Content area --}}
                        <div class="flex-1 min-w-0">
                            <template x-if="toast.title">
                                <h4 class="text-base font-medium text-foreground" x-text="toast.title"></h4>
                            </template>
                            
                            <p 
                                x-text="toast.message" 
                                x-bind:class="{ 'mt-1': toast.title }" 
                                class="text-sm text-muted-foreground"
                            ></p>
                            
                            {{-- Action buttons using Button components --}}
                            <template x-if="toast.actions && toast.actions.length > 0">
                                <div class="flex gap-2 mt-3">
                                    {{-- Primary action (index 0) --}}
                                    <template x-if="toast.actions[0]">
                                        <x-strata::button
                                            size="sm"
                                            variant="primary"
                                            x-text="toast.actions[0].label"
                                            @click="handleAction(toast.actions[0])"
                                        />
                                    </template>
                                    
                                    {{-- Secondary action (index 1) --}}
                                    <template x-if="toast.actions[1]">
                                        <x-strata::button
                                            size="sm" 
                                            variant="outline"
                                            x-text="toast.actions[1].label"
                                            @click="handleAction(toast.actions[1])"
                                        />
                                    </template>
                                </div>
                            </template>
                        </div>
                        
                        {{-- Dismiss button using Button component --}}
                        <x-strata::button
                            variant="ghost"
                            size="sm"
                            icon="heroicon-o-x-mark"
                            @click="removeToast()"
                            class="!p-1 shrink-0"
                            aria-label="Dismiss notification"
                        />
                    </div>
                </x-strata::card>
            </div>
        </div>
    </template>
</div>

@once
<script>
document.addEventListener('alpine:initializing', () => {
    Alpine.data('strataToastGroup', (config) => ({
        toasts: [],
        position: config.position || 'bottom-end',
        expanded: config.expanded || false,


        handleAction(action) {
            // Execute the action callback if it's a function
            if (typeof window[action.action] === 'function') {
                window[action.action]();
            } else {
                // Try to evaluate as JavaScript code
                try {
                    new Function(action.action)();
                } catch (e) {
                    console.warn('Toast action failed to execute:', action.action, e);
                }
            }
        },

        addToast(detail) {
            const toast = {
                id: Date.now() + Math.random(),
                duration: detail.duration === 0 ? 0 : (detail.duration || 5000),
                message: typeof detail === 'string' ? detail : (detail.message || ''),
                title: detail.title || null,
                variant: detail.variant || 'info',
                icon: detail.icon || null,
                actions: detail.actions || null,
            };

            this.toasts.push(toast);
        },
    }));

    // Register unified Alpine magic helper
    Alpine.magic('strata', (el) => ({
        // Toast functionality
        toast(detail) {
            window.dispatchEvent(new CustomEvent('strata-toast-show', { detail }));
        },
        // Modal functionality  
        modal(name) {
            return {
                show(data = {}) {
                    window.dispatchEvent(new CustomEvent(`strata-modal-show-${name}`, { detail: data }));
                },
                hide() {
                    window.dispatchEvent(new CustomEvent(`strata-modal-hide-${name}`));
                },
                toggle(data = {}) {
                    window.dispatchEvent(new CustomEvent(`strata-modal-toggle-${name}`, { detail: data }));
                }
            };
        },
        modals() {
            return {
                close() {
                    document.querySelectorAll('[x-data*="strataModal"]').forEach(el => {
                        const modalName = el.getAttribute('x-data').match(/name:\s*'([^']*)'/);
                        if (modalName && modalName[1]) {
                            window.dispatchEvent(new CustomEvent(`strata-modal-hide-${modalName[1]}`));
                        } else {
                            if (el.__x && el.__x.$data && el.__x.$data.hideModal) {
                                el.__x.$data.hideModal();
                            }
                        }
                    });
                    document.body.style.overflow = '';
                }
            };
        }
    }));
});
</script>
@endonce

{{-- Dispatch session toast after DOM loads --}}
@if (session()->has('strata_toast'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(new CustomEvent('strata-toast-show', {
                detail: @json(session('strata_toast'))
            }));
        });
    </script>
@endif