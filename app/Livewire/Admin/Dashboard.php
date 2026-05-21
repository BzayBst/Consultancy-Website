<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('admin.layouts.app')]
#[Title('Dashboard – HASU Admin')]
class Dashboard extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.dashboard', [
            'admin' => auth('admin')->user(),
        ]);
    }
}