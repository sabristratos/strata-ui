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

    {{-- CSS Anchor Positioning Polyfill --}}
    <script type="module">
      if (!("anchorName" in document.documentElement.style)) {
        import("https://unpkg.com/@oddbird/css-anchor-positioning");
      }
    </script>
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

        <livewire:select-demo />

        <div class="border-t border-border my-12"></div>

        <livewire:time-picker-demo />
    </div>

    @livewireScripts
</body>
</html>
