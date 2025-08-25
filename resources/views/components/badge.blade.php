@php
    $content = trim($slot);
    if (is_numeric($content) && (int)$content > 99) {
        $content = '99+';
    }

    $baseClasses = 'inline-flex items-center justify-center font-medium';
    $shapeClasses = $shape === 'square' ? 'rounded-[var(--radius-component)]' : 'rounded-full';

    if ($shape === 'square') {
        $sizeClasses = match ($size) {
            'sm' => 'h-5 w-5 text-xs font-bold',
            'lg' => 'h-7 w-7 text-sm',
            default => 'h-6 w-6 text-xs',
        };
    } else {
        $padding = $icon ? 'gap-x-1.5 ' : '';
        $sizeClasses = $padding . match ($size) {
            'sm' => 'px-2 py-0.5 text-xs',
            'lg' => 'px-3 py-1 text-base',
            default => 'px-2.5 py-0.5 text-sm',
        };
    }

    $iconSizeClasses = match ($size) {
        'sm' => 'w-3 h-3',
        'lg' => 'w-5 h-5',
        default => 'w-4 h-4',
    };
@endphp

<span
    x-data="{ visible: true }"
    x-show="visible"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    {{ $attributes->merge([
        'class' => implode(' ', [
            $baseClasses,
            $shapeClasses,
            $sizeClasses,
            $getVariantClasses()
        ])
    ]) }}>
    @if ($icon)
        <x-icon :name="$icon" :class="$iconSizeClasses" />
    @endif

    <span>{{ $content }}</span>

    @if ($dismissible)
        <button
            type="button"
            x-on:click="visible = false"
            class="shrink-0 -mr-0.5 ml-1 h-3 w-3 rounded-full inline-flex items-center justify-center text-current/70 hover:bg-black/20 hover:text-current focus:outline-hidden focus:ring-1 focus:ring-offset-1 focus:ring-current transition-colors"
        >
            <span class="sr-only">Remove</span>
            <svg class="h-2.5 w-2.5" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
            </svg>
        </button>
    @endif
</span>
