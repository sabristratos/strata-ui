import { decode } from 'blurhash';

export default function imageComponent({
    src,
    fallback = null,
    blurHash = null,
    placeholder = null,
    placeholderType = 'skeleton',
}) {
    return {
        state: 'loading',

        init() {
            if (this.blurHash && this.$refs.blurHashCanvas) {
                this.renderBlurHash(this.blurHash);
            }

            if (this.$refs.image && this.$refs.image.complete) {
                this.handleLoad();
            }
        },

        handleLoad() {
            this.state = 'loaded';
            this.dispatchEvent('loaded');
        },

        handleError() {
            if (this.fallback) {
                this.state = 'error';
                this.dispatchEvent('error');
            } else {
                this.dispatchEvent('error');
            }
        },

        renderBlurHash(hash) {
            if (!hash || !this.$refs.blurHashCanvas) return;

            const canvas = this.$refs.blurHashCanvas;
            const ctx = canvas.getContext('2d');

            const width = 32;
            const height = 32;
            canvas.width = width;
            canvas.height = height;

            try {
                const pixels = decode(hash, width, height);
                const imageData = ctx.createImageData(width, height);
                imageData.data.set(pixels);
                ctx.putImageData(imageData, 0, 0);
            } catch (error) {
                console.error('Failed to render BlurHash:', error);
            }
        },

        dispatchEvent(eventName) {
            this.$dispatch(`image-${eventName}`, {
                src: this.src,
                fallback: this.fallback,
            });
        },

        src,
        fallback,
        blurHash,
        placeholder,
        placeholderType,
    };
}
