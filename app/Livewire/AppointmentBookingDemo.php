<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Stratos\StrataUI\Data\DateRange;
use Stratos\StrataUI\Data\DateValue;
use Stratos\StrataUI\Data\TimeValue;

#[Layout('components.layouts.app')]
class AppointmentBookingDemo extends Component
{
    public ?string $bookingType = 'single';

    public int $currentStep = 1;

    public ?DateValue $appointmentDate = null;

    public ?TimeValue $appointmentTime = null;

    public ?string $patientName = null;

    public ?string $patientEmail = null;

    public ?string $notes = null;

    public ?DateRange $recurringDateRange = null;

    public ?TimeValue $recurringTime = null;

    public array $bookedSlots = [];

    public array $confirmedBookings = [];

    public array $bookedTimesForSelectedDate = [];

    public function mount(): void
    {
        $today = DateValue::today();
        $tomorrow = DateValue::tomorrow();
        $dayAfter = $tomorrow->addDays(1);

        $this->bookedSlots = [
            ['date' => $today->toDateString(), 'time' => '10:00 AM', 'patient' => 'John Doe', 'type' => 'General Checkup'],
            ['date' => $today->toDateString(), 'time' => '02:30 PM', 'patient' => 'Jane Smith', 'type' => 'Consultation'],
            ['date' => $tomorrow->toDateString(), 'time' => '09:00 AM', 'patient' => 'Bob Wilson', 'type' => 'Follow-up'],
            ['date' => $tomorrow->toDateString(), 'time' => '03:45 PM', 'patient' => 'Alice Brown', 'type' => 'Therapy Session'],
            ['date' => $dayAfter->toDateString(), 'time' => '11:00 AM', 'patient' => 'Charlie Davis', 'type' => 'Physical Exam'],
        ];

        $this->updateBookedTimesForSelectedDate();
    }

    public function updatedAppointmentDate(): void
    {
        $this->updateBookedTimesForSelectedDate();
    }

    protected function updateBookedTimesForSelectedDate(): void
    {
        $this->bookedTimesForSelectedDate = $this->getBookedTimesForDate($this->appointmentDate);
    }

    public function getBookedTimesForDate(?DateValue $date): array
    {
        if (! $date) {
            return [];
        }

        $dateString = $date->toDateString();

        $bookedTimes = collect($this->bookedSlots)
            ->where('date', $dateString)
            ->pluck('time')
            ->map(function ($time) {
                return $this->convertTo24Hour($time);
            })
            ->toArray();

        return array_merge($bookedTimes, ['12:00', '12:15', '12:30', '12:45']);
    }

    public function convertTo24Hour(string $time12): string
    {
        try {
            $timeValue = TimeValue::make($time12);

            return $timeValue->toString(true, false);
        } catch (\Exception $e) {
            return '';
        }
    }

    public function setBookingType($type): void
    {
        $this->bookingType = $type;
        $this->currentStep = 1;
        $this->reset(['appointmentDate', 'appointmentTime', 'recurringDateRange', 'recurringTime', 'patientName', 'patientEmail', 'notes']);
    }

    public function nextStep(): void
    {
        $this->validate($this->getValidationRules());

        if ($this->currentStep < 4) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function bookAppointment(): void
    {
        $this->validate($this->getValidationRules());

        if ($this->bookingType === 'single') {
            $this->confirmedBookings[] = [
                'id' => uniqid(),
                'type' => 'single',
                'date' => $this->appointmentDate->toDateString(),
                'time' => $this->appointmentTime->toString(false),
                'patient' => $this->patientName,
                'email' => $this->patientEmail,
                'notes' => $this->notes,
                'booked_at' => now()->format('M d, Y g:i A'),
            ];

            session()->flash('message', "Appointment booked for {$this->patientName} on ".$this->appointmentDate->format('M d, Y')." at {$this->appointmentTime->toString(false)}");
        } else {
            $startDate = $this->recurringDateRange->getStartDate();
            $endDate = $this->recurringDateRange->getEndDate();

            $this->confirmedBookings[] = [
                'id' => uniqid(),
                'type' => 'recurring',
                'date_range' => "{$startDate->format('M d')} to {$endDate->format('M d, Y')}",
                'time' => $this->recurringTime->toString(false),
                'patient' => $this->patientName,
                'email' => $this->patientEmail,
                'notes' => $this->notes,
                'booked_at' => now()->format('M d, Y g:i A'),
            ];

            session()->flash('message', "Recurring appointments booked for {$this->patientName} from {$startDate->format('M d')} to {$endDate->format('M d, Y')} at {$this->recurringTime->toString(false)}");
        }

        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->currentStep = 1;
        $this->appointmentDate = null;
        $this->appointmentTime = null;
        $this->recurringDateRange = null;
        $this->recurringTime = null;
        $this->patientName = null;
        $this->patientEmail = null;
        $this->notes = null;
    }

    public function cancelBooking($bookingId): void
    {
        $this->confirmedBookings = collect($this->confirmedBookings)
            ->reject(fn ($booking) => $booking['id'] === $bookingId)
            ->values()
            ->toArray();

        session()->flash('message', 'Appointment cancelled successfully');
    }

    protected function getValidationRules(): array
    {
        $rules = [];

        if ($this->currentStep === 1) {
            if ($this->bookingType === 'single') {
                $rules['appointmentDate'] = ['required', function ($attribute, $value, $fail) {
                    if (! $value instanceof DateValue) {
                        $fail('Please select an appointment date');

                        return;
                    }
                    if ($value->isPast() && ! $value->isToday()) {
                        $fail('Appointment date must be today or in the future');
                    }
                }];
            } else {
                $rules['recurringDateRange'] = ['required', function ($attribute, $value, $fail) {
                    if (! $value instanceof DateRange) {
                        $fail('Please select a date range');

                        return;
                    }
                    if ($value->getStartDate()->isPast() && ! $value->getStartDate()->isToday()) {
                        $fail('Start date must be today or in the future');
                    }
                }];
            }
        }

        if ($this->currentStep === 2) {
            if ($this->bookingType === 'single') {
                $rules['appointmentTime'] = ['required', function ($attribute, $value, $fail) {
                    if (! $value instanceof TimeValue) {
                        $fail('Please select an appointment time');
                    }
                }];
            } else {
                $rules['recurringTime'] = ['required', function ($attribute, $value, $fail) {
                    if (! $value instanceof TimeValue) {
                        $fail('Please select a recurring time');
                    }
                }];
            }
        }

        if ($this->currentStep === 3) {
            $rules['patientName'] = 'required|string|min:2';
            $rules['patientEmail'] = 'required|email';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'patientName.required' => 'Patient name is required',
            'patientName.min' => 'Patient name must be at least 2 characters',
            'patientEmail.required' => 'Email address is required',
            'patientEmail.email' => 'Please enter a valid email address',
        ];
    }

    public function render()
    {
        return view('livewire.appointment-booking-demo');
    }
}
