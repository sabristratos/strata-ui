<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tooltip Test</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground p-8">
    <div class="max-w-4xl mx-auto space-y-8">
        <h1 class="text-3xl font-bold">Tooltip Component Test</h1>

        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">Basic Tooltip (Top)</h2>
                <x-strata::tooltip text="This is a tooltip on top">
                    <button class="px-4 py-2 bg-primary text-primary-foreground rounded-md">
                        Hover me (Top)
                    </button>
                </x-strata::tooltip>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-4">Tooltip Bottom</h2>
                <x-strata::tooltip text="This tooltip appears at the bottom" placement="bottom">
                    <button class="px-4 py-2 bg-primary text-primary-foreground rounded-md">
                        Hover me (Bottom)
                    </button>
                </x-strata::tooltip>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-4">Tooltip Right</h2>
                <x-strata::tooltip text="This tooltip appears on the right" placement="right">
                    <button class="px-4 py-2 bg-primary text-primary-foreground rounded-md">
                        Hover me (Right)
                    </button>
                </x-strata::tooltip>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-4">Tooltip Left</h2>
                <x-strata::tooltip text="This tooltip appears on the left" placement="left">
                    <button class="px-4 py-2 bg-primary text-primary-foreground rounded-md">
                        Hover me (Left)
                    </button>
                </x-strata::tooltip>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-4">Tooltip with Custom Content</h2>
                <x-strata::tooltip placement="bottom-start">
                    <x-slot:content>
                        <strong>Custom Content</strong>
                        <p>This tooltip has custom HTML content with multiple lines.</p>
                    </x-slot:content>
                    <button class="px-4 py-2 bg-primary text-primary-foreground rounded-md">
                        Hover for custom content
                    </button>
                </x-strata::tooltip>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-4">Multiple Tooltips (Test popover="hint")</h2>
                <div class="flex gap-4">
                    <x-strata::tooltip text="First tooltip">
                        <button class="px-4 py-2 bg-primary text-primary-foreground rounded-md">
                            Button 1
                        </button>
                    </x-strata::tooltip>

                    <x-strata::tooltip text="Second tooltip">
                        <button class="px-4 py-2 bg-secondary text-secondary-foreground rounded-md">
                            Button 2
                        </button>
                    </x-strata::tooltip>

                    <x-strata::tooltip text="Third tooltip">
                        <button class="px-4 py-2 bg-accent text-accent-foreground rounded-md">
                            Button 3
                        </button>
                    </x-strata::tooltip>
                </div>
                <p class="text-sm text-muted-foreground mt-2">
                    Try hovering over multiple buttons - tooltips should not close each other (popover="hint" behavior)
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-4">Focus Trigger Test</h2>
                <x-strata::tooltip text="This appears on focus too" placement="top">
                    <input
                        type="text"
                        placeholder="Focus this input"
                        class="px-4 py-2 border border-border rounded-md bg-background"
                    />
                </x-strata::tooltip>
            </div>
        </div>
    </div>
    @livewireScripts
</body>
</html>
