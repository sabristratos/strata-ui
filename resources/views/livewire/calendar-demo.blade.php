<div class="space-y-12">
    <div>
        <h3 class="text-lg font-semibold mb-4">Single Date Selection</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <x-strata::calendar
                    mode="single"
                    wire:model.live="singleDate"
                    variant="bordered"
                />
            </div>
            <div>
                <div class="p-4 bg-muted rounded-lg space-y-2">
                    <p class="text-sm font-medium">Selected Date:</p>
                    <p class="text-sm text-muted-foreground font-mono">{{ $singleDate ?? 'None' }}</p>

                    <div class="pt-4 mt-4 border-t border-border">
                        <p class="text-xs text-muted-foreground">
                            Click any date to select it. Use arrow keys to navigate, Enter to select.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Multiple Dates Selection</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <x-strata::calendar
                    mode="multiple"
                    wire:model.live="multipleDates"
                    variant="bordered"
                />
            </div>
            <div>
                <div class="p-4 bg-muted rounded-lg space-y-2">
                    <p class="text-sm font-medium">Selected Dates ({{ count($multipleDates) }}):</p>
                    <div class="space-y-1">
                        @forelse($multipleDates as $date)
                            <p class="text-sm text-muted-foreground font-mono">{{ $date }}</p>
                        @empty
                            <p class="text-sm text-muted-foreground">None selected</p>
                        @endforelse
                    </div>

                    <div class="pt-4 mt-4 border-t border-border">
                        <p class="text-xs text-muted-foreground">
                            Click dates to toggle selection. You can select as many dates as you want.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Date Range Selection</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <x-strata::calendar
                    mode="range"
                    wire:model.live="dateRange"
                    variant="bordered"
                    show-presets
                />
            </div>
            <div>
                <div class="p-4 bg-muted rounded-lg space-y-2">
                    <p class="text-sm font-medium">Selected Range:</p>
                    @if(count($dateRange) === 2)
                        <p class="text-sm text-muted-foreground">
                            <span class="font-mono">{{ $dateRange[0] }}</span>
                            <span class="mx-2">to</span>
                            <span class="font-mono">{{ $dateRange[1] }}</span>
                        </p>
                        <p class="text-xs text-muted-foreground mt-2">
                            Duration: {{ \Carbon\Carbon::parse($dateRange[0])->diffInDays(\Carbon\Carbon::parse($dateRange[1])) + 1 }} days
                        </p>
                    @else
                        <p class="text-sm text-muted-foreground">
                            {{ count($dateRange) === 1 ? 'Start: ' . $dateRange[0] . ' (select end date)' : 'None selected' }}
                        </p>
                    @endif

                    <div class="pt-4 mt-4 border-t border-border">
                        <p class="text-xs text-muted-foreground">
                            Click start date, then click end date. Use preset buttons for quick selection.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Week Selection</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <x-strata::calendar
                    mode="week"
                    wire:model.live="weekSelection"
                    variant="bordered"
                    :week-starts-on="1"
                />
            </div>
            <div>
                <div class="p-4 bg-muted rounded-lg space-y-2">
                    <p class="text-sm font-medium">Selected Week ({{ count($weekSelection) }} days):</p>
                    <div class="space-y-1">
                        @forelse($weekSelection as $date)
                            <p class="text-sm text-muted-foreground font-mono">{{ $date }}</p>
                        @empty
                            <p class="text-sm text-muted-foreground">None selected</p>
                        @endforelse
                    </div>

                    <div class="pt-4 mt-4 border-t border-border">
                        <p class="text-xs text-muted-foreground">
                            Click any day to select the entire week. Week starts on Monday.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Multiple Month View</h3>
        <div class="space-y-4">
            <x-strata::calendar
                mode="range"
                wire:model.live="dateRange"
                variant="bordered"
                :months-to-show="2"
            />
            <div class="p-4 bg-muted rounded-lg">
                <p class="text-xs text-muted-foreground">
                    Viewing 2 months side by side makes it easier to select date ranges that span multiple months.
                </p>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Date Input with Popup Calendar</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-4">
                <div>
                    <x-strata::form.label for="input-date">Single Date Input</x-strata::form.label>
                    <x-strata::calendar.input
                        id="input-date"
                        mode="single"
                        wire:model.live="inputDate"
                        placeholder="Select a date..."
                    />
                </div>

                <div>
                    <x-strata::form.label for="input-range">Date Range Input</x-strata::form.label>
                    <x-strata::calendar.input
                        id="input-range"
                        mode="range"
                        wire:model.live="inputRange"
                        placeholder="Select date range..."
                        show-presets
                        :months-to-show="2"
                    />
                </div>
            </div>
            <div>
                <div class="p-4 bg-muted rounded-lg space-y-4">
                    <div>
                        <p class="text-sm font-medium">Single Date:</p>
                        <p class="text-sm text-muted-foreground font-mono">{{ $inputDate ?? 'None' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium">Date Range:</p>
                        @if(count($inputRange) === 2)
                            <p class="text-sm text-muted-foreground font-mono">
                                {{ $inputRange[0] }} to {{ $inputRange[1] }}
                            </p>
                        @else
                            <p class="text-sm text-muted-foreground">None selected</p>
                        @endif
                    </div>

                    <div class="pt-4 mt-4 border-t border-border">
                        <p class="text-xs text-muted-foreground">
                            Click the input or calendar icon to open the popup calendar. Calendar closes automatically after selection.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Date Constraints</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <x-strata::calendar
                    mode="single"
                    wire:model.live="constrainedDate"
                    variant="bordered"
                    :min-date="now()->subDays(7)->format('Y-m-d')"
                    :max-date="now()->addDays(14)->format('Y-m-d')"
                    :disabled-dates="[
                        now()->addDays(3)->format('Y-m-d'),
                        now()->addDays(7)->format('Y-m-d'),
                    ]"
                />
            </div>
            <div>
                <div class="p-4 bg-muted rounded-lg space-y-2">
                    <p class="text-sm font-medium">Constraints:</p>
                    <ul class="text-sm text-muted-foreground space-y-1 list-disc list-inside">
                        <li>Min Date: {{ now()->subDays(7)->format('Y-m-d') }}</li>
                        <li>Max Date: {{ now()->addDays(14)->format('Y-m-d') }}</li>
                        <li>Disabled: {{ now()->addDays(3)->format('Y-m-d') }}</li>
                        <li>Disabled: {{ now()->addDays(7)->format('Y-m-d') }}</li>
                    </ul>

                    <div class="pt-4 mt-4 border-t border-border">
                        <p class="text-sm font-medium">Selected:</p>
                        <p class="text-sm text-muted-foreground font-mono">{{ $constrainedDate ?? 'None' }}</p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-border">
                        <p class="text-xs text-muted-foreground">
                            Dates outside the min/max range and specific disabled dates cannot be selected.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
