<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class InputTextareaDemo extends Component
{
    public $basicInput = '';
    public $emailInput = '';
    public $passwordInput = '';
    public $searchInput = '';
    public $numberInput = '';
    public $telInput = '';
    public $urlInput = '';

    public $inputSm = '';
    public $inputMd = '';
    public $inputLg = '';

    public $inputDefault = '';
    public $inputSuccess = 'valid@email.com';
    public $inputError = '';
    public $inputWarning = 'check@example';

    public $iconLeftInput = '';
    public $iconRightInput = '';
    public $iconBothInput = '';

    public $currencyInput = '';
    public $urlPrefixInput = '';
    public $domainInput = '';
    public $measurementInput = '';
    public $percentageInput = '';

    public $clearableInput = 'Clear me!';

    public $disabledInput = 'Cannot edit this';

    public $allFeaturesInput = 'Full example';

    public $basicTextarea = '';
    public $commentTextarea = '';
    public $descriptionTextarea = '';
    public $messageTextarea = '';

    public $textareaSm = '';
    public $textareaMd = '';
    public $textareaLg = '';

    public $textareaDefault = '';
    public $textareaSuccess = 'This content looks great!';
    public $textareaError = '';
    public $textareaWarning = 'This might need review';

    public $resizeNone = '';
    public $resizeVertical = '';
    public $resizeHorizontal = '';
    public $resizeBoth = '';

    public $charCountTextarea = '';

    #[Validate('required|min:3')]
    public $formName = '';

    #[Validate('required|email')]
    public $formEmail = '';

    #[Validate('required')]
    public $formPhone = '';

    #[Validate('nullable|url')]
    public $formWebsite = '';

    #[Validate('nullable|numeric|min:0')]
    public $formBudget = '';

    #[Validate('required|min:10|max:500')]
    public $formMessage = '';

    public $formSubmitted = null;

    public function submitForm()
    {
        $this->validate();

        $this->formSubmitted = "Thank you, {$this->formName}! Your message has been received.";

        $this->reset(['formName', 'formEmail', 'formPhone', 'formWebsite', 'formBudget', 'formMessage']);
    }

    public function resetForm()
    {
        $this->reset(['formName', 'formEmail', 'formPhone', 'formWebsite', 'formBudget', 'formMessage', 'formSubmitted']);
        $this->resetValidation();
    }

    public function resetAll()
    {
        $this->reset();
        $this->resetValidation();

        $this->inputSuccess = 'valid@email.com';
        $this->inputWarning = 'check@example';
        $this->textareaSuccess = 'This content looks great!';
        $this->textareaWarning = 'This might need review';
        $this->clearableInput = 'Clear me!';
        $this->disabledInput = 'Cannot edit this';
        $this->allFeaturesInput = 'Full example';
    }

    public function render()
    {
        return view('livewire.input-textarea-demo');
    }
}
