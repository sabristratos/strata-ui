<?php

namespace App\Livewire;

use Livewire\Component;

class PhoneInputDemo extends Component
{
    public $phone = '+14155552671';

    public $countries = [
        ['code' => 'US', 'name' => 'United States', 'dialCode' => '+1', 'flag' => 'us'],
        ['code' => 'GB', 'name' => 'United Kingdom', 'dialCode' => '+44', 'flag' => 'gb'],
        ['code' => 'CA', 'name' => 'Canada', 'dialCode' => '+1', 'flag' => 'ca'],
        ['code' => 'AU', 'name' => 'Australia', 'dialCode' => '+61', 'flag' => 'au'],
        ['code' => 'DE', 'name' => 'Germany', 'dialCode' => '+49', 'flag' => 'de'],
        ['code' => 'FR', 'name' => 'France', 'dialCode' => '+33', 'flag' => 'fr'],
        ['code' => 'IT', 'name' => 'Italy', 'dialCode' => '+39', 'flag' => 'it'],
        ['code' => 'ES', 'name' => 'Spain', 'dialCode' => '+34', 'flag' => 'es'],
        ['code' => 'MX', 'name' => 'Mexico', 'dialCode' => '+52', 'flag' => 'mx'],
        ['code' => 'BR', 'name' => 'Brazil', 'dialCode' => '+55', 'flag' => 'br'],
        ['code' => 'JP', 'name' => 'Japan', 'dialCode' => '+81', 'flag' => 'jp'],
        ['code' => 'CN', 'name' => 'China', 'dialCode' => '+86', 'flag' => 'cn'],
        ['code' => 'IN', 'name' => 'India', 'dialCode' => '+91', 'flag' => 'in'],
        ['code' => 'NL', 'name' => 'Netherlands', 'dialCode' => '+31', 'flag' => 'nl'],
        ['code' => 'BE', 'name' => 'Belgium', 'dialCode' => '+32', 'flag' => 'be'],
        ['code' => 'CH', 'name' => 'Switzerland', 'dialCode' => '+41', 'flag' => 'ch'],
        ['code' => 'SE', 'name' => 'Sweden', 'dialCode' => '+46', 'flag' => 'se'],
        ['code' => 'NO', 'name' => 'Norway', 'dialCode' => '+47', 'flag' => 'no'],
        ['code' => 'DK', 'name' => 'Denmark', 'dialCode' => '+45', 'flag' => 'dk'],
        ['code' => 'FI', 'name' => 'Finland', 'dialCode' => '+358', 'flag' => 'fi'],
    ];

    public function submit()
    {
        $this->validate([
            'phone' => 'required|string',
        ]);

        session()->flash('message', 'Phone number saved: '.$this->phone);
    }

    public function resetPhone()
    {
        $this->phone = '+14155552671';
        session()->forget('message');
    }

    public function render()
    {
        return view('livewire.phone-input-demo');
    }
}
