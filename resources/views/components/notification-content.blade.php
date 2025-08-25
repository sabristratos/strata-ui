@props([
    'image' => null,
    'title' => null,
    'description' => null,
])

<div class="flex items-start gap-3">
    {{-- Image/Avatar --}}
    @if ($image)
        <div class="shrink-0 flex items-center">
            @if (is_string($image))
                <img 
                    src="{{ $image }}" 
                    alt="Notification image"
                    class="w-10 h-10 rounded-full object-cover"
                >
            @else
                {{ $image }}
            @endif
        </div>
    @endif
    
    {{-- Content --}}
    <div class="flex-1 min-w-0">
        @if ($title)
            <div class="text-base font-medium text-foreground">
                {{ $title }}
            </div>
        @endif
        
        @if ($description)
            <div class="text-sm text-muted-foreground {{ $title ? 'mt-1' : '' }}">
                {{ $description }}
            </div>
        @endif
        
        {{-- Custom content slot --}}
        @if ($slot->isNotEmpty())
            <div class="{{ ($title || $description) ? 'mt-2' : '' }}">
                {{ $slot }}
            </div>
        @endif
    </div>
    
    {{-- Actions --}}
    @isset($actions)
        <div class="shrink-0 flex items-center gap-1">
            {{ $actions }}
        </div>
    @endisset
</div>