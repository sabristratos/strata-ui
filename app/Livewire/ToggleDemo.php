<?php

namespace App\Livewire;

use Livewire\Component;

class ToggleDemo extends Component
{
    public bool $enabled = false;

    public bool $notifications = true;

    public bool $darkMode = false;

    public bool $emailAlerts = false;

    public bool $autoSave = true;

    public string $message = '';

    public function mount(): void
    {
        $this->message = '';
    }

    public function submit(): void
    {
        $this->message = 'Settings saved! Notifications: '.($this->notifications ? 'Enabled' : 'Disabled');
    }

    public function render()
    {
        return view('livewire.toggle-demo');
    }
}
