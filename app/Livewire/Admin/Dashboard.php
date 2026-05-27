<?php

namespace App\Livewire\Admin;

use App\Models\BlogPost;
use App\Models\Course;
use App\Models\Event;
use App\Models\GalleryImage;
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
             'admin'        => auth('admin')->user(),
            'blogCount'    => BlogPost::count(),
            'courseCount'  => Course::count(),
            'eventCount'   => Event::count(),
            'galleryCount' => GalleryImage::count(),
        ]);
    }
}