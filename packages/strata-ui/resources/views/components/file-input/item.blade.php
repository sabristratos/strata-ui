@props([
    'fileName' => '',
    'fileSize' => '',
    'fileType' => null,
    'preview' => null,
    'onRemove' => null,
    'showBadge' => true,
])

@php
use Stratos\StrataUI\Services\FileService;

$fileService = app(FileService::class);

$baseClasses = 'group relative flex items-center gap-3 p-3 bg-muted rounded-lg border border-border hover:border-primary transition-all duration-150';
$isImage = $preview || ($fileType && str_starts_with($fileType, 'image/'));

$extension = $fileService->getExtensionFromFilename($fileName);
$badgeColor = $fileService->getExtensionBadgeColor($extension);
$icon = $fileType ? $fileService->getIconForMimeType($fileType) : 'file';
@endphp

<div
    data-strata-file-input-item
    {{ $attributes->merge(['class' => $baseClasses]) }}
>
    @if($preview)
        <img
            src="{{ $preview }}"
            alt="{{ $fileName }}"
            class="w-12 h-12 object-cover rounded flex-shrink-0"
        />
    @elseif($isImage)
        <div class="w-12 h-12 flex items-center justify-center bg-primary/10 rounded flex-shrink-0">
            <x-dynamic-component :component="'strata::icon.' . $icon" class="w-6 h-6 text-primary" />
        </div>
    @else
        <div class="w-12 h-12 flex items-center justify-center bg-muted-foreground/10 rounded flex-shrink-0">
            <x-dynamic-component :component="'strata::icon.' . $icon" class="w-6 h-6 text-muted-foreground" />
        </div>
    @endif

    <div class="flex-1 min-w-0">
        @if($fileName)
            <p class="text-sm font-medium text-foreground truncate">
                {{ $fileName }}
            </p>
        @endif

        @if($fileSize)
            <div class="flex items-center gap-2 mt-0.5">
                <p class="text-xs text-muted-foreground">
                    {{ $fileSize }}
                </p>
                @if($showBadge && $extension)
                    <span class="bg-transparent text-muted-foreground border border-border px-1.5 py-0.5 text-[10px] rounded-full font-medium uppercase">
                        {{ $extension }}
                    </span>
                @endif
            </div>
        @endif
    </div>

    @if($onRemove || $slot->isNotEmpty())
        <div class="flex-shrink-0 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
            @if($slot->isNotEmpty())
                {{ $slot }}
            @else
                @if($preview)
                    <a href="{{ $preview }}" download="{{ $fileName }}">
                        <x-strata::button.icon
                            icon="download"
                            size="sm"
                            variant="secondary"
                            appearance="filled"
                            type="button"
                            aria-label="Download file"
                        />
                    </a>
                @endif
                <x-strata::button.icon
                    icon="x"
                    size="sm"
                    variant="destructive"
                    appearance="filled"
                    wire:click="{{ $onRemove }}"
                    type="button"
                    aria-label="Remove file"
                />
            @endif
        </div>
    @endif
</div>
