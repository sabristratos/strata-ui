<img
    x-bind:src="currentItem.url"
    x-bind:alt="currentItem.caption || ''"
    data-strata-lightbox-image
    class="max-w-full max-h-full object-contain transition-transform duration-300 ease-out"
    x-bind:class="isZoomed ? 'scale-150 cursor-zoom-out' : 'cursor-zoom-in'"
    x-on:load="handleImageLoad()"
    x-on:error="handleImageError()"
    x-on:click="toggleZoom()"
    tabindex="0"
    role="img"
/>
