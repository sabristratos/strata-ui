<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class PopoverDemo extends Component
{
    public int $notificationCount = 3;
    public string $quickNote = '';
    public bool $noteSubmitted = false;
    public bool $darkModeEnabled = false;
    public bool $notificationsEnabled = true;
    public bool $emailUpdates = false;
    public ?string $selectedColor = null;
    public ?string $selectedAction = null;
    public bool $itemDeleted = false;
    public string $username = 'John Doe';
    public string $email = 'john@example.com';

    public function submitQuickNote(): void
    {
        $this->validate([
            'quickNote' => 'required|min:3',
        ]);

        $this->noteSubmitted = true;
        $this->quickNote = '';

        $this->dispatch('note-submitted');
    }

    public function clearNotifications(): void
    {
        $this->notificationCount = 0;
    }

    public function deleteItem(): void
    {
        $this->itemDeleted = true;
        $this->selectedAction = null;
    }

    public function selectColor(string $color): void
    {
        $this->selectedColor = $color;
    }

    public function toggleDarkMode(): void
    {
        $this->darkModeEnabled = !$this->darkModeEnabled;
    }

    public function toggleNotifications(): void
    {
        $this->notificationsEnabled = !$this->notificationsEnabled;
    }

    public function toggleEmailUpdates(): void
    {
        $this->emailUpdates = !$this->emailUpdates;
    }

    public function resetDemo(): void
    {
        $this->reset([
            'notificationCount',
            'quickNote',
            'noteSubmitted',
            'selectedColor',
            'selectedAction',
            'itemDeleted',
            'darkModeEnabled',
            'notificationsEnabled',
            'emailUpdates',
        ]);
    }

    public function getNotifications(): array
    {
        if ($this->notificationCount === 0) {
            return [];
        }

        return [
            ['id' => 1, 'text' => 'New comment on your post', 'time' => '5 min ago'],
            ['id' => 2, 'text' => 'Your profile was viewed 12 times', 'time' => '1 hour ago'],
            ['id' => 3, 'text' => 'System maintenance scheduled', 'time' => '2 hours ago'],
        ];
    }

    public function getColors(): array
    {
        return [
            ['value' => 'red', 'hex' => '#ef4444'],
            ['value' => 'orange', 'hex' => '#f97316'],
            ['value' => 'yellow', 'hex' => '#eab308'],
            ['value' => 'green', 'hex' => '#22c55e'],
            ['value' => 'blue', 'hex' => '#3b82f6'],
            ['value' => 'purple', 'hex' => '#a855f7'],
            ['value' => 'pink', 'hex' => '#ec4899'],
            ['value' => 'gray', 'hex' => '#6b7280'],
        ];
    }

    public function getUserActions(): array
    {
        return [
            ['value' => 'profile', 'label' => 'View Profile', 'icon' => 'user'],
            ['value' => 'settings', 'label' => 'Settings', 'icon' => 'settings'],
            ['value' => 'billing', 'label' => 'Billing', 'icon' => 'credit-card'],
            ['value' => 'logout', 'label' => 'Logout', 'icon' => 'log-out'],
        ];
    }

    public function render()
    {
        return view('livewire.popover-demo', [
            'notifications' => $this->getNotifications(),
            'colors' => $this->getColors(),
            'userActions' => $this->getUserActions(),
        ]);
    }
}
