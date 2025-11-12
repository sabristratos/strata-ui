<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Strata UI - Component Showcase</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-body text-foreground min-h-screen" x-data="{ darkMode: $persist(false).as('darkMode') }" :class="darkMode ? 'scheme-dark' : 'scheme-light'">
    <x-strata::toast />

    {{-- Component Demos --}}
    <div class="container mx-auto p-8 space-y-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold mb-2">Strata UI Components</h1>
                <p class="text-muted">Components with native Popover API + CSS Anchor Positioning</p>
            </div>
            <button
                @click="darkMode = !darkMode"
                class="p-2 rounded-lg border border-border bg-card hover:bg-accent transition-colors"
            >
                <span x-show="!darkMode">🌙</span>
                <span x-show="darkMode">☀️</span>
            </button>
        </div>

        <x-strata::card >
            <livewire:color-picker-demo />
            <livewire:select-demo />
            <livewire:phone-input-demo />
        </x-strata::card>

        {{-- Toast Demo --}}
        <div class="space-y-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">Toast Notifications</h2>
                <p class="text-muted mb-4">Test toast notifications with Popover API</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Variants --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Variants</h3>
                    <div class="flex flex-wrap gap-2">
                        <button
                            @click="window.toast.success('Success!', 'Your changes have been saved successfully.')"
                            class="px-4 py-2 rounded-lg bg-success text-white hover:bg-success/90 transition-colors"
                        >
                            Success Toast
                        </button>
                        <button
                            @click="window.toast.error('Error!', 'Something went wrong. Please try again.')"
                            class="px-4 py-2 rounded-lg bg-destructive text-white hover:bg-destructive/90 transition-colors"
                        >
                            Error Toast
                        </button>
                        <button
                            @click="window.toast.warning('Warning!', 'This action cannot be undone.')"
                            class="px-4 py-2 rounded-lg bg-warning text-white hover:bg-warning/90 transition-colors"
                        >
                            Warning Toast
                        </button>
                        <button
                            @click="window.toast.info('Info', 'New features are now available.')"
                            class="px-4 py-2 rounded-lg bg-info text-white hover:bg-info/90 transition-colors"
                        >
                            Info Toast
                        </button>
                    </div>
                </div>

                {{-- Quick Tests --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Quick Tests</h3>
                    <div class="flex flex-wrap gap-2">
                        <button
                            @click="window.toast('Simple message')"
                            class="px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-colors"
                        >
                            Simple Toast
                        </button>
                        <button
                            @click="window.toast({ title: 'No Description', variant: 'success' })"
                            class="px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-colors"
                        >
                            Title Only
                        </button>
                        <button
                            @click="window.toast({ description: 'Description only', variant: 'info' })"
                            class="px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-colors"
                        >
                            Description Only
                        </button>
                        <button
                            @click="window.toast({ title: 'Persistent', description: 'This toast will not auto-dismiss', variant: 'warning', duration: 0 })"
                            class="px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-colors"
                        >
                            No Auto-dismiss
                        </button>
                    </div>
                </div>
            </div>

            {{-- Multiple Toasts --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Multiple Toasts</h3>
                <button
                    @click="
                        window.toast.success('First', 'This is the first toast');
                        setTimeout(() => window.toast.info('Second', 'This is the second toast'), 500);
                        setTimeout(() => window.toast.warning('Third', 'This is the third toast'), 1000);
                    "
                    class="px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-colors"
                >
                    Show Multiple Toasts
                </button>
            </div>
        </div>

        {{-- Tooltip Demo --}}
        <div class="space-y-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">Tooltips</h2>
                <p class="text-muted mb-4">Hover, focus, or click tooltips using Popover API with popover="hint"</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Basic Placements --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Placements</h3>
                    <div class="flex flex-wrap gap-4">
                        <x-strata::tooltip text="Tooltip on top" placement="top">
                            <button class="px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-colors">
                                Top
                            </button>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Tooltip on bottom" placement="bottom">
                            <button class="px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-colors">
                                Bottom
                            </button>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Tooltip on right" placement="right">
                            <button class="px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-colors">
                                Right
                            </button>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Tooltip on left" placement="left">
                            <button class="px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-colors">
                                Left
                            </button>
                        </x-strata::tooltip>
                    </div>
                </div>

                {{-- Custom Content --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Custom Content</h3>
                    <x-strata::tooltip placement="bottom-start">
                        <x-slot:content>
                            <strong>Custom HTML</strong>
                            <p class="text-sm mt-1">Tooltips can contain rich content</p>
                        </x-slot:content>
                        <button class="px-4 py-2 rounded-lg bg-secondary text-secondary-foreground hover:bg-secondary/90 transition-colors">
                            Rich Content
                        </button>
                    </x-strata::tooltip>
                </div>
            </div>

            {{-- Multiple Tooltips Test --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Multiple Tooltips (popover="hint" behavior)</h3>
                <p class="text-sm text-muted">Hover over multiple buttons - tooltips won't close each other</p>
                <div class="flex flex-wrap gap-4">
                    <x-strata::tooltip text="First tooltip">
                        <button class="px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-colors">
                            Button 1
                        </button>
                    </x-strata::tooltip>

                    <x-strata::tooltip text="Second tooltip">
                        <button class="px-4 py-2 rounded-lg bg-success text-success-foreground hover:bg-success/90 transition-colors">
                            Button 2
                        </button>
                    </x-strata::tooltip>

                    <x-strata::tooltip text="Third tooltip">
                        <button class="px-4 py-2 rounded-lg bg-warning text-warning-foreground hover:bg-warning/90 transition-colors">
                            Button 3
                        </button>
                    </x-strata::tooltip>
                </div>
            </div>

            {{-- Focus Trigger --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Focus Trigger</h3>
                <x-strata::tooltip text="This appears on focus too" placement="top">
                    <input
                        type="text"
                        placeholder="Focus this input"
                        class="px-4 py-2 border border-border rounded-lg bg-background max-w-xs"
                    />
                </x-strata::tooltip>
            </div>
        </div>

        {{-- Carousel Demo --}}
        <div class="space-y-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">Carousel</h2>
                <p class="text-muted mb-4">Responsive carousel with native CSS scroll-snap, autoplay, and drag support</p>
            </div>

            {{-- Basic Carousel --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Basic Carousel</h3>
                <x-strata::carousel id="basic-carousel">
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg p-12 text-white text-center min-h-[300px] flex items-center justify-center">
                            <div>
                                <h3 class="text-3xl font-bold mb-2">Slide 1</h3>
                                <p>Basic carousel with navigation</p>
                            </div>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg p-12 text-white text-center min-h-[300px] flex items-center justify-center">
                            <div>
                                <h3 class="text-3xl font-bold mb-2">Slide 2</h3>
                                <p>Navigate with arrows or keyboard</p>
                            </div>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-pink-500 to-pink-700 rounded-lg p-12 text-white text-center min-h-[300px] flex items-center justify-center">
                            <div>
                                <h3 class="text-3xl font-bold mb-2">Slide 3</h3>
                                <p>Or drag to scroll</p>
                            </div>
                        </div>
                    </x-strata::carousel.slide>
                </x-strata::carousel>
            </div>

            {{-- Hero Carousel with Loop & Autoplay --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Hero Carousel (Loop + Autoplay)</h3>
                <x-strata::carousel id="hero-carousel" loop autoplay :autoplay-delay="4000" size="lg">
                    <x-strata::carousel.slide>
                        <div class="relative bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-lg p-16 text-white min-h-[400px] flex items-center justify-center">
                            <div class="text-center max-w-2xl">
                                <h3 class="text-4xl font-bold mb-4">Welcome to Strata UI</h3>
                                <p class="text-lg mb-6">Build beautiful applications with modern components</p>
                                <button class="px-6 py-3 bg-white text-emerald-700 rounded-lg font-semibold hover:bg-emerald-50 transition-colors">
                                    Get Started
                                </button>
                            </div>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="relative bg-gradient-to-br from-orange-500 to-orange-700 rounded-lg p-16 text-white min-h-[400px] flex items-center justify-center">
                            <div class="text-center max-w-2xl">
                                <h3 class="text-4xl font-bold mb-4">Native Performance</h3>
                                <p class="text-lg mb-6">CSS scroll-snap for buttery smooth scrolling</p>
                                <button class="px-6 py-3 bg-white text-orange-700 rounded-lg font-semibold hover:bg-orange-50 transition-colors">
                                    Learn More
                                </button>
                            </div>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="relative bg-gradient-to-br from-teal-500 to-teal-700 rounded-lg p-16 text-white min-h-[400px] flex items-center justify-center">
                            <div class="text-center max-w-2xl">
                                <h3 class="text-4xl font-bold mb-4">Fully Accessible</h3>
                                <p class="text-lg mb-6">Keyboard navigation and ARIA support built-in</p>
                                <button class="px-6 py-3 bg-white text-teal-700 rounded-lg font-semibold hover:bg-teal-50 transition-colors">
                                    Explore Components
                                </button>
                            </div>
                        </div>
                    </x-strata::carousel.slide>
                </x-strata::carousel>
            </div>

            {{-- Product Cards Carousel --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Product Gallery</h3>
                <x-strata::carousel id="product-gallery-carousel" size="sm">
                    <x-strata::carousel.slide>
                        <div class="bg-card border border-border rounded-lg p-6 min-h-[280px] flex flex-col">
                            <div class="bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-lg h-40 mb-4"></div>
                            <h4 class="font-semibold text-lg mb-2">Product 1</h4>
                            <p class="text-sm text-muted flex-grow">Amazing product description goes here</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-bold">$99.99</span>
                                <button class="px-4 py-2 bg-primary text-primary-foreground rounded-lg text-sm hover:bg-primary/90 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-card border border-border rounded-lg p-6 min-h-[280px] flex flex-col">
                            <div class="bg-gradient-to-br from-rose-400 to-rose-600 rounded-lg h-40 mb-4"></div>
                            <h4 class="font-semibold text-lg mb-2">Product 2</h4>
                            <p class="text-sm text-muted flex-grow">Another great product with awesome features</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-bold">$149.99</span>
                                <button class="px-4 py-2 bg-primary text-primary-foreground rounded-lg text-sm hover:bg-primary/90 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-card border border-border rounded-lg p-6 min-h-[280px] flex flex-col">
                            <div class="bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg h-40 mb-4"></div>
                            <h4 class="font-semibold text-lg mb-2">Product 3</h4>
                            <p class="text-sm text-muted flex-grow">Premium quality at an affordable price</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-bold">$79.99</span>
                                <button class="px-4 py-2 bg-primary text-primary-foreground rounded-lg text-sm hover:bg-primary/90 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-card border border-border rounded-lg p-6 min-h-[280px] flex flex-col">
                            <div class="bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-lg h-40 mb-4"></div>
                            <h4 class="font-semibold text-lg mb-2">Product 4</h4>
                            <p class="text-sm text-muted flex-grow">Limited edition special offer</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-bold">$199.99</span>
                                <button class="px-4 py-2 bg-primary text-primary-foreground rounded-lg text-sm hover:bg-primary/90 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </x-strata::carousel.slide>
                </x-strata::carousel>
            </div>

            {{-- Size Variants --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Extra Small (xs)</h3>
                    <x-strata::carousel id="xs-carousel" size="xs">
                        <x-strata::carousel.slide>
                            <div class="bg-gradient-to-br from-violet-400 to-violet-600 rounded-lg p-8 text-white text-center min-h-[200px] flex items-center justify-center">
                                <p class="font-semibold">XS Slide 1</p>
                            </div>
                        </x-strata::carousel.slide>
                        <x-strata::carousel.slide>
                            <div class="bg-gradient-to-br from-fuchsia-400 to-fuchsia-600 rounded-lg p-8 text-white text-center min-h-[200px] flex items-center justify-center">
                                <p class="font-semibold">XS Slide 2</p>
                            </div>
                        </x-strata::carousel.slide>
                    </x-strata::carousel>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Extra Large (xl)</h3>
                    <x-strata::carousel id="xl-carousel" size="xl">
                        <x-strata::carousel.slide>
                            <div class="bg-gradient-to-br from-sky-400 to-sky-600 rounded-lg p-8 text-white text-center min-h-[200px] flex items-center justify-center">
                                <p class="font-semibold">XL Slide 1</p>
                            </div>
                        </x-strata::carousel.slide>
                        <x-strata::carousel.slide>
                            <div class="bg-gradient-to-br from-lime-400 to-lime-600 rounded-lg p-8 text-white text-center min-h-[200px] flex items-center justify-center">
                                <p class="font-semibold">XL Slide 2</p>
                            </div>
                        </x-strata::carousel.slide>
                    </x-strata::carousel>
                </div>
            </div>

            {{-- No Navigation Controls --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Without Navigation Controls</h3>
                <p class="text-sm text-muted">Drag or swipe only</p>
                <x-strata::carousel id="no-navigation-carousel" :arrows="false" :dots="false">
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Drag me!</p>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Or swipe on mobile</p>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">No arrows needed</p>
                        </div>
                    </x-strata::carousel.slide>
                </x-strata::carousel>
            </div>

            {{-- Start Index Demo --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Start Index (Starts at Slide 3)</h3>
                <p class="text-sm text-muted">Carousel initialized to start at a specific slide</p>
                <x-strata::carousel id="start-index-carousel" :start-index="2">
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-slate-400 to-slate-600 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Slide 1 (Not visible on load)</p>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-neutral-400 to-neutral-600 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Slide 2 (Not visible on load)</p>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">✨ Slide 3 (Starts here!)</p>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-stone-400 to-stone-600 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Slide 4</p>
                        </div>
                    </x-strata::carousel.slide>
                </x-strata::carousel>
            </div>

            {{-- Enhanced Autoplay Options --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Stop on Last Slide</h3>
                    <p class="text-sm text-muted">Autoplay stops at the last slide instead of looping</p>
                    <x-strata::carousel id="stop-on-last-carousel" autoplay :autoplay-delay="2000" :stop-on-last-snap="true">
                        <x-strata::carousel.slide>
                            <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg p-8 text-white text-center min-h-[200px] flex items-center justify-center">
                                <p class="font-semibold">Slide 1</p>
                            </div>
                        </x-strata::carousel.slide>
                        <x-strata::carousel.slide>
                            <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg p-8 text-white text-center min-h-[200px] flex items-center justify-center">
                                <p class="font-semibold">Slide 2</p>
                            </div>
                        </x-strata::carousel.slide>
                        <x-strata::carousel.slide>
                            <div class="bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg p-8 text-white text-center min-h-[200px] flex items-center justify-center">
                                <p class="font-semibold">Slide 3 (Stops here)</p>
                            </div>
                        </x-strata::carousel.slide>
                    </x-strata::carousel>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Continue After Interaction</h3>
                    <p class="text-sm text-muted">Autoplay continues even after user interaction</p>
                    <x-strata::carousel id="continue-interaction-carousel" autoplay :autoplay-delay="2000" :stop-on-interaction="false">
                        <x-strata::carousel.slide>
                            <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-lg p-8 text-white text-center min-h-[200px] flex items-center justify-center">
                                <p class="font-semibold">Slide 1</p>
                            </div>
                        </x-strata::carousel.slide>
                        <x-strata::carousel.slide>
                            <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg p-8 text-white text-center min-h-[200px] flex items-center justify-center">
                                <p class="font-semibold">Slide 2</p>
                            </div>
                        </x-strata::carousel.slide>
                        <x-strata::carousel.slide>
                            <div class="bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg p-8 text-white text-center min-h-[200px] flex items-center justify-center">
                                <p class="font-semibold">Slide 3</p>
                            </div>
                        </x-strata::carousel.slide>
                    </x-strata::carousel>
                </div>
            </div>

            {{-- Jump Mode Demo --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Jump Mode (Instant Transitions)</h3>
                <p class="text-sm text-muted">No animations - instant slide changes</p>
                <x-strata::carousel id="jump-mode-carousel" :jump="true">
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-cyan-500 to-cyan-700 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Instant Jump 1</p>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Instant Jump 2</p>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-sky-500 to-sky-700 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Instant Jump 3</p>
                        </div>
                    </x-strata::carousel.slide>
                </x-strata::carousel>
            </div>

            {{-- Progress Indicator Demo --}}
            <div class="space-y-4" x-data="{ progress: 0 }">
                <h3 class="text-lg font-semibold">Progress Indicator</h3>
                <p class="text-sm text-muted">Track scroll progress with custom progress bar</p>
                <x-strata::carousel id="progress-carousel" x-on:carousel-settle="progress = $event.detail.scrollProgress">
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Progress: Start (0%)</p>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-violet-500 to-violet-700 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Progress: Middle (50%)</p>
                        </div>
                    </x-strata::carousel.slide>
                    <x-strata::carousel.slide>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg p-12 text-white text-center min-h-[250px] flex items-center justify-center">
                            <p class="text-xl font-semibold">Progress: End (100%)</p>
                        </div>
                    </x-strata::carousel.slide>
                </x-strata::carousel>

                {{-- Custom Progress Bar --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-muted">Scroll Progress</span>
                        <span class="font-semibold" x-text="`${Math.round(progress * 100)}%`"></span>
                    </div>
                    <div class="h-2 bg-muted rounded-full overflow-hidden">
                        <div
                            class="h-full bg-primary transition-all duration-300 ease-out"
                            :style="`width: ${progress * 100}%`"
                        ></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @livewireScripts
</body>
</html>
