<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class SidebarDemo extends Component
{
    public $currentPage = 'dashboard';

    public function setPage($page)
    {
        $this->currentPage = $page;
    }

    public function render()
    {
        return view('livewire.sidebar-demo');
    }
}
