<?php

namespace App\Livewire;

use Livewire\Component;

class SelectDemo extends Component
{
    public ?string $selectedCountry = null;

    public ?string $selectedFruit = 'apple';

    public array $selectedColors = [];

    public array $selectedFrameworks = [];

    public array $selectedTags = [];

    public string $message = '';

    public array $countries = [
        'us' => 'United States',
        'ca' => 'Canada',
        'mx' => 'Mexico',
        'uk' => 'United Kingdom',
        'de' => 'Germany',
        'fr' => 'France',
        'jp' => 'Japan',
        'au' => 'Australia',
    ];

    public array $fruits = [
        'apple' => 'Apple',
        'banana' => 'Banana',
        'orange' => 'Orange',
        'grape' => 'Grape',
        'mango' => 'Mango',
    ];

    public array $colors = [
        'red' => 'Red',
        'blue' => 'Blue',
        'green' => 'Green',
        'yellow' => 'Yellow',
        'purple' => 'Purple',
    ];

    public array $frameworks = [
        'laravel' => 'Laravel',
        'symfony' => 'Symfony',
        'codeigniter' => 'CodeIgniter',
        'yii' => 'Yii',
        'cakephp' => 'CakePHP',
    ];

    public array $tags = [
        'php' => 'PHP',
        'javascript' => 'JavaScript',
        'python' => 'Python',
        'ruby' => 'Ruby',
        'go' => 'Go',
        'rust' => 'Rust',
    ];

    public function mount(): void
    {
        $this->selectedColors = ['blue', 'green'];
        $this->selectedFrameworks = ['laravel'];
        $this->selectedTags = [];
    }

    public function submit(): void
    {
        $this->message = 'Form submitted! Country: '.($this->selectedCountry ?? 'None')
            .', Colors: '.count($this->selectedColors)
            .' selected';
    }

    public function render()
    {
        return view('livewire.select-demo');
    }
}
