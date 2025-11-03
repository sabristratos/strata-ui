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

    <button
        @click="darkMode = !darkMode"
        class="fixed bottom-6 right-6 p-3 bg-card border border-border rounded-full shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 z-50"
        aria-label="Toggle dark mode"
    >
        <x-strata::icon.sun x-show="darkMode" class="w-5 h-5 text-foreground" />
        <x-strata::icon.moon x-show="!darkMode" class="w-5 h-5 text-foreground" />
    </button>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-20">
        {{-- Hero Section --}}
        <header class="text-center space-y-6 py-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full text-sm font-medium text-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Enhanced with Floating UI v3 Middleware
            </div>

            <h1 class="text-5xl md:text-6xl font-bold text-foreground tracking-tight">
                Strata UI
                <span class="block text-primary mt-2">Floating Components</span>
            </h1>

            <p class="text-xl text-muted-foreground max-w-2xl mx-auto">
                Comprehensive showcase of dropdowns, selects, tooltips, modals, and date pickers with advanced positioning features
            </p>
        </header>

        {{-- Dropdowns Section --}}
        <section>
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-2">Dropdowns</h2>
                <p class="text-muted-foreground">Context menus, action menus, and nested dropdowns with all placement options.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Basic Dropdown --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Basic Dropdown</h3>
                    <x-strata::dropdown id="basic-dropdown">
                        <x-strata::dropdown.trigger data-dropdown-trigger="basic-dropdown">
                            <x-strata::button icon-trailing="chevron-down">
                                Actions
                            </x-strata::button>
                        </x-strata::dropdown.trigger>

                        <x-strata::dropdown.content>
                            <x-strata::dropdown.item icon="edit">
                                Edit
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.item icon="copy">
                                Duplicate
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.item icon="archive">
                                Archive
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.divider />
                            <x-strata::dropdown.item icon="trash" destructive>
                                Delete
                            </x-strata::dropdown.item>
                        </x-strata::dropdown.content>
                    </x-strata::dropdown>
                </div>

                {{-- Placements --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Different Placements</h3>
                    <div class="flex flex-wrap gap-2">
                        <x-strata::dropdown id="top-dropdown" placement="top">
                            <x-strata::dropdown.trigger data-dropdown-trigger="top-dropdown">
                                <x-strata::button size="sm">Top</x-strata::button>
                            </x-strata::dropdown.trigger>
                            <x-strata::dropdown.content>
                                <x-strata::dropdown.item icon="arrow-up">
                                    Placed Above
                                </x-strata::dropdown.item>
                            </x-strata::dropdown.content>
                        </x-strata::dropdown>

                        <x-strata::dropdown id="bottom-dropdown" placement="bottom-start">
                            <x-strata::dropdown.trigger data-dropdown-trigger="bottom-dropdown">
                                <x-strata::button size="sm">Bottom</x-strata::button>
                            </x-strata::dropdown.trigger>
                            <x-strata::dropdown.content>
                                <x-strata::dropdown.item icon="arrow-down">
                                    Placed Below
                                </x-strata::dropdown.item>
                            </x-strata::dropdown.content>
                        </x-strata::dropdown>

                        <x-strata::dropdown id="left-dropdown" placement="left">
                            <x-strata::dropdown.trigger data-dropdown-trigger="left-dropdown">
                                <x-strata::button size="sm">Left</x-strata::button>
                            </x-strata::dropdown.trigger>
                            <x-strata::dropdown.content>
                                <x-strata::dropdown.item icon="arrow-left">
                                    Placed Left
                                </x-strata::dropdown.item>
                            </x-strata::dropdown.content>
                        </x-strata::dropdown>

                        <x-strata::dropdown id="right-dropdown" placement="right">
                            <x-strata::dropdown.trigger data-dropdown-trigger="right-dropdown">
                                <x-strata::button size="sm">Right</x-strata::button>
                            </x-strata::dropdown.trigger>
                            <x-strata::dropdown.content>
                                <x-strata::dropdown.item icon="arrow-right">
                                    Placed Right
                                </x-strata::dropdown.item>
                            </x-strata::dropdown.content>
                        </x-strata::dropdown>
                    </div>
                </div>

                {{-- User Menu Dropdown --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">User Menu</h3>
                    <x-strata::dropdown id="user-dropdown">
                        <x-strata::dropdown.trigger data-dropdown-trigger="user-dropdown">
                            <x-strata::button variant="secondary">
                                <x-strata::avatar fallback="JD" size="sm" class="mr-2" />
                                John Doe
                            </x-strata::button>
                        </x-strata::dropdown.trigger>

                        <x-strata::dropdown.content>
                            <x-strata::dropdown.label>My Account</x-strata::dropdown.label>
                            <x-strata::dropdown.item icon="user">
                                Profile
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.item icon="settings">
                                Settings
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.divider />
                            <x-strata::dropdown.label>Team</x-strata::dropdown.label>
                            <x-strata::dropdown.item icon="users">
                                Team Members
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.item icon="plus-circle">
                                Invite Users
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.divider />
                            <x-strata::dropdown.item icon="log-out" destructive>
                                Log Out
                            </x-strata::dropdown.item>
                        </x-strata::dropdown.content>
                    </x-strata::dropdown>
                </div>

                {{-- Nested Submenu --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Nested Submenu</h3>
                    <x-strata::dropdown id="nested-dropdown">
                        <x-strata::dropdown.trigger data-dropdown-trigger="nested-dropdown">
                            <x-strata::button icon="menu">
                                Menu
                            </x-strata::button>
                        </x-strata::dropdown.trigger>

                        <x-strata::dropdown.content>
                            <x-strata::dropdown.item icon="file">
                                New File
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.item icon="folder">
                                New Folder
                            </x-strata::dropdown.item>

                            <x-strata::dropdown.submenu label="Share" icon="share" trigger="share-submenu">
                                <x-strata::dropdown.item icon="mail">
                                    Email
                                </x-strata::dropdown.item>
                                <x-strata::dropdown.item icon="link">
                                    Copy Link
                                </x-strata::dropdown.item>
                                <x-strata::dropdown.item icon="users">
                                    Share with Team
                                </x-strata::dropdown.item>
                            </x-strata::dropdown.submenu>

                            <x-strata::dropdown.divider />

                            <x-strata::dropdown.submenu label="More Options" icon="more-horizontal" trigger="more-submenu" placement="right-start">
                                <x-strata::dropdown.item icon="download">
                                    Download
                                </x-strata::dropdown.item>
                                <x-strata::dropdown.item icon="printer">
                                    Print
                                </x-strata::dropdown.item>
                                <x-strata::dropdown.item icon="star">
                                    Add to Favorites
                                </x-strata::dropdown.item>
                            </x-strata::dropdown.submenu>
                        </x-strata::dropdown.content>
                    </x-strata::dropdown>
                </div>

                {{-- Icon Button Dropdown --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Icon Button Dropdown</h3>
                    <x-strata::dropdown id="icon-dropdown">
                        <x-strata::dropdown.trigger data-dropdown-trigger="icon-dropdown">
                            <x-strata::button.icon icon="more-vertical" variant="ghost" />
                        </x-strata::dropdown.trigger>

                        <x-strata::dropdown.content>
                            <x-strata::dropdown.item icon="eye">
                                View Details
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.item icon="edit">
                                Edit
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.item icon="copy">
                                Duplicate
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.divider />
                            <x-strata::dropdown.item icon="trash" destructive>
                                Delete
                            </x-strata::dropdown.item>
                        </x-strata::dropdown.content>
                    </x-strata::dropdown>
                </div>

                {{-- Disabled Items --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">With Disabled Items</h3>
                    <x-strata::dropdown id="disabled-dropdown">
                        <x-strata::dropdown.trigger data-dropdown-trigger="disabled-dropdown">
                            <x-strata::button>
                                Options
                            </x-strata::button>
                        </x-strata::dropdown.trigger>

                        <x-strata::dropdown.content>
                            <x-strata::dropdown.item icon="check">
                                Available Action
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.item icon="lock" disabled>
                                Locked Feature
                            </x-strata::dropdown.item>
                            <x-strata::dropdown.item icon="crown" disabled>
                                Premium Only
                            </x-strata::dropdown.item>
                        </x-strata::dropdown.content>
                    </x-strata::dropdown>
                </div>
            </div>
        </section>

        {{-- Selects Section --}}
        <section>
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-2">Select Components</h2>
                <p class="text-muted-foreground">Searchable, multi-select, and grouped select dropdowns.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Basic Select --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Basic Select</h3>
                    <x-strata::select placeholder="Choose an option">
                        <x-strata::select.option value="1">Option One</x-strata::select.option>
                        <x-strata::select.option value="2">Option Two</x-strata::select.option>
                        <x-strata::select.option value="3">Option Three</x-strata::select.option>
                        <x-strata::select.option value="4">Option Four</x-strata::select.option>
                    </x-strata::select>
                </div>

                {{-- Searchable Select --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Searchable Select</h3>
                    <x-strata::select searchable placeholder="Search countries...">
                        <x-strata::select.option value="us">United States</x-strata::select.option>
                        <x-strata::select.option value="uk">United Kingdom</x-strata::select.option>
                        <x-strata::select.option value="ca">Canada</x-strata::select.option>
                        <x-strata::select.option value="au">Australia</x-strata::select.option>
                        <x-strata::select.option value="de">Germany</x-strata::select.option>
                        <x-strata::select.option value="fr">France</x-strata::select.option>
                        <x-strata::select.option value="jp">Japan</x-strata::select.option>
                    </x-strata::select>
                </div>

                {{-- Multi Select --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Multi Select</h3>
                    <x-strata::select multiple placeholder="Select multiple...">
                        <x-strata::select.option value="read">Read</x-strata::select.option>
                        <x-strata::select.option value="write">Write</x-strata::select.option>
                        <x-strata::select.option value="delete">Delete</x-strata::select.option>
                        <x-strata::select.option value="admin">Admin</x-strata::select.option>
                    </x-strata::select>
                </div>

                {{-- Searchable Multi Select --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Searchable Multi Select</h3>
                    <x-strata::select multiple searchable placeholder="Select technologies...">
                        <x-strata::select.option value="laravel">Laravel</x-strata::select.option>
                        <x-strata::select.option value="livewire">Livewire</x-strata::select.option>
                        <x-strata::select.option value="alpine">Alpine.js</x-strata::select.option>
                        <x-strata::select.option value="tailwind">Tailwind CSS</x-strata::select.option>
                        <x-strata::select.option value="vue">Vue.js</x-strata::select.option>
                        <x-strata::select.option value="react">React</x-strata::select.option>
                    </x-strata::select>
                </div>

                {{-- Select Sizes --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Different Sizes</h3>
                    <div class="space-y-3">
                        <x-strata::select size="sm" placeholder="Small">
                            <x-strata::select.option value="1">Small Option</x-strata::select.option>
                        </x-strata::select>

                        <x-strata::select size="md" placeholder="Medium (Default)">
                            <x-strata::select.option value="1">Medium Option</x-strata::select.option>
                        </x-strata::select>

                        <x-strata::select size="lg" placeholder="Large">
                            <x-strata::select.option value="1">Large Option</x-strata::select.option>
                        </x-strata::select>
                    </div>
                </div>

                {{-- Select States --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Different States</h3>
                    <div class="space-y-3">
                        <x-strata::select state="default" placeholder="Default State">
                            <x-strata::select.option value="1">Option</x-strata::select.option>
                        </x-strata::select>

                        <x-strata::select state="success" placeholder="Success State">
                            <x-strata::select.option value="1">Option</x-strata::select.option>
                        </x-strata::select>

                        <x-strata::select state="error" placeholder="Error State">
                            <x-strata::select.option value="1">Option</x-strata::select.option>
                        </x-strata::select>

                        <x-strata::select disabled placeholder="Disabled State">
                            <x-strata::select.option value="1">Option</x-strata::select.option>
                        </x-strata::select>
                    </div>
                </div>
            </div>
        </section>

        {{-- Tooltips Section --}}
        <section>
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-2">Tooltips</h2>
                <p class="text-muted-foreground">Contextual information on hover with multiple placements and rich content.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Basic Tooltips --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Basic Tooltips</h3>
                    <div class="flex flex-wrap gap-3">
                        <x-strata::tooltip text="Simple tooltip text">
                            <x-strata::button>Hover Me</x-strata::button>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Helpful information">
                            <x-strata::button.icon icon="circle-help" variant="ghost" />
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Delete action">
                            <x-strata::button.icon icon="trash" variant="destructive" />
                        </x-strata::tooltip>
                    </div>
                </div>

                {{-- Tooltip Placements --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Placement Options</h3>
                    <div class="flex flex-wrap gap-3">
                        <x-strata::tooltip text="Top placement" placement="top">
                            <x-strata::button size="sm">Top</x-strata::button>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Right placement" placement="right">
                            <x-strata::button size="sm">Right</x-strata::button>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Bottom placement" placement="bottom">
                            <x-strata::button size="sm">Bottom</x-strata::button>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Left placement" placement="left">
                            <x-strata::button size="sm">Left</x-strata::button>
                        </x-strata::tooltip>
                    </div>
                </div>

                {{-- Rich Content Tooltip --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Rich Content</h3>
                    <x-strata::tooltip placement="right">
                        <x-slot:content>
                            <div class="space-y-2">
                                <div class="font-semibold text-sm">Keyboard Shortcut</div>
                                <div class="flex gap-1 items-center">
                                    <x-strata::kbd size="sm">Ctrl</x-strata::kbd>
                                    <span class="text-xs">+</span>
                                    <x-strata::kbd size="sm">S</x-strata::kbd>
                                </div>
                                <p class="text-xs text-muted-foreground">
                                    Save your changes
                                </p>
                            </div>
                        </x-slot:content>

                        <x-strata::button icon="save">
                            Save
                        </x-strata::button>
                    </x-strata::tooltip>
                </div>

                {{-- Interactive Tooltip --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Interactive Content</h3>
                    <x-strata::tooltip placement="bottom">
                        <x-slot:content>
                            <div class="space-y-2">
                                <div class="font-semibold">Learn More</div>
                                <p class="text-xs text-muted-foreground">
                                    This feature allows you to...
                                </p>
                                <a href="#" class="text-xs text-primary hover:underline">
                                    View documentation →
                                </a>
                            </div>
                        </x-slot:content>

                        <x-strata::button.icon icon="info" variant="secondary" />
                    </x-strata::tooltip>
                </div>

                {{-- Tooltip on Various Elements --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">On Various Elements</h3>
                    <div class="flex flex-wrap gap-3 items-center">
                        <x-strata::tooltip text="User avatar">
                            <x-strata::avatar fallback="JD" />
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Active status">
                            <x-strata::badge variant="success">Active</x-strata::badge>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Important notification">
                            <x-strata::badge variant="destructive">3</x-strata::badge>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Escape key shortcut">
                            <x-strata::kbd>Esc</x-strata::kbd>
                        </x-strata::tooltip>
                    </div>
                </div>

                {{-- Custom Delays --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Custom Delays</h3>
                    <div class="flex flex-wrap gap-3">
                        <x-strata::tooltip text="Instant tooltip (no delay)" :delay="0">
                            <x-strata::button size="sm">Instant</x-strata::button>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Fast tooltip (100ms)" :delay="100">
                            <x-strata::button size="sm">Fast</x-strata::button>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Default tooltip (200ms)">
                            <x-strata::button size="sm">Default</x-strata::button>
                        </x-strata::tooltip>

                        <x-strata::tooltip text="Slow tooltip (500ms)" :delay="500">
                            <x-strata::button size="sm">Slow</x-strata::button>
                        </x-strata::tooltip>
                    </div>
                </div>
            </div>
        </section>

        {{-- Modals Section --}}
        <section>
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-2">Modals & Flyouts</h2>
                <p class="text-muted-foreground">Centered dialogs and slide-in panels using native <code class="text-sm">&lt;dialog&gt;</code> element.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Basic Modal --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Basic Modal</h3>
                    <x-strata::modal.trigger name="basic-modal">
                        <x-strata::button>Open Modal</x-strata::button>
                    </x-strata::modal.trigger>
                </div>

                {{-- Small Modal --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Small Modal</h3>
                    <x-strata::modal.trigger name="small-modal">
                        <x-strata::button variant="secondary">Small Modal</x-strata::button>
                    </x-strata::modal.trigger>
                </div>

                {{-- Large Modal --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Large Modal</h3>
                    <x-strata::modal.trigger name="large-modal">
                        <x-strata::button variant="secondary">Large Modal</x-strata::button>
                    </x-strata::modal.trigger>
                </div>

                {{-- Confirmation Modal --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Confirmation Dialog</h3>
                    <x-strata::modal.trigger name="confirm-modal">
                        <x-strata::button variant="destructive">Delete Item</x-strata::button>
                    </x-strata::modal.trigger>
                </div>

                {{-- Right Flyout --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Right Flyout</h3>
                    <x-strata::modal.trigger name="right-flyout">
                        <x-strata::button icon="panel-right">Settings</x-strata::button>
                    </x-strata::modal.trigger>
                </div>

                {{-- Left Flyout --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Left Flyout</h3>
                    <x-strata::modal.trigger name="left-flyout">
                        <x-strata::button icon="panel-left">Navigation</x-strata::button>
                    </x-strata::modal.trigger>
                </div>
            </div>
        </section>

        {{-- Date Pickers Section --}}
        <section>
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-2">Date Pickers</h2>
                <p class="text-muted-foreground">Flexible date selection with multiple modes, presets, and constraints.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Single Date Picker --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Single Date</h3>
                    <x-strata::date-picker
                        mode="single"
                        placeholder="Select a date..."
                    />
                </div>

                {{-- Date Range Picker --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Date Range</h3>
                    <x-strata::date-picker
                        mode="range"
                        placeholder="Select date range..."
                        :months-to-show="2"
                    />
                </div>

                {{-- Range with Presets --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Range with Presets</h3>
                    <x-strata::date-picker
                        mode="range"
                        placeholder="Quick select..."
                        show-presets
                        :months-to-show="2"
                    />
                </div>

                {{-- Multiple Dates --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Multiple Dates</h3>
                    <x-strata::date-picker
                        mode="multiple"
                        placeholder="Select multiple dates..."
                        show-presets
                    />
                </div>

                {{-- With Constraints --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">With Min/Max Dates</h3>
                    <x-strata::date-picker
                        mode="single"
                        placeholder="Future dates only..."
                        :min-date="now()->format('Y-m-d')"
                        :max-date="now()->addMonths(3)->format('Y-m-d')"
                    />
                </div>

                {{-- Different Sizes --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Different Sizes</h3>
                    <div class="space-y-3">
                        <x-strata::date-picker
                            mode="single"
                            size="sm"
                            placeholder="Small"
                        />

                        <x-strata::date-picker
                            mode="single"
                            size="md"
                            placeholder="Medium (Default)"
                        />

                        <x-strata::date-picker
                            mode="single"
                            size="lg"
                            placeholder="Large"
                        />
                    </div>
                </div>
            </div>
        </section>

        {{-- Inline Calendar Section --}}
        <section>
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-2">Inline Calendars</h2>
                <p class="text-muted-foreground">Inline calendar displays with different variants and features.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Default Calendar --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Default Variant</h3>
                    <x-strata::calendar
                        mode="single"
                        variant="default"
                    />
                </div>

                {{-- Bordered Calendar --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Bordered Variant</h3>
                    <x-strata::calendar
                        mode="single"
                        variant="bordered"
                    />
                </div>

                {{-- Card Calendar --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Card Variant</h3>
                    <x-strata::calendar
                        mode="single"
                        variant="card"
                    />
                </div>

                {{-- Range with Multiple Months --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Range Selection (2 Months)</h3>
                    <x-strata::calendar
                        mode="range"
                        variant="bordered"
                        :months-to-show="2"
                    />
                </div>
            </div>
        </section>

        {{-- Bottom Navigation Section --}}
        <section>
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-2">Bottom Navigation</h2>
                <p class="text-muted-foreground">Mobile-first bottom navigation bar with pill-style container.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Default Bottom Navigation --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Default with Labels</h3>
                    <div class="relative h-64 bg-muted/20 rounded-lg border border-border overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center text-muted-foreground">
                            Content Area
                        </div>
                        <x-strata::bottom-nav>
                            <x-strata::bottom-nav.item icon="home" active>
                                Home
                            </x-strata::bottom-nav.item>
                            <x-strata::bottom-nav.item icon="user">
                                Profile
                            </x-strata::bottom-nav.item>
                            <x-strata::bottom-nav.item icon="newspaper">
                                News
                            </x-strata::bottom-nav.item>
                        </x-strata::bottom-nav>
                    </div>
                </div>

                {{-- Static Position --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Static Position (Inline)</h3>
                    <div class="bg-muted/20 rounded-lg border border-border p-4">
                        <x-strata::bottom-nav position="static">
                            <x-strata::bottom-nav.item icon="home" active>
                                Home
                            </x-strata::bottom-nav.item>
                            <x-strata::bottom-nav.item icon="user">
                                Profile
                            </x-strata::bottom-nav.item>
                            <x-strata::bottom-nav.item icon="newspaper">
                                News
                            </x-strata::bottom-nav.item>
                        </x-strata::bottom-nav>
                    </div>
                </div>

                {{-- Different Sizes --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Different Sizes</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-muted-foreground mb-2">Small</p>
                            <div class="relative h-48 bg-muted/20 rounded-lg border border-border overflow-hidden">
                                <x-strata::bottom-nav size="sm" position="static">
                                    <x-strata::bottom-nav.item icon="home" size="sm" active>Home</x-strata::bottom-nav.item>
                                    <x-strata::bottom-nav.item icon="user" size="sm">Profile</x-strata::bottom-nav.item>
                                    <x-strata::bottom-nav.item icon="newspaper" size="sm">News</x-strata::bottom-nav.item>
                                </x-strata::bottom-nav>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-muted-foreground mb-2">Large</p>
                            <div class="relative h-56 bg-muted/20 rounded-lg border border-border overflow-hidden">
                                <x-strata::bottom-nav size="lg" position="static">
                                    <x-strata::bottom-nav.item icon="home" size="lg" active>Home</x-strata::bottom-nav.item>
                                    <x-strata::bottom-nav.item icon="user" size="lg">Profile</x-strata::bottom-nav.item>
                                    <x-strata::bottom-nav.item icon="newspaper" size="lg">News</x-strata::bottom-nav.item>
                                </x-strata::bottom-nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Definitions --}}
    <x-strata::modal name="basic-modal">
        <x-strata::modal.header>
            Basic Modal Example
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <p class="text-muted-foreground">
                This is a basic modal dialog using the native &lt;dialog&gt; element with Alpine.js for state management.
            </p>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::modal.close as-child>
                <x-strata::button variant="secondary">Cancel</x-strata::button>
            </x-strata::modal.close>
            <x-strata::button>Confirm</x-strata::button>
        </x-strata::modal.footer>
    </x-strata::modal>

    <x-strata::modal name="small-modal" size="sm">
        <x-strata::modal.header>
            Small Modal
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <p class="text-sm text-muted-foreground">
                This is a small modal with size="sm" prop.
            </p>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::modal.close as-child>
                <x-strata::button>Close</x-strata::button>
            </x-strata::modal.close>
        </x-strata::modal.footer>
    </x-strata::modal>

    <x-strata::modal name="large-modal" size="lg">
        <x-strata::modal.header>
            Large Modal
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <div class="space-y-4">
                <p class="text-muted-foreground">
                    This is a large modal with size="lg" prop, perfect for forms and detailed content.
                </p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-muted rounded">
                        <h4 class="font-semibold mb-2">Feature 1</h4>
                        <p class="text-sm text-muted-foreground">More space for content.</p>
                    </div>
                    <div class="p-4 bg-muted rounded">
                        <h4 class="font-semibold mb-2">Feature 2</h4>
                        <p class="text-sm text-muted-foreground">Better for complex layouts.</p>
                    </div>
                </div>
            </div>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::modal.close as-child>
                <x-strata::button variant="secondary">Cancel</x-strata::button>
            </x-strata::modal.close>
            <x-strata::button>Save Changes</x-strata::button>
        </x-strata::modal.footer>
    </x-strata::modal>

    <x-strata::modal name="confirm-modal" size="sm">
        <x-strata::modal.header>
            Confirm Deletion
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <p class="text-muted-foreground">
                This action cannot be undone. Are you sure you want to delete this item?
            </p>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::modal.close as-child>
                <x-strata::button variant="secondary">Cancel</x-strata::button>
            </x-strata::modal.close>
            <x-strata::button variant="destructive">Delete</x-strata::button>
        </x-strata::modal.footer>
    </x-strata::modal>

    <x-strata::modal name="right-flyout" variant="flyout" position="right">
        <x-strata::modal.header>
            Settings
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <div class="space-y-6">
                <div>
                    <h4 class="font-semibold mb-2">Notifications</h4>
                    <p class="text-sm text-muted-foreground mb-3">Manage your notification preferences.</p>
                    <div class="space-y-2">
                        <x-strata::checkbox label="Email notifications" />
                        <x-strata::checkbox label="Push notifications" />
                        <x-strata::checkbox label="SMS alerts" />
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold mb-2">Appearance</h4>
                    <p class="text-sm text-muted-foreground mb-3">Customize your interface.</p>
                    <div class="space-y-2">
                        <x-strata::toggle label="Dark mode" />
                        <x-strata::toggle label="Compact view" />
                    </div>
                </div>
            </div>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::modal.close as-child>
                <x-strata::button>Done</x-strata::button>
            </x-strata::modal.close>
        </x-strata::modal.footer>
    </x-strata::modal>

    <x-strata::modal name="left-flyout" variant="flyout" position="left">
        <x-strata::modal.header>
            Navigation Menu
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body padding="none">
            <nav class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-muted transition-colors">
                    <x-strata::icon.home class="w-5 h-5" />
                    <span>Home</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-muted transition-colors">
                    <x-strata::icon.users class="w-5 h-5" />
                    <span>Team</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-muted transition-colors">
                    <x-strata::icon.folder class="w-5 h-5" />
                    <span>Projects</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-muted transition-colors">
                    <x-strata::icon.settings class="w-5 h-5" />
                    <span>Settings</span>
                </a>
            </nav>
        </x-strata::modal.body>
    </x-strata::modal>

    @strataScripts
    @livewireScripts
</body>
</html>
