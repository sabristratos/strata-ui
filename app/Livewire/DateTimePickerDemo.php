<?php

namespace App\Livewire;

use Livewire\Component;

class DateTimePickerDemo extends Component
{
    public ?string $singleDate = null;
    public ?array $dateRange = null;
    public ?array $multipleDates = null;

    public ?string $time12h = null;
    public ?string $time24h = null;
    public ?string $timeWithSeconds = null;

    public ?string $appointmentDate = null;
    public ?string $appointmentTime = null;

    public ?string $eventStartDate = null;
    public ?string $eventEndDate = null;
    public ?string $eventStartTime = null;
    public ?string $eventEndTime = null;

    public ?string $birthDate = null;
    public ?string $meetingDate = null;
    public ?string $meetingTime = null;

    public ?string $deliveryDate = null;
    public ?string $deliveryTime = null;

    public function mount(): void
    {
        $this->singleDate = '2025-06-15';
        $this->dateRange = ['2025-06-15', '2025-06-20'];
        $this->multipleDates = ['2025-06-15', '2025-06-18', '2025-06-22'];

        $this->time12h = '14:30';
        $this->time24h = '09:00';
        $this->timeWithSeconds = '15:45:30';

        $this->appointmentDate = '2025-06-20';
        $this->appointmentTime = '10:00';
    }

    public function resetAll(): void
    {
        $this->singleDate = null;
        $this->dateRange = null;
        $this->multipleDates = null;
        $this->time12h = null;
        $this->time24h = null;
        $this->timeWithSeconds = null;
        $this->appointmentDate = null;
        $this->appointmentTime = null;
        $this->eventStartDate = null;
        $this->eventEndDate = null;
        $this->eventStartTime = null;
        $this->eventEndTime = null;
        $this->birthDate = null;
        $this->meetingDate = null;
        $this->meetingTime = null;
        $this->deliveryDate = null;
        $this->deliveryTime = null;
    }

    public function submitBooking(): void
    {
        $this->validate([
            'appointmentDate' => 'required|date',
            'appointmentTime' => 'required',
        ]);
    }

    public function submitEvent(): void
    {
        $this->validate([
            'eventStartDate' => 'required|date',
            'eventEndDate' => 'required|date|after_or_equal:eventStartDate',
            'eventStartTime' => 'required',
            'eventEndTime' => 'required',
        ]);
    }

    public function render()
    {
        return view('livewire.date-time-picker-demo');
    }
}
