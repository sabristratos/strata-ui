<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <div class="text-center space-y-4">
        <h1 class="text-4xl font-bold">Date & Time Picker Components</h1>
        <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
            Comprehensive demonstration of Strata UI Date Picker and Time Picker components featuring single/range/multiple date selection, 12h/24h time formats, validation states, and real-world use cases with Livewire integration.
        </p>
    </div>

    <x-strata::button variant="secondary" appearance="outlined" wire:click="resetAll">
        Reset All Demos
    </x-strata::button>

    {{-- Date Picker Examples --}}
    <section class="space-y-6">
        <div class="space-y-2">
            <h2 class="text-3xl font-semibold">Date Picker Examples</h2>
            <p class="text-muted-foreground">Different date selection modes and patterns</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="space-y-3">
                <div class="space-y-1">
                    <h3 class="font-medium">Single Date</h3>
                    <p class="text-sm text-muted-foreground">Select one date</p>
                </div>
                <x-strata::date-picker
                    wire:model="singleDate"
                    placeholder="Select date"
                />
                <p class="text-sm text-muted-foreground">Value: {{ $singleDate ?? '(empty)' }}</p>
            </div>

            <div class="space-y-3">
                <div class="space-y-1">
                    <h3 class="font-medium">Date Range</h3>
                    <p class="text-sm text-muted-foreground">mode="range"</p>
                </div>
                <x-strata::date-picker
                    wire:model="dateRange"
                    mode="range"
                    placeholder="Select date range"
                />
                <p class="text-sm text-muted-foreground">
                    Value: {{ is_array($dateRange) ? implode(' to ', $dateRange) : '(empty)' }}
                </p>
            </div>

            <div class="space-y-3">
                <div class="space-y-1">
                    <h3 class="font-medium">Multiple Dates (Summary)</h3>
                    <p class="text-sm text-muted-foreground">mode="multiple"</p>
                </div>
                <x-strata::date-picker
                    wire:model="multipleDates"
                    mode="multiple"
                    placeholder="Select multiple dates"
                />
                <p class="text-sm text-muted-foreground">
                    Shows: "{{ is_array($multipleDates) ? count($multipleDates) . ' dates' : '0 dates' }}"
                </p>
            </div>
        </div>

        <div class="space-y-3 mt-6">
            <div class="space-y-1">
                <h3 class="font-medium">Multiple Dates with Chips</h3>
                <p class="text-sm text-muted-foreground">mode="multiple" :chips="true"</p>
            </div>
            <x-strata::date-picker
                wire:model="multipleDates"
                mode="multiple"
                :chips="true"
                placeholder="Select multiple dates"
            />
            <p class="text-sm text-muted-foreground">
                Displays dates as individual chips (e.g., "Jun 15", "Jun 18", "Jun 22")
            </p>
        </div>
    </section>

    {{-- Chips Display Mode --}}
    <section class="space-y-6">
        <div class="space-y-2">
            <h2 class="text-3xl font-semibold">Chips Display Mode</h2>
            <p class="text-muted-foreground">Multiple date selection with inline chips</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <div class="space-y-1">
                    <h3 class="font-medium">Summary Mode (Default)</h3>
                    <p class="text-sm text-muted-foreground">Shows "3 dates selected"</p>
                </div>
                <x-strata::date-picker
                    wire:model="multipleDates"
                    mode="multiple"
                    placeholder="Select multiple dates"
                />
            </div>

            <div class="space-y-3">
                <div class="space-y-1">
                    <h3 class="font-medium">Chips Mode</h3>
                    <p class="text-sm text-muted-foreground">Shows individual date chips</p>
                </div>
                <x-strata::date-picker
                    wire:model="multipleDates"
                    mode="multiple"
                    :chips="true"
                    placeholder="Select multiple dates"
                />
            </div>
        </div>
    </section>

    {{-- Time Picker Examples --}}
    <section class="space-y-6">
        <div class="space-y-2">
            <h2 class="text-3xl font-semibold">Time Picker Examples</h2>
            <p class="text-muted-foreground">Different time formats and intervals</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="space-y-3">
                <div class="space-y-1">
                    <h3 class="font-medium">12-Hour Format</h3>
                    <p class="text-sm text-muted-foreground">format="12h" (default)</p>
                </div>
                <x-strata::time-picker
                    wire:model="time12h"
                    placeholder="Select time"
                />
                <p class="text-sm text-muted-foreground">Value: {{ $time12h ?? '(empty)' }}</p>
            </div>

            <div class="space-y-3">
                <div class="space-y-1">
                    <h3 class="font-medium">24-Hour Format</h3>
                    <p class="text-sm text-muted-foreground">format="24h"</p>
                </div>
                <x-strata::time-picker
                    wire:model="time24h"
                    format="24h"
                    placeholder="Select time"
                />
                <p class="text-sm text-muted-foreground">Value: {{ $time24h ?? '(empty)' }}</p>
            </div>

            <div class="space-y-3">
                <div class="space-y-1">
                    <h3 class="font-medium">With Seconds</h3>
                    <p class="text-sm text-muted-foreground">:show-seconds="true"</p>
                </div>
                <x-strata::time-picker
                    wire:model="timeWithSeconds"
                    :show-seconds="true"
                    placeholder="Select time"
                />
                <p class="text-sm text-muted-foreground">Value: {{ $timeWithSeconds ?? '(empty)' }}</p>
            </div>
        </div>
    </section>

    {{-- Size Variants --}}
    <section class="space-y-6">
        <h2 class="text-3xl font-semibold">Size Variants</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="space-y-3">
                <p class="text-sm text-muted-foreground">Small</p>
                <x-strata::date-picker size="sm" placeholder="Small date picker" />
                <x-strata::time-picker size="sm" placeholder="Small time picker" />
            </div>

            <div class="space-y-3">
                <p class="text-sm text-muted-foreground">Medium (Default)</p>
                <x-strata::date-picker size="md" placeholder="Medium date picker" />
                <x-strata::time-picker size="md" placeholder="Medium time picker" />
            </div>

            <div class="space-y-3">
                <p class="text-sm text-muted-foreground">Large</p>
                <x-strata::date-picker size="lg" placeholder="Large date picker" />
                <x-strata::time-picker size="lg" placeholder="Large time picker" />
            </div>
        </div>
    </section>

    {{-- Validation States --}}
    <section class="space-y-6">
        <h2 class="text-3xl font-semibold">Validation States</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <p class="text-sm text-muted-foreground">Success State</p>
                <x-strata::date-picker state="success" value="2025-06-15" />
                <x-strata::time-picker state="success" value="10:00" />
            </div>

            <div class="space-y-3">
                <p class="text-sm text-muted-foreground">Error State</p>
                <x-strata::date-picker state="error" placeholder="Required field" />
                <x-strata::time-picker state="error" placeholder="Required field" />
            </div>
        </div>
    </section>

    {{-- Real-World Example: Appointment Booking --}}
    <section class="space-y-6">
        <div class="space-y-2">
            <h2 class="text-3xl font-semibold">Real-World Example: Appointment Booking</h2>
            <p class="text-muted-foreground">Complete booking form with validation</p>
        </div>

        <form wire:submit="submitBooking" class="max-w-2xl space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
                <x-strata::form.field>
                    <x-strata::form.label for="appointmentDate" required>Appointment Date</x-strata::form.label>
                    <x-strata::date-picker
                        id="appointmentDate"
                        wire:model="appointmentDate"
                        placeholder="Select date"
                        :state="$errors->has('appointmentDate') ? 'error' : 'default'"
                    />
                    @error('appointmentDate')
                        <x-strata::form.error>{{ $message }}</x-strata::form.error>
                    @enderror
                </x-strata::form.field>

                <x-strata::form.field>
                    <x-strata::form.label for="appointmentTime" required>Appointment Time</x-strata::form.label>
                    <x-strata::time-picker
                        id="appointmentTime"
                        wire:model="appointmentTime"
                        placeholder="Select time"
                        :state="$errors->has('appointmentTime') ? 'error' : 'default'"
                    />
                    @error('appointmentTime')
                        <x-strata::form.error>{{ $message }}</x-strata::form.error>
                    @enderror
                </x-strata::form.field>
            </div>

            <div class="space-y-2">
                <h4 class="font-medium">Current Selection:</h4>
                <p class="text-sm text-muted-foreground">Date: {{ $appointmentDate ?? 'Not selected' }}</p>
                <p class="text-sm text-muted-foreground">Time: {{ $appointmentTime ?? 'Not selected' }}</p>
            </div>

            <x-strata::button type="submit" icon="calendar">
                Book Appointment
            </x-strata::button>
        </form>
    </section>

    {{-- Real-World Example: Event Scheduling --}}
    <section class="space-y-6">
        <div class="space-y-2">
            <h2 class="text-3xl font-semibold">Real-World Example: Event Scheduling</h2>
            <p class="text-muted-foreground">Schedule event with start and end date/time</p>
        </div>

        <form wire:submit="submitEvent" class="max-w-2xl space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
                <x-strata::form.field>
                    <x-strata::form.label for="eventStartDate" required>Start Date</x-strata::form.label>
                    <x-strata::date-picker
                        id="eventStartDate"
                        wire:model="eventStartDate"
                        placeholder="Event start date"
                        :state="$errors->has('eventStartDate') ? 'error' : 'default'"
                    />
                    @error('eventStartDate')
                        <x-strata::form.error>{{ $message }}</x-strata::form.error>
                    @enderror
                </x-strata::form.field>

                <x-strata::form.field>
                    <x-strata::form.label for="eventStartTime" required>Start Time</x-strata::form.label>
                    <x-strata::time-picker
                        id="eventStartTime"
                        wire:model="eventStartTime"
                        placeholder="Event start time"
                        :state="$errors->has('eventStartTime') ? 'error' : 'default'"
                    />
                    @error('eventStartTime')
                        <x-strata::form.error>{{ $message }}</x-strata::form.error>
                    @enderror
                </x-strata::form.field>

                <x-strata::form.field>
                    <x-strata::form.label for="eventEndDate" required>End Date</x-strata::form.label>
                    <x-strata::date-picker
                        id="eventEndDate"
                        wire:model="eventEndDate"
                        placeholder="Event end date"
                        :state="$errors->has('eventEndDate') ? 'error' : 'default'"
                    />
                    @error('eventEndDate')
                        <x-strata::form.error>{{ $message }}</x-strata::form.error>
                    @enderror
                </x-strata::form.field>

                <x-strata::form.field>
                    <x-strata::form.label for="eventEndTime" required>End Time</x-strata::form.label>
                    <x-strata::time-picker
                        id="eventEndTime"
                        wire:model="eventEndTime"
                        placeholder="Event end time"
                        :state="$errors->has('eventEndTime') ? 'error' : 'default'"
                    />
                    @error('eventEndTime')
                        <x-strata::form.error>{{ $message }}</x-strata::form.error>
                    @enderror
                </x-strata::form.field>
            </div>

            <x-strata::button type="submit" icon="calendar-check">
                Schedule Event
            </x-strata::button>
        </form>
    </section>

    {{-- Common Use Cases --}}
    <section class="space-y-6">
        <div class="space-y-2">
            <h2 class="text-3xl font-semibold">Common Use Cases</h2>
            <p class="text-muted-foreground">Typical date and time picker scenarios</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <x-strata::form.field>
                <x-strata::form.label for="birthDate">Date of Birth</x-strata::form.label>
                <x-strata::date-picker
                    id="birthDate"
                    wire:model="birthDate"
                    placeholder="MM/DD/YYYY"
                />
                <x-strata::form.hint>Required for age verification</x-strata::form.hint>
            </x-strata::form.field>

            <x-strata::form.field>
                <x-strata::form.label for="meetingDate">Meeting Date</x-strata::form.label>
                <x-strata::date-picker
                    id="meetingDate"
                    wire:model="meetingDate"
                    placeholder="Select date"
                />
            </x-strata::form.field>

            <x-strata::form.field>
                <x-strata::form.label for="meetingTime">Meeting Time</x-strata::form.label>
                <x-strata::time-picker
                    id="meetingTime"
                    wire:model="meetingTime"
                    placeholder="Select time"
                />
            </x-strata::form.field>

            <x-strata::form.field>
                <x-strata::form.label for="deliveryDate">Delivery Date</x-strata::form.label>
                <x-strata::date-picker
                    id="deliveryDate"
                    wire:model="deliveryDate"
                    placeholder="Choose delivery date"
                />
                <x-strata::form.hint>Next available: {{ now()->addDays(2)->format('M d, Y') }}</x-strata::form.hint>
            </x-strata::form.field>

            <x-strata::form.field>
                <x-strata::form.label for="deliveryTime">Delivery Window</x-strata::form.label>
                <x-strata::time-picker
                    id="deliveryTime"
                    wire:model="deliveryTime"
                    placeholder="Preferred time"
                />
                <x-strata::form.hint>Between 9 AM - 5 PM</x-strata::form.hint>
            </x-strata::form.field>
        </div>
    </section>

    {{-- Features Demonstrated --}}
    <section class="space-y-6">
        <div class="space-y-2">
            <h2 class="text-3xl font-semibold">Features Demonstrated</h2>
            <p class="text-muted-foreground">Complete feature checklist</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="flex items-start gap-3">
                <div class="text-success text-xl">✓</div>
                <div class="space-y-1">
                    <h4 class="font-medium">Multiple Selection Modes</h4>
                    <p class="text-sm text-muted-foreground">Single, range, and multiple date selection</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="text-success text-xl">✓</div>
                <div class="space-y-1">
                    <h4 class="font-medium">Time Formats</h4>
                    <p class="text-sm text-muted-foreground">12h, 24h, with optional seconds</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="text-success text-xl">✓</div>
                <div class="space-y-1">
                    <h4 class="font-medium">3 Size Variants</h4>
                    <p class="text-sm text-muted-foreground">Small, medium, large for both components</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="text-success text-xl">✓</div>
                <div class="space-y-1">
                    <h4 class="font-medium">Validation States</h4>
                    <p class="text-sm text-muted-foreground">Success and error states with icons</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="text-success text-xl">✓</div>
                <div class="space-y-1">
                    <h4 class="font-medium">Livewire Integration</h4>
                    <p class="text-sm text-muted-foreground">wire:model, validation, real-time updates</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="text-success text-xl">✓</div>
                <div class="space-y-1">
                    <h4 class="font-medium">Form Integration</h4>
                    <p class="text-sm text-muted-foreground">Works with form labels, hints, and errors</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="text-success text-xl">✓</div>
                <div class="space-y-1">
                    <h4 class="font-medium">Keyboard Navigation</h4>
                    <p class="text-sm text-muted-foreground">Full keyboard support for accessibility</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="text-success text-xl">✓</div>
                <div class="space-y-1">
                    <h4 class="font-medium">Clearable</h4>
                    <p class="text-sm text-muted-foreground">Clear button to reset selection</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="text-success text-xl">✓</div>
                <div class="space-y-1">
                    <h4 class="font-medium">Tactile Depth</h4>
                    <p class="text-sm text-muted-foreground">Subtle inset shadow for interactive feel</p>
                </div>
            </div>
        </div>
    </section>
</div>
