<div class="container mx-auto py-12 px-4 max-w-7xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Appointment Booking System</h1>
        <p class="text-muted-foreground">Real-world demo showcasing Date Picker, Date Range Picker, and Time Picker components</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-success/10 border border-success rounded-lg text-success flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-card border border-border rounded-lg p-6">
                <div class="flex gap-2 mb-6">
                    <button
                        wire:click="setBookingType('single')"
                        @class([
                            'flex-1 px-4 py-3 rounded-lg font-medium transition-all',
                            'bg-primary text-primary-foreground' => $bookingType === 'single',
                            'bg-muted text-muted-foreground hover:bg-muted/70' => $bookingType !== 'single',
                        ])
                    >
                        Single Appointment
                    </button>
                    <button
                        wire:click="setBookingType('recurring')"
                        @class([
                            'flex-1 px-4 py-3 rounded-lg font-medium transition-all',
                            'bg-primary text-primary-foreground' => $bookingType === 'recurring',
                            'bg-muted text-muted-foreground hover:bg-muted/70' => $bookingType !== 'recurring',
                        ])
                    >
                        Recurring Appointments
                    </button>
                </div>

                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="flex items-center flex-1">
                                <div @class([
                                    'w-10 h-10 rounded-full flex items-center justify-center font-semibold transition-all',
                                    'bg-primary text-primary-foreground' => $currentStep >= $i,
                                    'bg-muted text-muted-foreground' => $currentStep < $i,
                                ])>
                                    {{ $i }}
                                </div>
                                @if ($i < 4)
                                    <div @class([
                                        'flex-1 h-1 mx-2 transition-all',
                                        'bg-primary' => $currentStep > $i,
                                        'bg-muted' => $currentStep <= $i,
                                    ])></div>
                                @endif
                            </div>
                        @endfor
                    </div>
                    <div class="flex justify-between mt-2 text-sm">
                        <span @class(['font-medium' => $currentStep === 1, 'text-muted-foreground' => $currentStep !== 1])>Date</span>
                        <span @class(['font-medium' => $currentStep === 2, 'text-muted-foreground' => $currentStep !== 2])>Time</span>
                        <span @class(['font-medium' => $currentStep === 3, 'text-muted-foreground' => $currentStep !== 3])>Details</span>
                        <span @class(['font-medium' => $currentStep === 4, 'text-muted-foreground' => $currentStep !== 4])>Confirm</span>
                    </div>
                </div>

                @if ($currentStep === 1)
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">
                            @if ($bookingType === 'single')
                                Select Appointment Date
                            @else
                                Select Date Range
                            @endif
                        </h3>

                        @if ($bookingType === 'single')
                            <div>
                                <label class="block text-sm font-medium mb-2">Appointment Date</label>
                                <x-strata::date-picker
                                    wire:key="date-picker-single-{{ $bookingType }}"
                                    wire:model.live="appointmentDate"
                                    :value="$appointmentDate"
                                    mode="single"
                                    :min-date="date('Y-m-d')"
                                    :show-presets="true"
                                    placeholder="Select date"
                                    :state="$errors->has('appointmentDate') ? 'error' : 'default'"
                                />
                                @error('appointmentDate')
                                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            <div>
                                <label class="block text-sm font-medium mb-2">Date Range</label>
                                <x-strata::date-picker
                                    wire:key="date-picker-range-{{ $bookingType }}"
                                    wire:model.live="recurringDateRange"
                                    :value="$recurringDateRange"
                                    mode="range"
                                    :min-date="date('Y-m-d')"
                                    :show-presets="true"
                                    placeholder="Select date range"
                                    :state="$errors->has('recurringDateRange') ? 'error' : 'default'"
                                />
                                @error('recurringDateRange')
                                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="bg-muted/30 border border-border rounded-lg p-4">
                            <h4 class="font-medium mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Business Hours
                            </h4>
                            <p class="text-sm text-muted-foreground">Monday - Friday: 9:00 AM - 5:00 PM</p>
                            <p class="text-sm text-muted-foreground">Lunch Break: 12:00 PM - 1:00 PM (unavailable)</p>
                        </div>
                    </div>
                @endif

                @if ($currentStep === 2)
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">
                            @if ($bookingType === 'single')
                                Select Appointment Time
                            @else
                                Select Recurring Time
                            @endif
                        </h3>

                        @if ($bookingType === 'single')
                            <div>
                                <label class="block text-sm font-medium mb-2">Appointment Time</label>
                                <x-strata::time-picker
                                    wire:model.live="appointmentTime"
                                    format="12"
                                    :step-minutes="15"
                                    min-time="09:00"
                                    max-time="17:00"
                                    :disabled-times="$bookedTimesForSelectedDate"
                                    :show-presets="true"
                                    placeholder="Select time"
                                    :state="$errors->has('appointmentTime') ? 'error' : 'default'"
                                />
                                @error('appointmentTime')
                                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($appointmentDate)
                                <div class="bg-muted/30 border border-border rounded-lg p-4">
                                    <h4 class="font-medium mb-2">Booked Slots for {{ $appointmentDate->format('M d, Y') }}</h4>
                                    @php
                                        $bookedForDate = collect($bookedSlots)->where('date', $appointmentDate->toDateString());
                                    @endphp

                                    @if ($bookedForDate->count() > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($bookedForDate as $slot)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-destructive/10 text-destructive border border-destructive/20">
                                                    {{ $slot['time'] }}
                                                </span>
                                            @endforeach
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-warning/10 text-warning border border-warning/20">
                                                12:00 PM - 1:00 PM (Lunch)
                                            </span>
                                        </div>
                                    @else
                                        <p class="text-sm text-muted-foreground">All slots available (except lunch 12-1 PM)</p>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div>
                                <label class="block text-sm font-medium mb-2">Weekly Appointment Time</label>
                                <x-strata::time-picker
                                    wire:model.live="recurringTime"
                                    format="12"
                                    :step-minutes="15"
                                    min-time="09:00"
                                    max-time="17:00"
                                    :show-presets="true"
                                    placeholder="Select recurring time"
                                    :state="$errors->has('recurringTime') ? 'error' : 'default'"
                                />
                                @error('recurringTime')
                                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-muted/30 border border-border rounded-lg p-4">
                                <h4 class="font-medium mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Recurring Pattern
                                </h4>
                                <p class="text-sm text-muted-foreground">This will book appointments at the same time for every weekday within your selected date range.</p>
                            </div>
                        @endif
                    </div>
                @endif

                @if ($currentStep === 3)
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">Patient Information</h3>

                        <div>
                            <label class="block text-sm font-medium mb-2">Full Name *</label>
                            <x-strata::input
                                wire:model.live="patientName"
                                placeholder="Enter patient name"
                                :state="$errors->has('patientName') ? 'error' : 'default'"
                            />
                            @error('patientName')
                                <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Email Address *</label>
                            <x-strata::input
                                type="email"
                                wire:model.live="patientEmail"
                                placeholder="patient@example.com"
                                :state="$errors->has('patientEmail') ? 'error' : 'default'"
                            />
                            @error('patientEmail')
                                <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Additional Notes (Optional)</label>
                            <x-strata::textarea
                                wire:model="notes"
                                placeholder="Any special requirements or notes..."
                                rows="4"
                            />
                        </div>
                    </div>
                @endif

                @if ($currentStep === 4)
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold">Confirm Your Appointment</h3>

                        <div class="bg-muted/30 border border-border rounded-lg p-6 space-y-4">
                            @if ($bookingType === 'single')
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Appointment Date</p>
                                        <p class="text-muted-foreground">{{ $appointmentDate?->format('l, F d, Y') ?: 'Not selected' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Appointment Time</p>
                                        <p class="text-muted-foreground">{{ $appointmentTime?->to12HourFormat() ?: 'Not selected' }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Date Range</p>
                                        <p class="text-muted-foreground">
                                            @if ($recurringDateRange)
                                                {{ $recurringDateRange->start->format('M d') }} - {{ $recurringDateRange->end->format('M d, Y') }}
                                            @else
                                                Not selected
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Weekly Time</p>
                                        <p class="text-muted-foreground">{{ $recurringTime?->to12HourFormat() ?: 'Not selected' }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <div>
                                    <p class="font-medium">Patient</p>
                                    <p class="text-muted-foreground">{{ $patientName ?: 'Not provided' }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $patientEmail ?: 'No email' }}</p>
                                </div>
                            </div>

                            @if ($notes)
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Notes</p>
                                        <p class="text-muted-foreground text-sm">{{ $notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="bg-primary/5 border border-primary/20 rounded-lg p-4 flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm">
                                <p class="font-medium text-primary">Confirmation</p>
                                <p class="text-muted-foreground">A confirmation email will be sent to {{ $patientEmail }} after booking.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex justify-between mt-8 pt-6 border-t border-border">
                    @if ($currentStep > 1)
                        <x-strata::button
                            variant="secondary"
                            wire:click="previousStep"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back
                        </x-strata::button>
                    @else
                        <div></div>
                    @endif

                    @if ($currentStep < 4)
                        <x-strata::button wire:click="nextStep">
                            Next
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </x-strata::button>
                    @else
                        <x-strata::button wire:click="bookAppointment">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Confirm Booking
                        </x-strata::button>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-card border border-border rounded-lg p-6 sticky top-6">
                <h3 class="font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Existing Appointments
                </h3>

                @if (count($bookedSlots) > 0)
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach ($bookedSlots as $slot)
                            <div class="p-3 bg-muted/30 border border-border rounded-lg text-sm">
                                <p class="font-medium">{{ $slot['patient'] }}</p>
                                <p class="text-muted-foreground text-xs mt-1">{{ $slot['type'] }}</p>
                                <div class="flex items-center gap-2 mt-2 text-xs text-muted-foreground">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ date('M d', strtotime($slot['date'])) }}
                                    <span class="mx-1">•</span>
                                    {{ $slot['time'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-muted-foreground">No existing appointments</p>
                @endif
            </div>

            @if (count($confirmedBookings) > 0)
                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Confirmed Bookings
                    </h3>

                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach ($confirmedBookings as $booking)
                            <div class="p-3 bg-success/5 border border-success/20 rounded-lg text-sm">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="font-medium">{{ $booking['patient'] }}</p>
                                        <p class="text-xs text-muted-foreground mt-1">
                                            @if ($booking['type'] === 'single')
                                                {{ date('M d, Y', strtotime($booking['date'])) }} at {{ $booking['time'] }}
                                            @else
                                                Recurring: {{ $booking['date_range'] }} at {{ $booking['time'] }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-muted-foreground mt-1">Booked: {{ $booking['booked_at'] }}</p>
                                    </div>
                                    <button
                                        wire:click="cancelBooking('{{ $booking['id'] }}')"
                                        class="text-destructive hover:text-destructive/80 transition-colors p-1"
                                        title="Cancel booking"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
