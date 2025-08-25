@php
    $baseClasses = 'flex rounded-[var(--radius-component-lg)] shadow-xs';
    $role = match ($color) {
        'destructive' => 'alert',
        'warning' => 'alert', 
        default => 'status'
    };
    $ariaLive = $color === 'destructive' ? 'assertive' : 'polite';
@endphp

<div 
    x-data="{ visible: true }" 
    x-show="visible" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    role="{{ $role }}"
    aria-live="{{ $ariaLive }}"
    {{ $attributes->merge([
        'class' => implode(' ', [
            $baseClasses,
            $getSizeClasses(),
            $getVariantClasses()
        ])
    ]) }}>
    
    {{-- Icon --}}
    <div class="shrink-0 flex items-start">
        <x-icon :name="$getContextualIcon()" :class="$getIconSizeClasses() . ' mt-0.5'" />
    </div>
    
    {{-- Content --}}
    <div class="ml-3 flex-1 min-w-0">
        @if ($title)
            <div {{ $attributes->only(['class'])->merge(['class' => $getTitleClasses()]) }}>
                {{ $title }}
            </div>
            @if ($slot->isNotEmpty())
                <div class="mt-1 text-sm opacity-90">
                    {{ $slot }}
                </div>
            @endif
        @else
            <div class="text-sm">
                {{ $slot }}
            </div>
        @endif
        
        {{-- Actions slot --}}
        @isset($actions)
            <div class="mt-3 flex gap-2">
                {!! $actions !!}
            </div>
        @endisset
    </div>
    
    {{-- Dismiss button --}}
    @if ($dismissible)
        <div class="shrink-0 flex items-start mt-0.5">
            <x-strata::button
                variant="ghost"
                size="sm"
                icon="heroicon-o-x-mark"
                x-on:click="visible = false"
                aria-label="Dismiss alert"
                class="!p-1"
            />
        </div>
    @endif
</div>