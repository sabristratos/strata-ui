@props([
    'multiple' => false,
    'accept' => null,
    'maxSize' => null,
    'maxFiles' => null,
    'size' => 'md',
    'state' => 'default',
    'disabled' => false,
    'label' => null,
    'hint' => null,
    'error' => null,
    'icon' => 'upload-cloud',
    'existingFiles' => null,
    'onRemoveExisting' => null,
    'showNewUploadsSection' => true,
])

@php
use Stratos\StrataUI\Services\FileService;
use Stratos\StrataUI\Data\FileData;

$fileService = app(FileService::class);
$processedExistingFiles = [];
$hasExistingFiles = false;
$recommendedLayout = 'list';

if ($existingFiles && is_array($existingFiles) && count($existingFiles) > 0) {
    $processedExistingFiles = array_map(
        fn ($file) => FileData::fromArray($file),
        $existingFiles
    );
    $recommendedLayout = $fileService->recommendLayout($existingFiles);
    $hasExistingFiles = true;
}

$baseClasses = 'relative flex flex-col items-center justify-center border-2 border-dashed rounded-lg transition-all duration-150 cursor-pointer';

$sizes = [
    'sm' => ['wrapper' => 'px-4 py-6 gap-2', 'icon' => 'w-8 h-8', 'label' => 'text-sm', 'hint' => 'text-xs'],
    'md' => ['wrapper' => 'px-6 py-8 gap-3', 'icon' => 'w-10 h-10', 'label' => 'text-base', 'hint' => 'text-sm'],
    'lg' => ['wrapper' => 'px-8 py-10 gap-4', 'icon' => 'w-12 h-12', 'label' => 'text-lg', 'hint' => 'text-base'],
];

$stateClasses = [
    'default' => 'border-input-border bg-background hover:border-primary hover:bg-muted/50',
    'success' => 'border-success bg-success/5 hover:bg-success/10',
    'error' => 'border-destructive bg-destructive/5 hover:bg-destructive/10',
    'warning' => 'border-warning bg-warning/5 hover:bg-warning/10',
];

$stateIcons = [
    'success' => 'check-circle',
    'error' => 'alert-circle',
    'warning' => 'alert-triangle',
];

$disabledClasses = $disabled ? 'opacity-60 cursor-not-allowed hover:border-input-border hover:bg-background' : '';

$wrapperClasses = $baseClasses . ' ' . ($sizes[$size]['wrapper'] ?? $sizes['md']['wrapper']) . ' ' . ($stateClasses[$state] ?? $stateClasses['default']) . ' ' . $disabledClasses;

$wrapperAttributes = $attributes->only(['class', 'style']);
$inputAttributes = $attributes->except(['class', 'style']);

