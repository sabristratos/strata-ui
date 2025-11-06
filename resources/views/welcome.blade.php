<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Strata UI - Component Showcase</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @livewireStyles
    @strataStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-body text-foreground min-h-screen" x-data="{ darkMode: $persist(false).as('darkMode') }" :class="darkMode ? 'scheme-dark' : 'scheme-light'">
    <x-strata::toast />

    <div class="container mx-auto p-8 space-y-12">
        {{-- Popover API + Alpine Anchor Concept --}}
        <section class="space-y-6">
            <h2 class="text-2xl font-semibold">Popover API + Alpine Anchor Concept</h2>
            <p class="text-sm text-muted-foreground">Native Popover API with Alpine Anchor positioning - no teleport needed!</p>

            <div class="flex gap-4 flex-wrap" x-data="{ submenuOpen: false }">
                {{-- Basic Popover --}}
                <div class="relative">
                    <button
                        x-ref="trigger1"
                        popovertarget="popover-1"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium h-10 px-4 py-2 bg-primary text-primary-foreground hover:bg-primary/90">
                        Open Popover
                    </button>

                    <div
                        id="popover-1"
                        popover="auto"
                        x-anchor.bottom-start.offset.8="$refs.trigger1"
                        class="bg-popover text-popover-foreground border border-border rounded-lg shadow-xl p-4 m-0">
                        <h3 class="font-semibold mb-2">Popover Title</h3>
                        <p class="text-sm">This uses native Popover API + Alpine Anchor for positioning!</p>
                        <ul class="mt-2 space-y-1">
                            <li class="text-sm">✓ No teleport needed</li>
                            <li class="text-sm">✓ Auto-dismiss on outside click</li>
                            <li class="text-sm">✓ Escape key closes</li>
                            <li class="text-sm">✓ Top layer rendering</li>
                        </ul>
                    </div>
                </div>

                {{-- Popover with Menu Items --}}
                <div class="relative">
                    <button
                        x-ref="trigger2"
                        popovertarget="popover-2"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium h-10 px-4 py-2 bg-secondary text-secondary-foreground hover:bg-secondary/80">
                        Menu Popover
                    </button>

                    <div
                        id="popover-2"
                        popover="auto"
                        x-anchor.bottom-start.offset.8="$refs.trigger2"
                        class="bg-popover text-popover-foreground border border-border rounded-lg shadow-xl p-1 m-0 min-w-[200px]">
                        <div class="px-3 py-2 hover:bg-accent rounded-md cursor-pointer">
                            <div class="font-medium">Profile</div>
                            <div class="text-xs text-muted-foreground">View your profile</div>
                        </div>
                        <div class="px-3 py-2 hover:bg-accent rounded-md cursor-pointer">
                            <div class="font-medium">Settings</div>
                            <div class="text-xs text-muted-foreground">Manage your settings</div>
                        </div>
                        <div class="h-px bg-border my-1"></div>
                        <div class="px-3 py-2 hover:bg-accent rounded-md cursor-pointer text-destructive">
                            <div class="font-medium">Logout</div>
                        </div>
                    </div>
                </div>

                {{-- Popover with Submenu --}}
                <div class="relative">
                    <button
                        x-ref="trigger3"
                        popovertarget="popover-3"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium h-10 px-4 py-2 bg-outline border border-input hover:bg-accent">
                        With Submenu
                    </button>

                    <div
                        id="popover-3"
                        popover="auto"
                        x-anchor.bottom-start.offset.8="$refs.trigger3"
                        class="bg-popover text-popover-foreground border border-border rounded-lg shadow-xl p-1 m-0 min-w-[200px]">
                        <div class="px-3 py-2 hover:bg-accent rounded-md cursor-pointer">
                            New File
                        </div>
                        <div class="px-3 py-2 hover:bg-accent rounded-md cursor-pointer">
                            Open
                        </div>

                        {{-- Submenu Trigger --}}
                        <div class="relative">
                            <button
                                x-ref="submenuTrigger"
                                popovertarget="submenu-1"
                                @mouseenter="submenuOpen = true"
                                class="w-full px-3 py-2 hover:bg-accent rounded-md cursor-pointer text-left flex items-center justify-between">
                                <span>Export</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>

                            {{-- Submenu Popover --}}
                            <div
                                id="submenu-1"
                                popover="manual"
                                x-anchor.right-start.offset.4="$refs.submenuTrigger"
                                x-bind:class="{ 'open': submenuOpen }"
                                class="bg-popover text-popover-foreground border border-border rounded-lg shadow-xl p-1 m-0 min-w-[180px]">
                                <div class="px-3 py-2 hover:bg-accent rounded-md cursor-pointer">
                                    Export as PDF
                                </div>
                                <div class="px-3 py-2 hover:bg-accent rounded-md cursor-pointer">
                                    Export as CSV
                                </div>
                                <div class="px-3 py-2 hover:bg-accent rounded-md cursor-pointer">
                                    Export as JSON
                                </div>
                                <div class="px-3 py-2 hover:bg-accent rounded-md cursor-pointer">
                                    Export as Excel
                                </div>
                            </div>
                        </div>

                        <div class="h-px bg-border my-1"></div>
                        <div class="px-3 py-2 hover:bg-accent rounded-md cursor-pointer">
                            Exit
                        </div>
                    </div>
                </div>

                {{-- Top Placement --}}
                <div class="relative mt-32">
                    <button
                        x-ref="trigger4"
                        popovertarget="popover-4"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium h-10 px-4 py-2 bg-primary text-primary-foreground hover:bg-primary/90">
                        Open Top
                    </button>

                    <div
                        id="popover-4"
                        popover="auto"
                        x-anchor.top-start.offset.8="$refs.trigger4"
                        class="bg-popover text-popover-foreground border border-border rounded-lg shadow-xl p-4 m-0">
                        <p class="text-sm">This opens above the button!</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <h2 class="text-2xl font-semibold">Old Dropdown Tests - Alpine Anchor + Teleport</h2>

            <div class="flex gap-4 flex-wrap">
                <x-strata::dropdown placement="bottom-start">
                    <x-strata::dropdown.trigger>
                        <x-strata::button>Bottom Start</x-strata::button>
                    </x-strata::dropdown.trigger>
                    <x-strata::dropdown.content>
                        <x-strata::dropdown.item>Item 1</x-strata::dropdown.item>
                        <x-strata::dropdown.item>Item 2</x-strata::dropdown.item>
                        <x-strata::dropdown.item>Item 3</x-strata::dropdown.item>
                    </x-strata::dropdown.content>
                </x-strata::dropdown>

                <x-strata::dropdown placement="bottom-end">
                    <x-strata::dropdown.trigger>
                        <x-strata::button variant="secondary">Bottom End</x-strata::button>
                    </x-strata::dropdown.trigger>
                    <x-strata::dropdown.content>
                        <x-strata::dropdown.item>Item A</x-strata::dropdown.item>
                        <x-strata::dropdown.item>Item B</x-strata::dropdown.item>
                        <x-strata::dropdown.item>Item C</x-strata::dropdown.item>
                    </x-strata::dropdown.content>
                </x-strata::dropdown>
            </div>
        </section>
    </div>

    <livewire:date-time-picker-demo />

    {{-- Dark Mode Toggle --}}
        <div class="fixed bottom-6 right-6">
            <x-strata::button.icon
                icon="moon"
                x-on:click="darkMode = !darkMode"
                variant="secondary"
                size="lg"
                class="shadow-lg"
                aria-label="Toggle dark mode"
            />
        </div>
    </div>

    @livewireScripts
    @strataScripts
</body>
</html>
