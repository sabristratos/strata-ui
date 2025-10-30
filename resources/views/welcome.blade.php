<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @unless (app()->environment('local'))
            @strataStyles
        @endunless
    </head>
    <body class="bg-background p-8 space-y-8" x-data="{ darkMode: $persist(false).as('darkMode') }" :class="darkMode ? 'scheme-dark' : 'scheme-light'">

        {{-- Select Component Demo --}}
        <div>
            <h2 class="text-xl font-semibold mb-4">Select - Livewire Integration Demo</h2>
            <x-strata::card style="elevated">
                <x-strata::card.body padding="lg">
                    @livewire('select-demo')
                </x-strata::card.body>
            </x-strata::card>
        </div>

        {{-- Toggle Component Demo --}}
        <div>
            <h2 class="text-xl font-semibold mb-4">Toggle - Livewire Integration Demo</h2>
            <x-strata::card style="elevated">
                <x-strata::card.body padding="lg">
                    @livewire('toggle-demo')
                </x-strata::card.body>
            </x-strata::card>
        </div>

        {{-- Kbd Component Demo --}}
        <div>
            <h2 class="text-xl font-semibold mb-4">Kbd Component Demo</h2>
            <x-strata::card style="elevated">
                <x-strata::card.body padding="lg">
                    <div class="space-y-6">
                        {{-- Sizes Demo --}}
                        <div>
                            <h3 class="text-lg font-medium mb-3">Sizes</h3>
                            <div class="flex flex-wrap items-center gap-3">
                                <x-strata::kbd size="sm">Ctrl</x-strata::kbd>
                                <x-strata::kbd size="md">Shift</x-strata::kbd>
                                <x-strata::kbd size="lg">Enter</x-strata::kbd>
                            </div>
                        </div>

                        {{-- Variants Demo --}}
                        <div>
                            <h3 class="text-lg font-medium mb-3">Variants</h3>
                            <div class="flex flex-wrap items-center gap-3">
                                <x-strata::kbd variant="primary">Primary</x-strata::kbd>
                                <x-strata::kbd variant="secondary">Secondary</x-strata::kbd>
                                <x-strata::kbd variant="success">Success</x-strata::kbd>
                                <x-strata::kbd variant="warning">Warning</x-strata::kbd>
                                <x-strata::kbd variant="destructive">Destructive</x-strata::kbd>
                                <x-strata::kbd variant="info">Info</x-strata::kbd>
                            </div>
                        </div>

                        {{-- Practical Examples --}}
                        <div>
                            <h3 class="text-lg font-medium mb-3">Practical Examples</h3>
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-muted-foreground">Single key:</span>
                                    <x-strata::kbd>⌘</x-strata::kbd>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-muted-foreground">Key combination:</span>
                                    <x-strata::kbd>Ctrl</x-strata::kbd>
                                    <span>+</span>
                                    <x-strata::kbd>C</x-strata::kbd>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-muted-foreground">Command shortcut:</span>
                                    <x-strata::kbd>⌘</x-strata::kbd>
                                    <span>+</span>
                                    <x-strata::kbd>K</x-strata::kbd>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-muted-foreground">Complex combination:</span>
                                    <x-strata::kbd size="sm">Ctrl</x-strata::kbd>
                                    <span class="text-sm">+</span>
                                    <x-strata::kbd size="sm">Shift</x-strata::kbd>
                                    <span class="text-sm">+</span>
                                    <x-strata::kbd size="sm">P</x-strata::kbd>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-strata::card.body>
            </x-strata::card>
        </div>

        {{-- Modal Component Demo --}}
        <div>
            <h2 class="text-xl font-semibold mb-4">Modal - Livewire Integration Demo</h2>
            <x-strata::card style="elevated">
                <x-strata::card.body padding="lg">
                    @livewire('modal-demo')
                </x-strata::card.body>
            </x-strata::card>
        </div>

        {{-- Calendar Component Demo --}}
        <div>
            <h2 class="text-xl font-semibold mb-4">Calendar - Livewire Integration Demo</h2>
            <x-strata::card style="elevated">
                <x-strata::card.body padding="lg">
                    @livewire('calendar-demo')
                </x-strata::card.body>
            </x-strata::card>
        </div>

        {{-- Repeater Component Demo --}}
        <div>
            <h2 class="text-xl font-semibold mb-4">Repeater - Livewire Integration Demo</h2>
            <x-strata::card style="elevated">
                <x-strata::card.body padding="lg">
                    @livewire('repeater-demo')
                </x-strata::card.body>
            </x-strata::card>
        </div>

        {{-- Theme Switcher --}}
        <button
            @click="darkMode = !darkMode"
            class="fixed bottom-6 right-6 p-3 bg-card border border-border rounded-full shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
            aria-label="Toggle dark mode"
        >
            <x-strata::icon.sun x-show="darkMode" class="w-5 h-5 text-foreground" />
            <x-strata::icon.moon x-show="!darkMode" class="w-5 h-5 text-foreground" />
        </button>

    @unless (app()->environment('local'))
        @strataScripts
    @endunless
    @livewireScripts
    </body>
</html>
