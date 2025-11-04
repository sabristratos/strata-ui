<?php

namespace App\Livewire;

use Livewire\Component;
use Stratos\StrataUI\Data\DateValue;
use Stratos\StrataUI\Data\DateRange;
use Stratos\StrataUI\Data\TimeValue;

class UserProfileDemo extends Component
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $department = null;
    public array $skills = [];
    public ?DateValue $birthDate = null;
    public ?DateRange $employmentPeriod = null;
    public ?TimeValue $preferredContactTime = null;
    public bool $saving = false;
    public bool $saved = false;
    public ?string $savedData = null;

    public function mount(): void
    {
        $this->name = 'John Doe';
        $this->email = 'john@example.com';
        $this->department = 'engineering';
        $this->skills = ['laravel', 'php'];
        $this->birthDate = DateValue::make('1990-05-15');
        $this->employmentPeriod = DateRange::between('2020-01-01', '2024-12-31');
        $this->preferredContactTime = TimeValue::make('2:30 PM');
    }

    public function save(): void
    {
        $this->saving = true;
        $this->saved = false;
        $this->savedData = null;
        $this->resetValidation();

        $validated = $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email'],
            'department' => ['required', 'string'],
            'skills' => ['required', 'array', 'min:1'],
            'birthDate' => ['required', function ($attribute, $value, $fail) {
                if (!$value instanceof DateValue) {
                    $fail('Please select a valid birth date');
                    return;
                }
                if ($value->isFuture()) {
                    $fail('Birth date cannot be in the future');
                }
                $age = $value->toCarbon()->diffInYears(now());
                if ($age < 18) {
                    $fail('You must be at least 18 years old');
                }
            }],
            'employmentPeriod' => ['required', function ($attribute, $value, $fail) {
                if (!$value instanceof DateRange) {
                    $fail('Please select an employment period');
                    return;
                }
                if ($value->getStartDate()->isFuture()) {
                    $fail('Employment start date cannot be in the future');
                }
            }],
            'preferredContactTime' => ['required', function ($attribute, $value, $fail) {
                if (!$value instanceof TimeValue) {
                    $fail('Please select a preferred contact time');
                }
            }],
        ]);

        sleep(1);

        $this->savedData = json_encode([
            'name' => $this->name,
            'email' => $this->email,
            'department' => $this->department,
            'skills' => $this->skills,
            'birthDate' => $this->birthDate?->toDateString(),
            'birthDateFormatted' => $this->birthDate?->format('M d, Y'),
            'employmentPeriod' => [
                'start' => $this->employmentPeriod?->getStartDate()->format('Y-m-d'),
                'end' => $this->employmentPeriod?->getEndDate()->format('Y-m-d'),
                'formatted' => $this->employmentPeriod?->getStartDate()->format('M d, Y') . ' - ' . $this->employmentPeriod?->getEndDate()->format('M d, Y'),
            ],
            'preferredContactTime' => $this->preferredContactTime?->to12HourFormat(),
        ], JSON_PRETTY_PRINT);

        $this->saving = false;
        $this->saved = true;
    }

    public function clear(): void
    {
        $this->reset([
            'name',
            'email',
            'department',
            'skills',
            'birthDate',
            'employmentPeriod',
            'preferredContactTime',
            'saved',
            'savedData',
        ]);
        $this->resetValidation();
    }

    public function getDisabledTimesProperty(): array
    {
        return [
            '12:00 AM',
            '1:00 AM',
            '2:00 AM',
            '3:00 AM',
            '4:00 AM',
            '5:00 AM',
        ];
    }

    public function render()
    {
        return view('livewire.user-profile-demo');
    }
}
