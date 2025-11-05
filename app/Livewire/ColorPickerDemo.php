<?php

namespace App\Livewire;

use Livewire\Component;

class ColorPickerDemo extends Component
{
    public string $primaryColor = '#3b82f6';
    public string $secondaryColor = '#71717a';
    public string $accentColor = '#22c55e';
    public string $backgroundColor = '#ffffff';
    public string $textColor = '#09090b';
    public string $hslColor = 'hsl(217, 91%, 60%)';
    public string $alphaColor = '#3b82f6cc';

    public function render()
    {
        return view('livewire.color-picker-demo');
    }
}
