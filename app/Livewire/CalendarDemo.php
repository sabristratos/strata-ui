<?php

namespace App\Livewire;

use Livewire\Component;

class CalendarDemo extends Component
{
    public ?string $singleDate = null;
    public array $multipleDates = [];
    public array $dateRange = [];
    public array $weekSelection = [];
    public ?string $inputDate = null;
    public array $inputRange = [];
    public ?string $constrainedDate = null;

    public function mount(): void
    {
        $this->singleDate = now()->format('Y-m-d');
        $this->inputDate = now()->addDays(3)->format('Y-m-d');

        $this->dateRange = [
            now()->subDays(7)->format('Y-m-d'),
            now()->format('Y-m-d'),
        ];

        $this->multipleDates = [
            now()->format('Y-m-d'),
            now()->addDays(2)->format('Y-m-d'),
            now()->addDays(5)->format('Y-m-d'),
        ];
    }

    public function render()
    {
        return view('livewire.calendar-demo');
    }
}
