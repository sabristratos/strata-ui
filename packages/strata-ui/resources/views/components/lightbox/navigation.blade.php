<div data-strata-lightbox-navigation>
    <div data-strata-lightbox-nav-group>
        <button
            type="button"
            data-strata-lightbox-nav-button
            x-on:click="prev()"
            x-bind:disabled="!hasPrev"
            :aria-label="$__('Previous image')"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
        </button>

        <button
            type="button"
            data-strata-lightbox-nav-button
            x-on:click="next()"
            x-bind:disabled="!hasNext"
            :aria-label="$__('Next image')"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6"/>
            </svg>
        </button>
    </div>

    <div data-strata-lightbox-nav-group>
        <template x-if="hasMultipleItems">
            <x-strata::lightbox.counter />
        </template>

        <button
            type="button"
            data-strata-lightbox-nav-button
            x-on:click="close()"
            :aria-label="$__('Close')"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"/>
                <path d="m6 6 12 12"/>
            </svg>
        </button>
    </div>
</div>
