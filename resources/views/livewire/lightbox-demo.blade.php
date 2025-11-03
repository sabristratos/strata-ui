<div class="p-8 space-y-12">
    <div class="space-y-4">
        <h2 class="text-2xl font-bold">Lightbox Component Demo</h2>
        <p class="text-muted-foreground">
            Add <code class="bg-muted px-1.5 py-0.5 rounded text-sm">data-lightbox="gallery-name"</code> to any image, video, or link to enable the lightbox.
        </p>
    </div>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Single Image</h3>
        <p class="text-sm text-muted-foreground">Click the image to open in lightbox</p>

        <div>
            <img
                src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800"
                alt="Single mountain landscape"
                data-lightbox="single"
                class="w-64 h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
            />
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Image Gallery</h3>
        <p class="text-sm text-muted-foreground">All images with the same gallery name form a gallery with navigation</p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($images as $index => $image)
                <img
                    src="{{ $image['url'] }}?w=400"
                    alt="{{ $image['caption'] }}"
                    data-lightbox="nature-gallery"
                    data-lightbox-caption="{{ $image['caption'] }}"
                    class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
                />
            @endforeach
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">With Figure & Figcaption</h3>
        <p class="text-sm text-muted-foreground">Captions are automatically extracted from figcaption elements</p>

        <div class="grid grid-cols-2 gap-4">
            <figure>
                <img
                    src="https://images.unsplash.com/photo-1682687220923-c58b9a4592ae?w=400"
                    alt="City skyline"
                    data-lightbox="figure-gallery"
                    class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
                />
                <figcaption class="mt-2 text-sm text-muted-foreground">Modern city skyline at night</figcaption>
            </figure>

            <figure>
                <img
                    src="https://images.unsplash.com/photo-1682687220795-796d3f6f7000?w=400"
                    alt="Architecture"
                    data-lightbox="figure-gallery"
                    class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
                />
                <figcaption class="mt-2 text-sm text-muted-foreground">Contemporary architecture design</figcaption>
            </figure>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Mixed Media Gallery</h3>
        <p class="text-sm text-muted-foreground">Combine images, videos, and documents in one gallery</p>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <img
                src="https://images.unsplash.com/photo-1682687982501-1e58ab814714?w=400"
                alt="Landscape photo"
                data-lightbox="mixed-gallery"
                title="Beautiful landscape photography"
                class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
            />

            <a
                href="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4"
                data-lightbox="mixed-gallery"
                class="block relative w-full h-48 bg-muted rounded-lg cursor-pointer hover:opacity-90 transition overflow-hidden"
            >
                <div class="absolute inset-0 flex items-center justify-center bg-neutral-900/50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="2">
                        <polygon points="6 3 20 12 6 21 6 3"/>
                    </svg>
                </div>
                <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=400" alt="Video thumbnail" class="w-full h-full object-cover" />
            </a>

            <img
                src="https://images.unsplash.com/photo-1682687218147-9806132dc697?w=400"
                alt="Another photo"
                data-lightbox="mixed-gallery"
                title="Abstract art photography"
                class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
            />
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Link to Images</h3>
        <p class="text-sm text-muted-foreground">Works with anchor tags linking to images</p>

        <div class="flex gap-4">
            <a
                href="https://images.unsplash.com/photo-1682687981922-7b55dbb30892?w=1200"
                data-lightbox="link-gallery"
                class="block px-4 py-2 bg-primary text-primary-foreground rounded-md hover:bg-primary/90 transition"
            >
                Open Image 1
            </a>

            <a
                href="https://images.unsplash.com/photo-1682695798256-28a676d5ac6c?w=1200"
                data-lightbox="link-gallery"
                class="block px-4 py-2 bg-primary text-primary-foreground rounded-md hover:bg-primary/90 transition"
            >
                Open Image 2
            </a>
        </div>
    </section>

    <section class="space-y-4 pb-8">
        <h3 class="text-xl font-semibold">Features</h3>
        <ul class="list-disc list-inside space-y-2 text-sm text-muted-foreground">
            <li><strong>Keyboard Navigation:</strong> Arrow keys (prev/next), Home/End (first/last), ESC (close), Space/Enter (zoom)</li>
            <li><strong>Auto-detection:</strong> Media type detected from element type and file extension</li>
            <li><strong>Caption Priority:</strong> data-lightbox-caption → figcaption → title → alt</li>
            <li><strong>Zoom:</strong> Click image or press Space/Enter to zoom in/out</li>
            <li><strong>Thumbnails:</strong> Automatic thumbnail strip for galleries with multiple items</li>
            <li><strong>Counter:</strong> Shows current position in gallery (e.g., "3 / 10")</li>
        </ul>
    </section>
</div>
