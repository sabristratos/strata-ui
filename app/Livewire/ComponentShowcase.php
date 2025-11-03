<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ComponentShowcase extends Component
{
    use WithFileUploads;

    public string $textInput = '';

    public string $emailInput = '';

    public string $passwordInput = '';

    public string $searchInput = '';

    public string $textareaInput = '';

    public bool $checkbox = false;

    public bool $checkboxNotifications = true;

    public bool $checkboxNewsletter = false;

    public array $selectedOptions = [];

    public bool $selectAll = false;

    public array $availableOptions = [
        'react' => 'React',
        'vue' => 'Vue',
        'angular' => 'Angular',
        'svelte' => 'Svelte',
    ];

    public string $radio = 'option1';

    public string $paymentMethod = 'card';

    public bool $toggle = false;

    public bool $toggleNotifications = true;

    public ?string $selectedCountry = null;

    public ?string $selectedFruit = 'apple';

    public array $selectedColors = [];

    public array $selectedFrameworks = [];

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

    public $uploadedFile = null;

    public array $uploadedFiles = [];

    public string $selectedAccordionItem = '';

    public array $multipleSelectedItems = [];

    public array $faqData = [];

    public bool $showModal = false;

    public bool $showSmallModal = false;

    public bool $showLargeModal = false;

    public int $rating = 0;

    public int $rating2 = 3;

    public array $tableData = [];

    public string $sortBy = 'name';

    public string $sortDirection = 'asc';

    public string $message = '';

    public string $activeNav = 'home';

    public string $activeNavIconOnly = 'home';

    public string $activeNavBadge = 'home';

    public string $activeNavState = 'home';

    public bool $loadingProfile = false;

    public function mount(): void
    {
        $this->selectedColors = ['blue', 'green'];
        $this->selectedFrameworks = ['laravel'];

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

        $this->multipleSelectedItems = ['faq-1'];

        $this->tableData = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'role' => 'Admin', 'status' => 'active'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'role' => 'Editor', 'status' => 'active'],
            ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com', 'role' => 'Viewer', 'status' => 'inactive'],
            ['id' => 4, 'name' => 'Alice Williams', 'email' => 'alice@example.com', 'role' => 'Admin', 'status' => 'active'],
            ['id' => 5, 'name' => 'Charlie Brown', 'email' => 'charlie@example.com', 'role' => 'Editor', 'status' => 'active'],
        ];
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

    public function handleAccordionClick(string $itemId): void
    {
        if ($this->selectedAccordionItem === $itemId) {
            $this->selectedAccordionItem = '';
        } else {
            $this->selectedAccordionItem = $itemId;
        }
    }

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function submit(): void
    {
        $this->message = 'Form submitted successfully! Email: '.$this->emailInput;
    }

    public function toggleProfileLoading(): void
    {
        $this->loadingProfile = ! $this->loadingProfile;
    }

    public function render()
    {
        return view('livewire.component-showcase');
    }
}
