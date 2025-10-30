<?php

namespace App\Livewire;

use Livewire\Component;

class ModalDemo extends Component
{
    public bool $showModal = false;
    public bool $showFlyout = false;
    public string $name = '';
    public string $email = '';
    public string $message = '';

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function openFlyout(): void
    {
        $this->showFlyout = true;
    }

    public function closeFlyout(): void
    {
        $this->showFlyout = false;
    }

    public function submitForm(): void
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);

        $this->closeModal();

        $this->name = '';
        $this->email = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.modal-demo');
    }
}
