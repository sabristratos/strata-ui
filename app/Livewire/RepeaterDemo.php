<?php

namespace App\Livewire;

use Livewire\Component;

class RepeaterDemo extends Component
{
    public array $contacts = [];

    public array $socialLinks = [];

    public array $features = [];

    public string $message = '';

    public function mount(): void
    {
        $this->contacts = [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '555-0100'],
        ];

        $this->socialLinks = [
            ['platform' => 'Twitter', 'url' => 'https://twitter.com/example'],
            ['platform' => 'GitHub', 'url' => 'https://github.com/example'],
        ];

        $this->features = [];
    }

    public function submitContacts(): void
    {
        $this->validate([
            'contacts' => 'required|array|min:1',
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.email' => 'required|email',
            'contacts.*.phone' => 'nullable|string',
        ]);

        $this->message = 'Contacts saved successfully!';
    }

    public function submitSocialLinks(): void
    {
        $this->validate([
            'socialLinks' => 'required|array',
            'socialLinks.*.platform' => 'required|string',
            'socialLinks.*.url' => 'required|url',
        ]);

        $this->message = 'Social links saved successfully!';
    }

    public function submitFeatures(): void
    {
        $this->validate([
            'features' => 'required|array|min:3|max:6',
            'features.*.title' => 'required|string|max:100',
        ]);

        $this->message = 'Features saved successfully!';
    }

    public function render()
    {
        return view('livewire.repeater-demo');
    }
}
