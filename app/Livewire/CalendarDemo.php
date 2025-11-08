<?php

namespace App\Livewire;

use Livewire\Component;

class CalendarDemo extends Component
{
    public $singleDate = null;

    public $rangeDate = null;

    public $multipleDate = [];

    public $weekDate = [];

    public $constrainedDate = null;

    public $presetsDate = null;

    public $datePickerSingle = null;

    public $datePickerRange = null;

    public function render()
    {
        return view('livewire.calendar-demo');
    }
}
