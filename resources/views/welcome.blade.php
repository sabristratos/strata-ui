<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Strata UI - Floating Components Showcase</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @strataStyles
</head>
<body class="bg-body text-foreground min-h-screen" x-data="{ darkMode: $persist(false).as('darkMode') }" :class="darkMode ? 'scheme-dark' : 'scheme-light'">
    <x-strata::toast />

    <div class="max-w-7xl mx-auto px-6 py-12">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-foreground mb-4">Strata UI</h1>
            <p class="text-xl text-muted-foreground">Modern Blade and Livewire Component Library</p>
            <p class="text-sm text-muted-foreground mt-2">Laravel 12 + Livewire 3 + Tailwind CSS v4 + Alpine.js</p>
        </div>

        {{-- Demo Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- User Profile Demo --}}
            <a href="{{ route('profile.demo') }}" class="block p-6 bg-card border border-border rounded-lg hover:border-primary transition-all duration-200 hover:shadow-lg group">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-semibold text-foreground group-hover:text-primary transition-colors">
                        User Profile Demo
                    </h3>
                    <span class="px-2 py-1 text-xs font-medium bg-primary/10 text-primary rounded">New</span>
                </div>
                <p class="text-sm text-muted-foreground mb-4">
                    Comprehensive demo testing Select, Date Picker, Time Picker, and Input components with Livewire integration.
                </p>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Select</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Date Picker</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Time Picker</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Value Objects</span>
                </div>
            </a>

            {{-- Appointment Booking Demo --}}
            <a href="{{ route('appointment-booking.demo') }}" class="block p-6 bg-card border border-border rounded-lg hover:border-primary transition-all duration-200 hover:shadow-lg group">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-semibold text-foreground group-hover:text-primary transition-colors">
                        Appointment Booking
                    </h3>
                </div>
                <p class="text-sm text-muted-foreground mb-4">
                    Multi-step booking flow with date ranges, time slots, and validation using DateValue, DateRange, and TimeValue objects.
                </p>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Date Picker</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Time Picker</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Calendar</span>
                </div>
            </a>

            {{-- Slider Demo --}}
            <a href="{{ route('slider.demo') }}" class="block p-6 bg-card border border-border rounded-lg hover:border-primary transition-all duration-200 hover:shadow-lg group">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-semibold text-foreground group-hover:text-primary transition-colors">
                        Slider Component
                    </h3>
                </div>
                <p class="text-sm text-muted-foreground mb-4">
                    Carousel/slider with autoplay, loop, peek mode, navigation, and keyboard support.
                </p>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Slider</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Autoplay</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Accessibility</span>
                </div>
            </a>

            {{-- Editor Demo --}}
            <a href="{{ route('editor.demo') }}" class="block p-6 bg-card border border-border rounded-lg hover:border-primary transition-all duration-200 hover:shadow-lg group">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-semibold text-foreground group-hover:text-primary transition-colors">
                        Rich Text Editor
                    </h3>
                </div>
                <p class="text-sm text-muted-foreground mb-4">
                    WYSIWYG editor with formatting toolbar, markdown support, and Livewire integration.
                </p>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Editor</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Toolbar</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">WYSIWYG</span>
                </div>
            </a>

            {{-- Sidebar Demo --}}
            <a href="{{ route('sidebar.demo') }}" class="block p-6 bg-card border border-border rounded-lg hover:border-primary transition-all duration-200 hover:shadow-lg group">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-semibold text-foreground group-hover:text-primary transition-colors">
                        Sidebar Navigation
                    </h3>
                </div>
                <p class="text-sm text-muted-foreground mb-4">
                    Responsive sidebar with collapsible sections, mobile drawer, and keyboard navigation.
                </p>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Sidebar</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Navigation</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Responsive</span>
                </div>
            </a>

            {{-- Lightbox Demo --}}
            <a href="{{ route('lightbox.demo') }}" class="block p-6 bg-card border border-border rounded-lg hover:border-primary transition-all duration-200 hover:shadow-lg group">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-semibold text-foreground group-hover:text-primary transition-colors">
                        Lightbox Gallery
                    </h3>
                </div>
                <p class="text-sm text-muted-foreground mb-4">
                    Image gallery with lightbox overlay, zoom, navigation, and keyboard shortcuts.
                </p>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Lightbox</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Gallery</span>
                    <span class="px-2 py-0.5 text-xs bg-muted text-muted-foreground rounded">Images</span>
                </div>
            </a>
        </div>

        {{-- Footer --}}
        <div class="mt-16 text-center text-sm text-muted-foreground">
            <p>All components follow modern best practices with accessibility, validation, and Livewire integration.</p>
            <p class="mt-2">Built with Laravel 12, Livewire 3, Tailwind CSS v4, and Alpine.js</p>
        </div>
    </div>

    <button
        @click="darkMode = !darkMode"
        class="fixed bottom-6 right-6 p-3 bg-card border border-border rounded-full shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 z-50"
        aria-label="Toggle dark mode"
    >
        <x-strata::icon.sun x-show="darkMode" class="w-5 h-5 text-foreground" />
        <x-strata::icon.moon x-show="!darkMode" class="w-5 h-5 text-foreground" />
    </button>

    @strataScripts
    @livewireScripts
</body>
</html>
