<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('showcase.title') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 min-h-full">
    <div class="min-h-screen">
        <header class="sticky top-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ __('showcase.title') }}
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('showcase.subtitle') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('showcase.current_locale') }}:</span>
                            <span class="font-semibold">{{ strtoupper(app()->getLocale()) }}</span>
                            <span class="text-gray-400">|</span>
                            <span class="text-gray-600 dark:text-gray-400">{{ __('showcase.direction') }}:</span>
                            <span class="font-semibold">{{ app()->getLocale() === 'ar' ? 'RTL' : 'LTR' }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                wire:click="switchLocale('en')"
                                class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ app()->getLocale() === 'en' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}"
                            >
                                English
                            </button>
                            <button
                                wire:click="switchLocale('ar')"
                                class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ app()->getLocale() === 'ar' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}"
                            >
                                العربية
                            </button>
                        </div>

                        <div
                            x-data="{ dark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
                            x-init="$watch('dark', val => { localStorage.theme = val ? 'dark' : 'light'; document.documentElement.classList.toggle('dark', val) })"
                        >
                            <button
                                @click="dark = !dark"
                                class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                                :aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'"
                            >
                                <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                <svg x-show="dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
