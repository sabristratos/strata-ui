<?php

namespace App\Livewire;

use Livewire\Component;

class SliderDemo extends Component
{
    public function render(): \Illuminate\View\View
    {
        $images = [
            ['url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800', 'caption' => 'Mountain landscape at sunrise'],
            ['url' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800', 'caption' => 'Forest path through the trees'],
            ['url' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=800', 'caption' => 'Serene lake with mountain reflection'],
            ['url' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=800', 'caption' => 'Rocky coastline at sunset'],
            ['url' => 'https://images.unsplash.com/photo-1682687220923-c58b9a4592ae?w=800', 'caption' => 'Modern city skyline at night'],
        ];

        $testimonials = [
            ['author' => 'Sarah Johnson', 'role' => 'CEO, TechCorp', 'content' => 'This product has transformed how we work. The team is incredibly responsive and the features are exactly what we needed.'],
            ['author' => 'Michael Chen', 'role' => 'Designer', 'content' => 'Beautiful design and intuitive interface. It\'s rare to find a tool that looks great and works even better.'],
            ['author' => 'Emma Williams', 'role' => 'Developer', 'content' => 'The API is well-documented and easy to integrate. We were up and running in less than a day.'],
            ['author' => 'David Brown', 'role' => 'Product Manager', 'content' => 'Our productivity has increased by 40% since adopting this solution. Highly recommended!'],
        ];

        return view('livewire.slider-demo', [
            'images' => $images,
            'testimonials' => $testimonials,
        ]);
    }
}
