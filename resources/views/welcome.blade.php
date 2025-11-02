<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }} - Strata UI Showcase</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @strataStyles
    </head>
    <body class="bg-body text-foreground p-8" x-data="{ darkMode: $persist(false).as('darkMode') }" :class="darkMode ? 'scheme-dark' : 'scheme-light'">

        @livewire('component-showcase')

        <div class="mt-16 pt-16 border-t border-border">
            <h1 class="text-3xl font-bold mb-8">Tabs Component</h1>
            @livewire('tabs-demo')
        </div>

        <div class="mt-16 pt-16 border-t border-border">
            <h1 class="text-3xl font-bold mb-8">Breadcrumbs Component</h1>
            @livewire('breadcrumbs-demo')
        </div>

        <div class="mt-16 pt-16 border-t border-border">
            <h1 class="text-3xl font-bold mb-8">Toast Component</h1>
            @livewire('toast-demo')
        </div>

        <div class="mt-16 pt-16 border-t border-border">
            <h1 class="text-3xl font-bold mb-8">Tooltip Component</h1>
            @livewire('tooltip-demo')
        </div>

        <div class="mt-16 pt-16 border-t border-border">
            @livewire('table-demo')
        </div>

        <x-strata::toast />

        {{-- Theme Switcher --}}
        <button
            @click="darkMode = !darkMode"
            class="fixed bottom-6 right-6 p-3 bg-card border border-border rounded-full shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
            aria-label="Toggle dark mode"
        >
            <x-strata::icon.sun x-show="darkMode" class="w-5 h-5 text-foreground" />
            <x-strata::icon.moon x-show="!darkMode" class="w-5 h-5 text-foreground" />
        </button>

    @strataScripts
    @livewireScripts
    </body>
</html>
