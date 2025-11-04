@props([
    'id' => 'strata-lightbox-' . uniqid(),
])

@php
$dialogClasses = 'max-w-full max-h-dvh w-screen h-dvh p-0 m-0 border-0 bg-transparent overflow-hidden hidden open:flex open:items-center open:justify-center opacity-0 scale-95 open:opacity-100 open:scale-100 starting:open:opacity-0 starting:open:scale-95 transition-all duration-150 ease-out';
$backdropClasses = 'backdrop:bg-neutral-950/95 backdrop:backdrop-blur-lg backdrop:transition-all backdrop:duration-150';
$classes = trim("$dialogClasses $backdropClasses");
@endphp

<dialog
    {{ $attributes->merge([
        'id' => $id,
        'data-strata-lightbox' => true,
        'aria-modal' => 'true',
        'aria-label' => 'Lightbox gallery',
        'role' => 'dialog',
        'class' => $classes,
    ]) }}
    x-data="window.StrataLightbox()"
    x-init="init()"
    x-on:keydown.window="handleKeydown($event)"
    x-cloak
>
    <div data-strata-lightbox-container>
        <x-strata::lightbox.navigation />

        <div data-strata-lightbox-media-container x-ref="mediaContainer">
            <template x-if="currentItem && currentItem.type === 'image'">
                <x-strata::lightbox.image />
            </template>

            <template x-if="currentItem && currentItem.type === 'video'">
                <x-strata::lightbox.video />
            </template>

            <template x-if="currentItem && currentItem.type === 'document'">
                <x-strata::lightbox.document />
            </template>

            <div
                x-show="isLoading"
                data-strata-lightbox-loading
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div data-strata-lightbox-spinner"></div>
            </div>
        </div>

        <template x-if="hasMultipleItems">
            <x-strata::lightbox.thumbnails />
        </template>

        <template x-if="currentItem && currentItem.caption">
            <x-strata::lightbox.caption />
        </template>
    </div>
</dialog>
