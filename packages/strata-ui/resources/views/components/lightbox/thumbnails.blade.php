<div data-strata-lightbox-thumbnails>
    <template x-for="(item, index) in items" x-bind:key="item.id">
        <button
            type="button"
            data-strata-lightbox-thumbnail
            x-bind:class="index === currentIndex ? 'active' : ''"
            x-on:click="goTo(index)"
            x-bind:aria-label="`Go to item ${index + 1}`"
            x-bind:aria-current="index === currentIndex ? 'true' : 'false'"
        >
            <template x-if="item.thumbnailUrl">
                <img x-bind:src="item.thumbnailUrl" x-bind:alt="item.caption || `Thumbnail ${index + 1}`" />
            </template>

            <template x-if="!item.thumbnailUrl && item.type === 'video'">
                <div data-strata-lightbox-thumbnail-icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="6 3 20 12 6 21 6 3"/>
                    </svg>
                </div>
            </template>

            <template x-if="!item.thumbnailUrl && item.type === 'document'">
                <div data-strata-lightbox-thumbnail-icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                        <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                    </svg>
                </div>
            </template>
        </button>
    </template>
</div>
