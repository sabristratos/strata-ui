<?php

namespace App\Livewire;

use Livewire\Component;
use Stratos\StrataUI\Strata;

class ToastDemo extends Component
{
    public function showSuccessToast(): void
    {
        Strata::toast($this)->success('Success!', 'Your changes have been saved successfully.');
    }

    public function showErrorToast(): void
    {
        Strata::toast($this)->error('Error!', 'Something went wrong. Please try again.');
    }

    public function showWarningToast(): void
    {
        Strata::toast($this)->warning('Warning!', 'This action cannot be undone.');
    }

    public function showInfoToast(): void
    {
        Strata::toast($this)->info('Info', 'This is an informational message.');
    }

    public function showPersistentToast(): void
    {
        Strata::toast($this)->show([
            'variant' => 'success',
            'title' => 'Persistent Toast',
            'description' => 'This toast will not auto-dismiss.',
            'duration' => 0,
        ]);
    }

    public function render()
    {
        return view('livewire.toast-demo');
    }
}
