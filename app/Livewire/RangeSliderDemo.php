<?php

namespace App\Livewire;

use Livewire\Component;

class RangeSliderDemo extends Component
{
    public array $priceRange = ['min' => 100, 'max' => 900];

    public array $ageRange = ['min' => 25, 'max' => 45];

    public array $discountRange = ['min' => 10, 'max' => 50];

    public array $ratingRange = ['min' => 2, 'max' => 5];

    public array $temperatureRange = ['min' => 15, 'max' => 25];

    public array $volumeRange = ['min' => 30, 'max' => 70];

    public function render()
    {
        return view('livewire.range-slider-demo');
    }
}