$maxSizeBytes = $maxSize ? (is_numeric($maxSize) ? $maxSize : null) : null;
$acceptTypes = $accept ? explode(',', str_replace(' ', '', $accept)) : null;
$hasWireModel = $inputAttributes->whereStartsWith('wire:model')->first() ? true : false;
$maxSizeMB = $maxSizeBytes ? number_format($maxSizeBytes / 1024 / 1024, 2) : null;
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataFileInput', (disabled, maxSizeBytes, maxSizeMB, acceptTypes, acceptString, maxFiles, hasWireModel) => ({
        isDragging: false,
        isUploading: false,
        input: null,
        validationError: null,
        progress: 0,
        init() {
            this.input = this.$el.querySelector('[data-strata-file-input]');

            if (hasWireModel) {
                Livewire.hook('upload:start', ({ id, property }) => {
                    this.isUploading = true;
                });

                Livewire.hook('upload:progress', ({ detail }) => {
                    if (detail && detail.progress !== undefined) {
                        this.progress = detail.progress;
                    }
                });

                Livewire.hook('upload:finished', ({ id, property }) => {
                    this.isUploading = false;
                    this.progress = 0;
                });

                Livewire.hook('upload:error', () => {
                    this.isUploading = false;
                    this.progress = 0;
                });
            }
        },
        validateFile(file) {
            if (!file || !file.name) {
                return false;
            }

            if (maxSizeBytes && file.size > maxSizeBytes) {
                this.validationError = `File ${file.name} exceeds maximum size of ${maxSizeMB}MB`;
                return false;
            }

            if (acceptTypes && acceptTypes.length > 0) {
                const fileType = file.type;
                const fileName = file.name;
                const fileExtension = '.' + fileName.split('.').pop();

                const isAccepted = acceptTypes.some(type => {
                    type = type.trim();
                    if (type.startsWith('.')) {
                        return fileExtension.toLowerCase() === type.toLowerCase();
                    }
                    if (type.includes('*')) {
                        const baseType = type.split('/')[0];
                        return fileType.startsWith(baseType + '/');
                    }
                    return fileType === type;
                });

                if (!isAccepted) {
                    this.validationError = `File ${file.name} type not accepted. Allowed: ${acceptString}`;
                    return false;
                }
            }

            return true;
        },
        validateFiles(files) {
            this.validationError = null;

            if (maxFiles && files.length > maxFiles) {
                this.validationError = `Maximum ${maxFiles} file(s) allowed. You selected ${files.length} file(s).`;
                return false;
            }

            for (let file of files) {
                if (!this.validateFile(file)) {
                    return false;
                }
            }

            return true;
        },
        handleDragOver(e) {
            if (!disabled) {
                e.preventDefault();
                this.isDragging = true;
            }
        },
        handleDragLeave(e) {
            e.preventDefault();
            this.isDragging = false;
        },
        handleDrop(e) {
            if (!disabled) {
                e.preventDefault();
                this.isDragging = false;

                if (e.dataTransfer.files.length > 0) {
                    const files = Array.from(e.dataTransfer.files).filter(f => f && f.name);

                    if (files.length > 0 && this.validateFiles(files)) {
                        this.input.files = e.dataTransfer.files;
                        this.input.dispatchEvent(new Event('input', { bubbles: true }));
                        this.input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            }
        },
        handleChange(e) {
            const files = Array.from(e.target.files).filter(f => f && f.name);
            if (files.length > 0 && !this.validateFiles(files)) {
                e.target.value = '';
            }
        },
        openFilePicker() {
            if (!disabled && !this.isUploading) {
                this.validationError = null;
                this.input.click();
            }
        }
    }));
});
</script>
@endonce

