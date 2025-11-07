<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TimePickerDemo extends Component
{
    public $basicTime = null;

    public $time12Hour = null;

    public $time24Hour = null;

    public $timeSmall = null;

    public $timeMedium = null;

    public $timeLarge = null;

    public $timeDefault = null;

    public $timeSuccess = '09:30';

    public $timeError = null;

    public $timeWarning = null;

    public $timeWithPresets = null;

    public $timeStep30 = null;

    public $timeStep60 = null;

    public $timeWithMin = null;

    public $timeWithMax = null;

    public $timeClearable = '14:00';

    public $timeDisabled = '10:00';

    public $meetingTime = null;

    public $appointmentTime = null;

    public $reminderTime = null;

    public function render()
    {
        return view('livewire.time-picker-demo');
    }
}
