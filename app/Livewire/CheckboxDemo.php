<?php

namespace App\Livewire;

use Livewire\Component;

class CheckboxDemo extends Component
{
    public bool $agreed = false;

    public bool $notifications = true;

    public bool $newsletter = false;

    public array $selectedOptions = [];

    public bool $selectAll = false;

    public string $message = '';

    public array $availableOptions = [
        'react' => 'React',
        'vue' => 'Vue',
        'angular' => 'Angular',
        'svelte' => 'Svelte',
    ];

    public array $selectedPlanCards = [];

    public array $selectedPillOptions = [];

    public function mount(): void
    {
        $this->message = '';
        $this->selectedPlanCards = ['pro'];
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedOptions = array_keys($this->availableOptions);
        } else {
            $this->selectedOptions = [];
        }
    }

    public function updatedSelectedOptions(): void
    {
        $this->selectAll = count($this->selectedOptions) === count($this->availableOptions);
    }

    public function submit(): void
    {
        $this->message = 'Form submitted! Agreed: '.($this->agreed ? 'Yes' : 'No');
    }

    public function render()
    {
        return view('livewire.checkbox-demo');
    }
}
