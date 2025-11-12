<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.rtl')]
class RtlShowcase extends Component
{
    public string $fullName = '';

    public string $email = '';

    public string $password = '';

    public string $website = '';

    public string $price = '';

    public string $search = '';

    public string $country = '';

    public array $tags = [];

    public string $birthDate = '';

    public string $appointmentDate = '';

    public array $dateRange = [];

    public string $appointmentTime = '';

    public string $themeColor = '#3b82f6';

    public string $backgroundColor = '#ffffff';

    public string $mobilePhone = '';

    public string $bio = '';

    public string $notes = '';

    public array $countries = [];

    public function mount(): void
    {
        $this->countries = [
            [
                'code' => 'US',
                'name' => __('select.country_us'),
                'dialCode' => '+1',
                'flag' => 'us',
            ],
            [
                'code' => 'GB',
                'name' => __('select.country_uk'),
                'dialCode' => '+44',
                'flag' => 'gb',
            ],
            [
                'code' => 'SA',
                'name' => __('select.country_sa'),
                'dialCode' => '+966',
                'flag' => 'sa',
            ],
            [
                'code' => 'AE',
                'name' => __('select.country_ae'),
                'dialCode' => '+971',
                'flag' => 'ae',
            ],
            [
                'code' => 'EG',
                'name' => __('select.country_eg'),
                'dialCode' => '+20',
                'flag' => 'eg',
            ],
        ];
    }

    public function switchLocale(string $locale): void
    {
        session(['locale' => $locale]);
        $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.rtl-showcase');
    }
}
