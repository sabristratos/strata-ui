<div class="container mx-auto p-8 space-y-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-foreground mb-2">Calendar Component Demo</h1>
        <p class="text-muted-foreground">Comprehensive showcase of calendar component features and improvements</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-6">
            <div class="bg-card border border-border rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-foreground mb-4">Single Date Selection</h2>
                <p class="text-sm text-muted-foreground mb-4">Click to select a single date</p>

                <x-strata::calendar
                    mode="single"
                    wire:model.live="singleDate"
                    variant="bordered"
                />

                @if($singleDate)
                    <div class="mt-4 p-3 bg-primary/10 rounded-md">
                        <p class="text-sm font-medium text-foreground">Selected: {{ $singleDate }}</p>
                    </div>
                @endif

                <div class="mt-4 text-xs text-muted-foreground space-y-1">
                    <p><strong>Keyboard shortcuts:</strong></p>
                    <ul class="list-disc list-inside ml-2">
                        <li>Arrow keys: Navigate days</li>
                        <li>Home/End: First/Last day of month</li>
                        <li>PageUp/PageDown: Previous/Next month</li>
                        <li>Shift+PageUp/PageDown: Previous/Next year</li>
                        <li>Enter/Space: Select date</li>
                    </ul>
                </div>
            </div>

            <div class="bg-card border border-border rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-foreground mb-4">Range Selection</h2>
                <p class="text-sm text-muted-foreground mb-4">Select start and end dates with hover preview</p>

                <x-strata::calendar
                    mode="range"
                    wire:model.live="rangeDate"
                    variant="bordered"
                />

                @if($rangeDate && is_array($rangeDate) && count($rangeDate) === 2)
                    <div class="mt-4 p-3 bg-primary/10 rounded-md">
                        <p class="text-sm font-medium text-foreground">Range: {{ $rangeDate[0] }} to {{ $rangeDate[1] }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-card border border-border rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-foreground mb-4">Multiple Date Selection</h2>
                <p class="text-sm text-muted-foreground mb-4">Select multiple individual dates</p>

                <x-strata::calendar
                    mode="multiple"
                    wire:model.live="multipleDate"
                    variant="bordered"
                />

                @if($multipleDate && count($multipleDate) > 0)
                    <div class="mt-4 p-3 bg-primary/10 rounded-md">
                        <p class="text-sm font-medium text-foreground mb-2">Selected ({{ count($multipleDate) }} dates):</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach($multipleDate as $date)
                                <span class="inline-flex items-center px-2 py-1 rounded-md bg-primary text-primary-foreground text-xs">
                                    {{ $date }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-card border border-border rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-foreground mb-4">Week Selection</h2>
                <p class="text-sm text-muted-foreground mb-4">Select entire week at once</p>

                <x-strata::calendar
                    mode="week"
                    wire:model.live="weekDate"
                    variant="bordered"
                    :week-starts-on="1"
                />

                @if($weekDate && count($weekDate) > 0)
                    <div class="mt-4 p-3 bg-primary/10 rounded-md">
                        <p class="text-sm font-medium text-foreground mb-2">Week Selected ({{ count($weekDate) }} days):</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach($weekDate as $date)
                                <span class="inline-flex items-center px-2 py-1 rounded-md bg-primary text-primary-foreground text-xs">
                                    {{ \Carbon\Carbon::parse($date)->format('D m/d') }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-card border border-border rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-foreground mb-4">Date Constraints</h2>
                <p class="text-sm text-muted-foreground mb-4">Min/max dates and disabled dates</p>

                <x-strata::calendar
                    mode="single"
                    wire:model.live="constrainedDate"
                    variant="bordered"
                    min-date="{{ now()->toDateString() }}"
                    max-date="{{ now()->addDays(30)->toDateString() }}"
                    :disabled-dates="[
                        now()->addDays(5)->toDateString(),
                        now()->addDays(10)->toDateString(),
                        now()->addDays(15)->toDateString(),
                    ]"
                />

                <div class="mt-4 space-y-2">
                    @if($constrainedDate)
                        <div class="p-3 bg-primary/10 rounded-md">
                            <p class="text-sm font-medium text-foreground">Selected: {{ $constrainedDate }}</p>
                        </div>
                    @endif
                    <div class="p-3 bg-muted/50 rounded-md">
                        <p class="text-xs text-muted-foreground">
                            <strong>Min:</strong> Today<br>
                            <strong>Max:</strong> +30 days<br>
                            <strong>Disabled:</strong> Days 5, 10, 15
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-card border border-border rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-foreground mb-4">With Quick Presets</h2>
                <p class="text-sm text-muted-foreground mb-4">Built-in preset buttons for common selections</p>

                <x-strata::calendar
                    mode="range"
                    wire:model.live="presetsDate"
                    variant="bordered"
                    :show-presets="true"
                />

                @if($presetsDate && is_array($presetsDate) && count($presetsDate) === 2)
                    <div class="mt-4 p-3 bg-primary/10 rounded-md">
                        <p class="text-sm font-medium text-foreground">Range: {{ $presetsDate[0] }} to {{ $presetsDate[1] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="border-t border-border pt-8">
        <h2 class="text-3xl font-bold text-foreground mb-6">Date Picker Integration</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-card border border-border rounded-lg p-6">
                <h3 class="text-xl font-semibold text-foreground mb-4">Single Date Picker</h3>
                <p class="text-sm text-muted-foreground mb-4">Calendar in a dropdown with input trigger</p>

                <x-strata::date-picker
                    wire:model.live="datePickerSingle"
                    mode="single"
                    placeholder="Select a date"
                    size="md"
                    clearable
                />

                @if($datePickerSingle)
                    <div class="mt-4 p-3 bg-primary/10 rounded-md">
                        <p class="text-sm font-medium text-foreground">Selected: {{ $datePickerSingle }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-card border border-border rounded-lg p-6">
                <h3 class="text-xl font-semibold text-foreground mb-4">Range Date Picker with Presets</h3>
                <p class="text-sm text-muted-foreground mb-4">Range selection with quick presets</p>

                <x-strata::date-picker
                    wire:model.live="datePickerRange"
                    mode="range"
                    placeholder="Select date range"
                    size="md"
                    clearable
                    :show-presets="true"
                />

                @if($datePickerRange && isset($datePickerRange['start']) && isset($datePickerRange['end']))
                    <div class="mt-4 p-3 bg-primary/10 rounded-md">
                        <p class="text-sm font-medium text-foreground">
                            Range: {{ $datePickerRange['start'] }} to {{ $datePickerRange['end'] }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="border-t border-border pt-8">
        <h2 class="text-3xl font-bold text-foreground mb-6">Internationalization</h2>
        <p class="text-muted-foreground mb-6">Calendars automatically adapt to different locales using JavaScript Intl API and Laravel translations</p>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-card border border-border rounded-lg p-6">
                <h3 class="text-xl font-semibold text-foreground mb-4">French Locale (fr)</h3>
                <p class="text-sm text-muted-foreground mb-4">Week starts Monday, month/day names in French</p>

                <x-strata::calendar
                    mode="single"
                    locale="fr"
                    variant="bordered"
                />
            </div>

            <div class="bg-card border border-border rounded-lg p-6">
                <h3 class="text-xl font-semibold text-foreground mb-4">French Range with Presets</h3>
                <p class="text-sm text-muted-foreground mb-4">UI labels and date formatting in French</p>

                <x-strata::calendar
                    mode="range"
                    locale="fr"
                    variant="bordered"
                    :show-presets="true"
                />
            </div>
        </div>
    </div>

    <div class="bg-info/10 border border-info rounded-lg p-6">
        <h3 class="text-lg font-semibold text-foreground mb-3">Phase 1 Improvements Implemented ✓</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-foreground">
            <div>
                <h4 class="font-semibold mb-2">Accessibility</h4>
                <ul class="list-disc list-inside space-y-1 text-muted-foreground">
                    <li>Comprehensive ARIA labels with full dates</li>
                    <li>aria-disabled attributes</li>
                    <li>aria-live region for announcements</li>
                    <li>Tab trapping in month picker</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Keyboard Navigation</h4>
                <ul class="list-disc list-inside space-y-1 text-muted-foreground">
                    <li>Home/End: First/Last day of month</li>
                    <li>PageUp/PageDown: Navigate months</li>
                    <li>Shift+PageUp/PageDown: Navigate years</li>
                    <li>Escape: Close dropdowns</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-2">UX Enhancements</h4>
                <ul class="list-disc list-inside space-y-1 text-muted-foreground">
                    <li>Range hover preview</li>
                    <li>"Today" button in header</li>
                    <li>Stronger range background (primary/20)</li>
                    <li>Screen reader announcements</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Code Quality</h4>
                <ul class="list-disc list-inside space-y-1 text-muted-foreground">
                    <li>All console.log statements removed</li>
                    <li>Cleaner, more maintainable code</li>
                    <li>Better error handling</li>
                </ul>
            </div>
        </div>
    </div>
</div>