<div class="space-y-4">

    @if($hasExistingFiles)
        <div class="@container border border-primary/20 rounded-lg p-4 bg-primary/5">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-semibold text-foreground flex items-center gap-2">
                    <x-strata::icon.folder class="w-4 h-4 text-primary" />
                    Existing Files
                    <span class="px-2 py-0.5 text-xs bg-primary/10 text-primary rounded-full">{{ count($processedExistingFiles) }}</span>
                </h4>
            </div>

            @if($recommendedLayout === 'grid')
                {{-- Gallery layout for images --}}
                <div class="grid grid-cols-1 @sm:grid-cols-2 @md:grid-cols-3 @lg:grid-cols-4 gap-4">
                    @foreach($processedExistingFiles as $file)
                        <div class="group relative aspect-square rounded-lg overflow-hidden bg-muted border border-border hover:border-primary transition-all duration-150">
                            @if($file->isImage())
                                <img
                                    src="{{ $file->url }}"
                                    alt="{{ $file->name }}"
                                    class="w-full h-full object-cover"
                                />

                                {{-- Overlay with file info on hover --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                    <div class="absolute bottom-0 left-0 right-0 p-3 text-white">
                                        <p class="text-sm font-medium truncate">{{ $file->name }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <p class="text-xs opacity-90">{{ $file->sizeFormatted() }}</p>
                                            <span class="bg-transparent text-white border border-white/30 px-1.5 py-0.5 text-[10px] rounded-full font-medium uppercase">
                                                {{ $file->extension }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action buttons --}}
                                <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                    <a href="{{ $file->url }}" download="{{ $file->name }}">
                                        <x-strata::button.icon
                                            icon="download"
                                            size="sm"
                                            variant="secondary"
                                            appearance="filled"
                                            type="button"
                                            aria-label="Download file"
                                        />
                                    </a>
                                    @if($onRemoveExisting)
                                        <x-strata::button.icon
                                            icon="x"
                                            size="sm"
                                            variant="destructive"
                                            appearance="filled"
                                            wire:click="{{ $onRemoveExisting }}({{ $file->id }})"
                                            type="button"
                                            aria-label="Remove file"
                                        />
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                {{-- List layout for documents --}}
                <div class="space-y-2">
                    @foreach($processedExistingFiles as $file)
                        <x-strata::file-input.item
                            :fileName="$file->name"
                            :fileSize="$file->sizeFormatted()"
                            :fileType="$file->mimeType"
                            :preview="$file->url"
                            :onRemove="$onRemoveExisting ? $onRemoveExisting . '(' . $file->id . ')' : null"
                        />
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <div
        data-strata-file-input-container
        x-data="strataFileInput({{ $disabled ? 'true' : 'false' }}, {{ $maxSizeBytes ?? 'null' }}, '{{ $maxSizeMB }}', {{ json_encode($acceptTypes) }}, '{{ $accept }}', {{ $maxFiles ?? 'null' }}, {{ $hasWireModel ? 'true' : 'false' }})"
    >
        <div
        data-strata-file-input-wrapper
        @dragover.prevent="handleDragOver"
        @dragleave.prevent="handleDragLeave"
        @drop.prevent="handleDrop"
        @click="openFilePicker"
        {{ $wrapperAttributes->merge(['class' => $wrapperClasses]) }}
        :class="{
            'border-primary bg-primary/10': isDragging && !{{ $disabled ? 'true' : 'false' }},
            'pointer-events-none': isUploading
        }"
    >
        <input
            data-strata-file-input
            type="file"
            class="absolute inset-0 w-full h-full opacity-0 pointer-events-none"
            {{ $inputAttributes }}
            @if($multiple) multiple @endif
            @if($accept) accept="{{ $accept }}" @endif
            @disabled($disabled)
            @change="handleChange"
        />

        <div x-show="isUploading" class="absolute inset-0 bg-background/80 flex items-center justify-center rounded-lg z-10" x-cloak>
            <div class="text-center">
                <x-strata::icon.loader-circle class="w-8 h-8 text-primary animate-spin mx-auto mb-2" />
                <p class="text-sm text-muted-foreground">Uploading...</p>
            </div>
        </div>

        <x-dynamic-component
            :component="'strata::icon.' . $icon"
            class="{{ $sizes[$size]['icon'] ?? $sizes['md']['icon'] }} text-muted-foreground"
            x-show="!isUploading"
        />

        <div x-show="!isUploading">
            @if($label || $slot->isNotEmpty())
                <div class="text-center">
                    @if($label)
                        <p class="{{ $sizes[$size]['label'] ?? $sizes['md']['label'] }} font-medium text-foreground">
                            {{ $label }}
                        </p>
                    @endif

                    @if($slot->isNotEmpty())
                        <div class="{{ $sizes[$size]['hint'] ?? $sizes['md']['hint'] }} text-muted-foreground mt-1">
                            {{ $slot }}
                        </div>
                    @endif

                    @if($hint)
                        <p class="{{ $sizes[$size]['hint'] ?? $sizes['md']['hint'] }} text-muted-foreground mt-1">
                            {{ $hint }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if($state !== 'default' && isset($stateIcons[$state]))
            <div class="absolute top-3 right-3" x-show="!isUploading">
                <x-dynamic-component
                    :component="'strata::icon.' . $stateIcons[$state]"
                    class="w-5 h-5 {{ $state === 'success' ? 'text-success' : ($state === 'error' ? 'text-destructive' : 'text-warning') }}"
                />
            </div>
        @endif
    </div>

    @if($inputAttributes->whereStartsWith('wire:model')->first())
        <div
            x-show="isUploading && progress > 0"
            class="mt-2"
            x-cloak
        >
            <div class="w-full bg-muted rounded-full h-2 overflow-hidden">
                <div
                    class="bg-primary h-full transition-all duration-300 ease-out"
                    :style="{ width: progress + '%' }"
                ></div>
            </div>
            <p class="text-xs text-muted-foreground mt-1" x-text="`Uploading: ${progress}%`"></p>
        </div>
    @endif

    <div x-show="validationError" x-cloak class="mt-2">
        <p class="text-sm text-destructive flex items-center gap-2">
            <x-strata::icon.alert-circle class="w-4 h-4 flex-shrink-0" />
            <span x-text="validationError"></span>
        </p>
    </div>

    @if($error)
        <div class="mt-2">
            <p class="text-sm text-destructive flex items-center gap-2">
                <x-strata::icon.alert-circle class="w-4 h-4 flex-shrink-0" />
                <span>{{ $error }}</span>
            </p>
        </div>
    @endif
    </div>
</div>
