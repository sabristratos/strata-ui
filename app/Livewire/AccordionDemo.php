<?php

namespace App\Livewire;

use Livewire\Component;

class AccordionDemo extends Component
{
    public array $faqData = [];

    public string $selectedItem = '';

    public array $multipleSelectedItems = [];

    public function mount(): void
    {
        $this->faqData = [
            [
                'id' => 'faq-1',
                'question' => 'What is Strata UI?',
                'answer' => 'Strata UI is a modern Blade and Livewire component library that provides clean, flexible, and powerful UI components for Laravel applications.',
            ],
            [
                'id' => 'faq-2',
                'question' => 'How do I install it?',
                'answer' => 'You can install Strata UI via Composer. Simply run `composer require strata-ui/strata-ui` and follow the setup instructions.',
            ],
            [
                'id' => 'faq-3',
                'question' => 'Does it support dark mode?',
                'answer' => 'Yes! Strata UI has built-in dark mode support using the light-dark() CSS function and Tailwind CSS v4.',
            ],
            [
                'id' => 'faq-4',
                'question' => 'Can I customize the components?',
                'answer' => 'Absolutely! Strata UI components are designed to be highly customizable through props, slots, and theme variables.',
            ],
        ];

        $this->selectedItem = '';
        $this->multipleSelectedItems = ['faq-1'];
    }

    public function handleItemClick(string $itemId): void
    {
        if ($this->selectedItem === $itemId) {
            $this->selectedItem = '';
        } else {
            $this->selectedItem = $itemId;
        }
    }

    public function render()
    {
        return view('livewire.accordion-demo');
    }
}
