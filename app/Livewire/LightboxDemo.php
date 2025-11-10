<?php

namespace App\Livewire;

use Livewire\Component;

class LightboxDemo extends Component
{
    public array $images = [];

    public array $mixedMedia = [];

    public function mount(): void
    {
        $this->images = [
            [
                'url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4',
                'caption' => 'Mountain landscape at sunrise',
            ],
            [
                'url' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e',
                'caption' => 'Forest path through the trees',
            ],
            [
                'url' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e',
                'caption' => 'Serene lake with mountain reflection',
            ],
            [
                'url' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29',
                'caption' => 'Rocky coastline at sunset',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.lightbox-demo');
    }
}
