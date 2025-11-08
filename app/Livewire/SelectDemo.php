<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class SelectDemo extends Component
{
    public $singleValue = null;

    public $multipleValues = [];

    public $searchableValue = null;

    public $sizeSmall = null;

    public $sizeMedium = null;

    public $sizeLarge = null;

    public $stateDefault = null;

    public $stateSuccess = 'success';

    public $stateError = null;

    public $stateWarning = null;

    public $clearableValue = 'option2';

    public $disabledValue = null;

    public $chipsValue = [];

    public $maxSelectedValue = [];

    public $iconSingleValue = null;

    public $iconMultipleValue = [];

    public $iconSearchableValue = null;

    public $country = null;

    public $state = null;

    public array $availableStates = [];

    public $category = null;

    public $subcategory = null;

    public array $availableSubcategories = [];

    public $department = null;

    public $employee = null;

    public array $availableEmployees = [];

    public $formProduct = null;

    public $formTags = [];

    public $formPriority = null;

    public $projectName = '';

    public $projectCategory = null;

    public $projectTags = [];

    public $projectStatus = null;

    public $projectMessage = null;

    public function mount()
    {
        $this->multipleValues = ['php', 'laravel'];
        $this->chipsValue = ['tag1', 'tag2', 'tag3'];
    }

    public function updatedCountry($value)
    {
        $this->state = null;
        $this->availableStates = $this->getStatesForCountry($value);
    }

    public function updatedCategory($value)
    {
        $this->subcategory = null;
        $this->availableSubcategories = $this->getSubcategoriesForCategory($value);
    }

    public function updatedDepartment($value)
    {
        $this->employee = null;
        $this->availableEmployees = $this->getEmployeesForDepartment($value);
    }

    public function resetForm()
    {
        $this->reset(['formProduct', 'formTags', 'formPriority']);
    }

    public function resetCascading()
    {
        $this->reset(['country', 'state', 'category', 'subcategory', 'department', 'employee']);
        $this->availableStates = [];
        $this->availableSubcategories = [];
        $this->availableEmployees = [];
    }

    public function submitProject()
    {
        $this->validate([
            'projectName' => 'required|min:3',
            'projectCategory' => 'required',
            'projectTags' => 'required|array|min:1',
            'projectStatus' => 'required',
        ]);

        $this->projectMessage = "Project '{$this->projectName}' created successfully with ".count($this->projectTags).' tags!';

        $this->reset(['projectName', 'projectCategory', 'projectTags', 'projectStatus']);
    }

    public function getCountries(): array
    {
        return [
            ['value' => 'us', 'label' => 'United States'],
            ['value' => 'ca', 'label' => 'Canada'],
            ['value' => 'uk', 'label' => 'United Kingdom'],
            ['value' => 'au', 'label' => 'Australia'],
        ];
    }

    private function getStatesForCountry(?string $country): array
    {
        return match ($country) {
            'us' => [
                ['value' => 'ca', 'label' => 'California'],
                ['value' => 'ny', 'label' => 'New York'],
                ['value' => 'tx', 'label' => 'Texas'],
                ['value' => 'fl', 'label' => 'Florida'],
            ],
            'ca' => [
                ['value' => 'on', 'label' => 'Ontario'],
                ['value' => 'qc', 'label' => 'Quebec'],
                ['value' => 'bc', 'label' => 'British Columbia'],
                ['value' => 'ab', 'label' => 'Alberta'],
            ],
            'uk' => [
                ['value' => 'eng', 'label' => 'England'],
                ['value' => 'sct', 'label' => 'Scotland'],
                ['value' => 'wal', 'label' => 'Wales'],
                ['value' => 'nir', 'label' => 'Northern Ireland'],
            ],
            'au' => [
                ['value' => 'nsw', 'label' => 'New South Wales'],
                ['value' => 'vic', 'label' => 'Victoria'],
                ['value' => 'qld', 'label' => 'Queensland'],
                ['value' => 'wa', 'label' => 'Western Australia'],
            ],
            default => [],
        };
    }

    public function getCategories(): array
    {
        return [
            ['value' => 'electronics', 'label' => 'Electronics'],
            ['value' => 'clothing', 'label' => 'Clothing'],
            ['value' => 'books', 'label' => 'Books'],
            ['value' => 'home', 'label' => 'Home & Garden'],
        ];
    }

    private function getSubcategoriesForCategory(?string $category): array
    {
        return match ($category) {
            'electronics' => [
                ['value' => 'laptops', 'label' => 'Laptops'],
                ['value' => 'phones', 'label' => 'Smartphones'],
                ['value' => 'tablets', 'label' => 'Tablets'],
                ['value' => 'accessories', 'label' => 'Accessories'],
            ],
            'clothing' => [
                ['value' => 'shirts', 'label' => 'Shirts'],
                ['value' => 'pants', 'label' => 'Pants'],
                ['value' => 'dresses', 'label' => 'Dresses'],
                ['value' => 'shoes', 'label' => 'Shoes'],
            ],
            'books' => [
                ['value' => 'fiction', 'label' => 'Fiction'],
                ['value' => 'nonfiction', 'label' => 'Non-Fiction'],
                ['value' => 'textbooks', 'label' => 'Textbooks'],
                ['value' => 'children', 'label' => 'Children\'s Books'],
            ],
            'home' => [
                ['value' => 'furniture', 'label' => 'Furniture'],
                ['value' => 'decor', 'label' => 'Decor'],
                ['value' => 'garden', 'label' => 'Garden'],
                ['value' => 'kitchen', 'label' => 'Kitchen'],
            ],
            default => [],
        };
    }

    public function getDepartments(): array
    {
        return [
            ['value' => 'engineering', 'label' => 'Engineering'],
            ['value' => 'sales', 'label' => 'Sales'],
            ['value' => 'hr', 'label' => 'Human Resources'],
            ['value' => 'marketing', 'label' => 'Marketing'],
        ];
    }

    private function getEmployeesForDepartment(?string $department): array
    {
        return match ($department) {
            'engineering' => [
                ['value' => 'john', 'label' => 'John Smith - Senior Developer'],
                ['value' => 'jane', 'label' => 'Jane Doe - Tech Lead'],
                ['value' => 'bob', 'label' => 'Bob Johnson - DevOps Engineer'],
                ['value' => 'alice', 'label' => 'Alice Williams - QA Engineer'],
            ],
            'sales' => [
                ['value' => 'mike', 'label' => 'Mike Brown - Sales Manager'],
                ['value' => 'sarah', 'label' => 'Sarah Davis - Account Executive'],
                ['value' => 'tom', 'label' => 'Tom Wilson - SDR'],
            ],
            'hr' => [
                ['value' => 'lisa', 'label' => 'Lisa Anderson - HR Director'],
                ['value' => 'kevin', 'label' => 'Kevin Taylor - Recruiter'],
                ['value' => 'emma', 'label' => 'Emma Martinez - HR Coordinator'],
            ],
            'marketing' => [
                ['value' => 'david', 'label' => 'David Garcia - Marketing Director'],
                ['value' => 'maria', 'label' => 'Maria Rodriguez - Content Manager'],
                ['value' => 'chris', 'label' => 'Chris Lee - SEO Specialist'],
                ['value' => 'anna', 'label' => 'Anna White - Social Media Manager'],
            ],
            default => [],
        };
    }

    public function getTechnologies(): array
    {
        return [
            ['value' => 'php', 'label' => 'PHP'],
            ['value' => 'laravel', 'label' => 'Laravel'],
            ['value' => 'livewire', 'label' => 'Livewire'],
            ['value' => 'alpine', 'label' => 'Alpine.js'],
            ['value' => 'tailwind', 'label' => 'Tailwind CSS'],
            ['value' => 'javascript', 'label' => 'JavaScript'],
            ['value' => 'vue', 'label' => 'Vue.js'],
            ['value' => 'react', 'label' => 'React'],
            ['value' => 'mysql', 'label' => 'MySQL'],
            ['value' => 'postgres', 'label' => 'PostgreSQL'],
        ];
    }

    public function getProducts(): array
    {
        return [
            ['value' => 'prod1', 'label' => 'Product Alpha'],
            ['value' => 'prod2', 'label' => 'Product Beta'],
            ['value' => 'prod3', 'label' => 'Product Gamma'],
            ['value' => 'prod4', 'label' => 'Product Delta'],
        ];
    }

    public function getTags(): array
    {
        return [
            ['value' => 'tag1', 'label' => 'Urgent'],
            ['value' => 'tag2', 'label' => 'Important'],
            ['value' => 'tag3', 'label' => 'Low Priority'],
            ['value' => 'tag4', 'label' => 'Bug'],
            ['value' => 'tag5', 'label' => 'Feature'],
            ['value' => 'tag6', 'label' => 'Enhancement'],
        ];
    }

    public function getPriorities(): array
    {
        return [
            ['value' => 'low', 'label' => 'Low'],
            ['value' => 'medium', 'label' => 'Medium'],
            ['value' => 'high', 'label' => 'High'],
            ['value' => 'critical', 'label' => 'Critical'],
        ];
    }

    public function getStatuses(): array
    {
        return [
            ['value' => 'draft', 'label' => 'Draft'],
            ['value' => 'in_progress', 'label' => 'In Progress'],
            ['value' => 'review', 'label' => 'In Review'],
            ['value' => 'completed', 'label' => 'Completed'],
        ];
    }

    public function getNotificationOptions(): array
    {
        return [
            ['value' => 'email', 'label' => 'Email Notifications', 'icon' => 'mail'],
            ['value' => 'bell', 'label' => 'Push Notifications', 'icon' => 'bell'],
            ['value' => 'message', 'label' => 'SMS Messages', 'icon' => 'message-square'],
            ['value' => 'phone', 'label' => 'Phone Calls', 'icon' => 'phone'],
        ];
    }

    public function getFileTypeOptions(): array
    {
        return [
            ['value' => 'document', 'label' => 'Documents', 'icon' => 'file-text'],
            ['value' => 'image', 'label' => 'Images', 'icon' => 'image'],
            ['value' => 'video', 'label' => 'Videos', 'icon' => 'video'],
            ['value' => 'audio', 'label' => 'Audio Files', 'icon' => 'headphones'],
            ['value' => 'archive', 'label' => 'Archives', 'icon' => 'archive'],
            ['value' => 'code', 'label' => 'Source Code', 'icon' => 'code'],
        ];
    }

    public function getStatusOptions(): array
    {
        return [
            ['value' => 'pending', 'label' => 'Pending', 'icon' => 'clock', 'description' => 'Awaiting review'],
            ['value' => 'active', 'label' => 'Active', 'icon' => 'check-circle', 'description' => 'Currently running'],
            ['value' => 'paused', 'label' => 'Paused', 'icon' => 'pause-circle', 'description' => 'Temporarily stopped'],
            ['value' => 'completed', 'label' => 'Completed', 'icon' => 'check', 'description' => 'Successfully finished'],
            ['value' => 'failed', 'label' => 'Failed', 'icon' => 'x-circle', 'description' => 'Encountered an error'],
        ];
    }

    public function render()
    {
        return view('livewire.select-demo');
    }
}
