<div class="p-8 space-y-12 max-w-7xl mx-auto">
    <div class="space-y-4">
        <h2 class="text-2xl font-bold">Slider Component Demo</h2>
        <p class="text-muted-foreground">
            Modern CSS scroll-snap based slider with peek mode, autoplay, and keyboard navigation.
        </p>
    </div>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Basic Image Slider with Peek Mode</h3>
        <p class="text-sm text-muted-foreground">Peek mode shows a portion of adjacent slides with reduced opacity and scale</p>

        <x-strata::slider peek autoplay loop>
            @foreach($images as $index => $image)
                <x-strata::slider.item :index="$index">
                    <img
                        src="{{ $image['url'] }}"
                        alt="{{ $image['caption'] }}"
                        class="w-full h-96 object-cover rounded-lg"
                    />
                </x-strata::slider.item>
            @endforeach
        </x-strata::slider>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Standard Slider (No Peek)</h3>
        <p class="text-sm text-muted-foreground">Traditional slider without peek mode</p>

        <x-strata::slider loop showNavigation="false">
            @foreach($images as $index => $image)
                <x-strata::slider.item :index="$index">
                    <img
                        src="{{ $image['url'] }}"
                        alt="{{ $image['caption'] }}"
                        class="w-full h-80 object-cover rounded-lg"
                    />
                </x-strata::slider.item>
            @endforeach
        </x-strata::slider>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Card Carousel (3 Per View)</h3>
        <p class="text-sm text-muted-foreground">Multiple items visible at once</p>

        <x-strata::slider perView="3" gap="6" showDots="false">
            @foreach($testimonials as $index => $testimonial)
                <x-strata::slider.item :index="$index">
                    <x-strata::card class="h-full">
                        <div class="p-6 space-y-4">
                            <p class="text-sm leading-relaxed">{{ $testimonial['content'] }}</p>
                            <div class="pt-4 border-t border-border">
                                <p class="font-semibold">{{ $testimonial['author'] }}</p>
                                <p class="text-sm text-muted-foreground">{{ $testimonial['role'] }}</p>
                            </div>
                        </div>
                    </x-strata::card>
                </x-strata::slider.item>
            @endforeach
        </x-strata::slider>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Floating Navigation</h3>
        <p class="text-sm text-muted-foreground">Navigation buttons positioned over the slides</p>

        <div class="relative">
            <x-strata::slider peek peekAmount="5%" loop showDots="false" showNavigation="false">
                @foreach($images as $index => $image)
                    <x-strata::slider.item :index="$index">
                        <img
                            src="{{ $image['url'] }}"
                            alt="{{ $image['caption'] }}"
                            class="w-full h-96 object-cover rounded-lg"
                        />
                    </x-strata::slider.item>
                @endforeach

                <x-strata::slider.navigation variant="floating" position="sides" />
            </x-strata::slider>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Hero Slider with Large Peek</h3>
        <p class="text-sm text-muted-foreground">Full-width hero section with prominent peek</p>

        <x-strata::slider peek peekAmount="15%" autoplay autoplayDelay="7000" loop>
            <x-strata::slider.item :index="0">
                <div class="h-96 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center text-white">
                    <div class="text-center space-y-4 p-8">
                        <h2 class="text-4xl font-bold">Welcome to Strata UI</h2>
                        <p class="text-xl">Modern components for Laravel</p>
                    </div>
                </div>
            </x-strata::slider.item>

            <x-strata::slider.item :index="1">
                <div class="h-96 bg-gradient-to-r from-pink-500 to-orange-500 rounded-xl flex items-center justify-center text-white">
                    <div class="text-center space-y-4 p-8">
                        <h2 class="text-4xl font-bold">Beautiful Design</h2>
                        <p class="text-xl">Crafted with Tailwind CSS v4</p>
                    </div>
                </div>
            </x-strata::slider.item>

            <x-strata::slider.item :index="2">
                <div class="h-96 bg-gradient-to-r from-green-500 to-teal-500 rounded-xl flex items-center justify-center text-white">
                    <div class="text-center space-y-4 p-8">
                        <h2 class="text-4xl font-bold">Easy to Use</h2>
                        <p class="text-xl">Sensible defaults, extensive customization</p>
                    </div>
                </div>
            </x-strata::slider.item>
        </x-strata::slider>
    </section>

    <section class="space-y-4 pb-8">
        <h3 class="text-xl font-semibold">Features</h3>
        <ul class="list-disc list-inside space-y-2 text-sm text-muted-foreground">
            <li><strong>Peek Mode:</strong> Show portions of adjacent slides with opacity/scale effects</li>
            <li><strong>Autoplay:</strong> Automatic slide advancement with pause on hover</li>
            <li><strong>Loop Mode:</strong> Infinite scrolling from last slide back to first</li>
            <li><strong>Keyboard Navigation:</strong> Arrow Left/Right (navigate), Home (first), End (last)</li>
            <li><strong>Click to Navigate:</strong> Click on peeked slides to jump to them</li>
            <li><strong>Multiple Per View:</strong> Show 1, 2, 3, or 4 slides at once</li>
            <li><strong>Smooth Scrolling:</strong> Native CSS scroll-snap for performance</li>
            <li><strong>Responsive:</strong> Works beautifully on desktop and mobile</li>
        </ul>
    </section>
</div>
