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

    </div>

    @livewireScripts
</body>
</html>
