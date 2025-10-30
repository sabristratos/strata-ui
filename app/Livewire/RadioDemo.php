<?php

namespace App\Livewire;

use Livewire\Component;

class RadioDemo extends Component
{
    public string $selectedPlan = 'basic';

    public string $selectedSize = 'md';

    public string $selectedColor = 'blue';

    public string $selectedCardPlan = 'pro';

    public string $selectedPillOption = 'development';

    public string $message = '';

    public function submit(): void
    {
        $this->message = 'Form submitted! Selected plan: '.$this->selectedPlan;
    }

    public function render()
    {
        return view('livewire.radio-demo');
    }
}
