<div class="space-y-12 p-8">
    <div>
        <h2 class="text-2xl font-bold mb-6">Image Component Demo</h2>

        <div class="space-y-8">
            {{-- Basic Usage --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Basic Image</h3>
                <div class="flex gap-4 flex-wrap">
                    <x-strata::image
                        src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800"
                        alt="Mountain landscape"
                    />
                </div>
            </div>

            {{-- Size Variants --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Size Variants</h3>
                <div class="flex gap-4 flex-wrap items-end">
                    <div>
                        <p class="text-sm text-muted-foreground mb-2">XS</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Mountain XS"
                            size="xs"
                            aspect="square"
                        />
                    </div>
                    <div>
                        <p class="text-sm text-muted-foreground mb-2">SM</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Mountain SM"
                            size="sm"
                            aspect="square"
                        />
                    </div>
                    <div>
                        <p class="text-sm text-muted-foreground mb-2">MD</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Mountain MD"
                            size="md"
                            aspect="square"
                        />
                    </div>
                    <div>
                        <p class="text-sm text-muted-foreground mb-2">LG</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400"
                            alt="Mountain LG"
                            size="lg"
                            aspect="square"
                        />
                    </div>
                </div>
            </div>

            {{-- Aspect Ratios --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Aspect Ratios</h3>
                <div class="flex gap-4 flex-wrap">
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Square (1:1)</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400"
                            alt="Square aspect"
                            size="md"
                            aspect="square"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Video (16:9)</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800"
                            alt="Video aspect"
                            size="md"
                            aspect="video"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Photo (4:3)</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400"
                            alt="Photo aspect"
                            size="md"
                            aspect="photo"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Portrait (3:4)</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400"
                            alt="Portrait aspect"
                            size="md"
                            aspect="portrait"
                        />
                    </div>
                </div>
            </div>

            {{-- Rounded Variants --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Rounded Variants</h3>
                <div class="flex gap-4 flex-wrap">
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">None</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="No rounding"
                            size="sm"
                            aspect="square"
                            rounded="none"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">SM</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Small rounding"
                            size="sm"
                            aspect="square"
                            rounded="sm"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">MD</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Medium rounding"
                            size="sm"
                            aspect="square"
                            rounded="md"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">LG</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Large rounding"
                            size="sm"
                            aspect="square"
                            rounded="lg"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Full</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Full rounding"
                            size="sm"
                            aspect="square"
                            rounded="full"
                        />
                    </div>
                </div>
            </div>

            {{-- Visual Variants --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Visual Variants</h3>
                <div class="flex gap-4 flex-wrap">
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Default</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Default variant"
                            size="sm"
                            aspect="square"
                            rounded="md"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Bordered</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Bordered variant"
                            size="sm"
                            aspect="square"
                            rounded="md"
                            variant="bordered"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Elevated</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Elevated variant"
                            size="sm"
                            aspect="square"
                            rounded="md"
                            variant="elevated"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Outlined</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Outlined variant"
                            size="sm"
                            aspect="square"
                            rounded="md"
                            variant="outlined"
                        />
                    </div>
                </div>
            </div>

            {{-- Object Fit --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Object Fit</h3>
                <div class="flex gap-4 flex-wrap">
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Cover</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Cover fit"
                            size="sm"
                            aspect="square"
                            rounded="md"
                            fit="cover"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Contain</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Contain fit"
                            size="sm"
                            aspect="square"
                            rounded="md"
                            fit="contain"
                            variant="bordered"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Fill</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="Fill fit"
                            size="sm"
                            aspect="square"
                            rounded="md"
                            fit="fill"
                        />
                    </div>
                </div>
            </div>

            {{-- Fallback --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Fallback Handling</h3>
                <div class="flex gap-4 flex-wrap">
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Broken Image (Icon Fallback)</p>
                        <x-strata::image
                            src="https://invalid-url.com/broken.jpg"
                            alt="Broken image"
                            size="md"
                            aspect="square"
                            rounded="md"
                            variant="bordered"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">With Fallback Src</p>
                        <x-strata::image
                            src="https://invalid-url.com/broken.jpg"
                            fallbackSrc="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200"
                            alt="With fallback"
                            size="md"
                            aspect="square"
                            rounded="md"
                        />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Custom Fallback Icon</p>
                        <x-strata::image
                            src="https://invalid-url.com/broken.jpg"
                            alt="Custom fallback icon"
                            size="md"
                            aspect="square"
                            rounded="md"
                            variant="bordered"
                            fallbackIcon="image"
                        />
                    </div>
                </div>
            </div>

            {{-- With Captions --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">With Captions</h3>
                <div class="flex gap-4 flex-wrap">
                    <div class="space-y-2 max-w-xs">
                        <p class="text-sm text-muted-foreground">Bottom Caption</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400"
                            alt="Mountain with caption"
                            aspect="video"
                            rounded="md"
                            caption="Beautiful mountain landscape at sunset"
                            captionPosition="bottom"
                        />
                    </div>
                    <div class="space-y-2 max-w-xs">
                        <p class="text-sm text-muted-foreground">Overlay Caption</p>
                        <x-strata::image
                            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400"
                            alt="Mountain with overlay"
                            aspect="video"
                            rounded="md"
                            caption="Beautiful mountain landscape"
                            captionPosition="overlay"
                        />
                    </div>
                </div>
            </div>

            {{-- With Zoom Effect --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">With Zoom Effect (Hover)</h3>
                <div class="flex gap-4 flex-wrap">
                    <x-strata::image
                        src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400"
                        alt="Zoomable image"
                        size="md"
                        aspect="square"
                        rounded="md"
                        variant="elevated"
                        zoom
                    />
                </div>
            </div>

            {{-- With Placeholder --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">With Blur Placeholder</h3>
                <div class="flex gap-4 flex-wrap">
                    <x-strata::image
                        src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800"
                        alt="Image with placeholder"
                        size="md"
                        aspect="square"
                        rounded="md"
                        placeholder="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=10"
                    />
                </div>
            </div>

            {{-- Responsive Images --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Responsive Image (srcset)</h3>
                <div class="max-w-2xl">
                    <x-strata::image
                        src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800"
                        srcset="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400 400w,
                                https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800 800w,
                                https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200 1200w"
                        sizes="(max-width: 640px) 100vw, 800px"
                        alt="Responsive mountain"
                        aspect="video"
                        rounded="md"
                        variant="elevated"
                    />
                </div>
            </div>

            {{-- Avatar Use Case --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Avatar Use Case</h3>
                <div class="flex gap-4 flex-wrap">
                    <x-strata::image
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200"
                        alt="User avatar"
                        size="md"
                        aspect="square"
                        rounded="full"
                        variant="bordered"
                    />
                    <x-strata::image
                        src="https://invalid-url.com/avatar.jpg"
                        fallbackSrc="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200"
                        alt="User avatar with fallback"
                        size="md"
                        aspect="square"
                        rounded="full"
                        variant="bordered"
                    />
                    <x-strata::image
                        src="https://invalid-url.com/avatar.jpg"
                        alt="User avatar"
                        size="md"
                        aspect="square"
                        rounded="full"
                        variant="bordered"
                        fallbackIcon="user"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
