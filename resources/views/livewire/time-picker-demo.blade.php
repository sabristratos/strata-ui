<div class="min-h-screen bg-background py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-12">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-foreground mb-4">Time Picker Component Showcase</h1>
            <p class="text-lg text-muted-foreground max-w-3xl mx-auto">
                A comprehensive demonstration of the Strata UI Time Picker component featuring 12/24-hour formats, presets, step intervals, and validation states using Popover API + CSS Anchor Positioning.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold text-card-foreground">Basic Time Picker</h3>
                <x-strata::time-picker
                    wire:model.live="basicTime"
                    placeholder="Select a time"
                />
                <p class="text-sm text-muted-foreground">Selected: <span class="font-mono">{{ $basicTime ?? 'null' }}</span></p>
            </div>

            <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold text-card-foreground">12-Hour Format</h3>
                <x-strata::time-picker
                    wire:model.live="time12Hour"
                    format="12"
                    placeholder="Select time (12hr)"
                />
                <p class="text-sm text-muted-foreground">Selected: <span class="font-mono">{{ $time12Hour ?? 'null' }}</span></p>
            </div>

            <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold text-card-foreground">24-Hour Format</h3>
                <x-strata::time-picker
                    wire:model.live="time24Hour"
                    format="24"
                    placeholder="Select time (24hr)"
                />
                <p class="text-sm text-muted-foreground">Selected: <span class="font-mono">{{ $time24Hour ?? 'null' }}</span></p>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Size Variants</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Small</label>
                    <x-strata::time-picker
                        wire:model="timeSmall"
                        size="sm"
                        placeholder="Small size"
                    />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Medium (Default)</label>
                    <x-strata::time-picker
                        wire:model="timeMedium"
                        size="md"
                        placeholder="Medium size"
                    />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Large</label>
                    <x-strata::time-picker
                        wire:model="timeLarge"
                        size="lg"
                        placeholder="Large size"
                    />
                </div>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Validation States</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Default</label>
                    <x-strata::time-picker
                        wire:model="timeDefault"
                        state="default"
                        placeholder="Default state"
                    />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Success</label>
                    <x-strata::time-picker
                        wire:model="timeSuccess"
                        state="success"
                        placeholder="Success state"
                    />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Error</label>
                    <x-strata::time-picker
                        wire:model="timeError"
                        state="error"
                        placeholder="Error state"
                    />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Warning</label>
                    <x-strata::time-picker
                        wire:model="timeWarning"
                        state="warning"
                        placeholder="Warning state"
                    />
                </div>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Advanced Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">With Presets</label>
                    <x-strata::time-picker
                        wire:model.live="timeWithPresets"
                        :show-presets="true"
                        placeholder="Quick time selection"
                    />
                    <p class="text-xs text-muted-foreground">Selected: {{ $timeWithPresets ?? 'null' }}</p>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">30-Minute Steps</label>
                    <x-strata::time-picker
                        wire:model.live="timeStep30"
                        :step-minutes="30"
                        placeholder="Every 30 minutes"
                    />
                    <p class="text-xs text-muted-foreground">Selected: {{ $timeStep30 ?? 'null' }}</p>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">60-Minute Steps</label>
                    <x-strata::time-picker
                        wire:model.live="timeStep60"
                        :step-minutes="60"
                        placeholder="Every hour"
                    />
                    <p class="text-xs text-muted-foreground">Selected: {{ $timeStep60 ?? 'null' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Time Constraints</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Business Hours (9 AM - 5 PM)</label>
                    <x-strata::time-picker
                        wire:model.live="timeWithMin"
                        min-time="09:00"
                        max-time="17:00"
                        placeholder="Select business hours"
                    />
                    <p class="text-xs text-muted-foreground">Min: 09:00, Max: 17:00 | Selected: {{ $timeWithMin ?? 'null' }}</p>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Evening Only (After 6 PM)</label>
                    <x-strata::time-picker
                        wire:model.live="timeWithMax"
                        min-time="18:00"
                        max-time="23:59"
                        placeholder="Select evening time"
                    />
                    <p class="text-xs text-muted-foreground">Min: 18:00, Max: 23:59 | Selected: {{ $timeWithMax ?? 'null' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Additional States</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Clearable</label>
                    <x-strata::time-picker
                        wire:model.live="timeClearable"
                        :clearable="true"
                        placeholder="Can be cleared"
                    />
                    <p class="text-xs text-muted-foreground">Selected: {{ $timeClearable ?? 'null' }}</p>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Disabled</label>
                    <x-strata::time-picker
                        wire:model="timeDisabled"
                        :disabled="true"
                        placeholder="Cannot be changed"
                    />
                    <p class="text-xs text-muted-foreground">Value: {{ $timeDisabled }}</p>
                </div>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Real-World Example: Schedule Form</h2>
            <div class="max-w-2xl">
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Meeting Time</label>
                        <x-strata::time-picker
                            wire:model.live="meetingTime"
                            :step-minutes="15"
                            min-time="08:00"
                            max-time="18:00"
                            placeholder="Select meeting time"
                        />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Appointment Time</label>
                        <x-strata::time-picker
                            wire:model.live="appointmentTime"
                            :step-minutes="30"
                            :show-presets="true"
                            placeholder="Select appointment time"
                        />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Reminder Time</label>
                        <x-strata::time-picker
                            wire:model.live="reminderTime"
                            :clearable="true"
                            placeholder="Optional reminder time"
                        />
                    </div>
                    <div class="p-4 bg-muted rounded-lg">
                        <p class="text-sm font-medium text-foreground mb-2">Form Data:</p>
                        <ul class="space-y-1 text-xs font-mono text-muted-foreground">
                            <li>Meeting: {{ $meetingTime ?? 'not set' }}</li>
                            <li>Appointment: {{ $appointmentTime ?? 'not set' }}</li>
                            <li>Reminder: {{ $reminderTime ?? 'not set' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
