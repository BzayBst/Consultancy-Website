<?php

namespace App\Livewire\Admin\Home;

use App\Models\HomePopupBanner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('admin.layouts.app')]
#[Title('Home Popup Banners')]
class HomePopupBanners extends Component
{
    use WithFileUploads;

    public array $photos = [];
    public string $title = '';
    public string $link_url = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(): void
    {
        $this->sort_order = (HomePopupBanner::max('sort_order') ?? 0) + 1;
    }

    public function save(): void
    {
        $this->validate([
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'title' => ['nullable', 'string', 'max:160'],
            'link_url' => ['nullable', 'url', 'max:500'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $order = $this->sort_order;

        foreach ($this->photos as $photo) {
            HomePopupBanner::create([
                'title' => $this->title ?: null,
                'image_path' => $photo->store('home-popups', 'public'),
                'link_url' => $this->link_url ?: null,
                'sort_order' => $order++,
                'is_active' => $this->is_active,
            ]);
        }

        $this->resetForm();
        session()->flash('success', 'Popup banner images uploaded successfully.');
    }

    public function toggleActive(int $id): void
    {
        $banner = HomePopupBanner::findOrFail($id);
        $banner->update(['is_active' => ! $banner->is_active]);
    }

    public function updateOrder(int $id, $value): void
    {
        HomePopupBanner::findOrFail($id)->update([
            'sort_order' => max(0, (int) $value),
        ]);
    }

    public function delete(int $id): void
    {
        $banner = HomePopupBanner::findOrFail($id);

        if (! Str::startsWith($banner->image_path, ['http://', 'https://']) && Storage::disk('public')->exists($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();
        session()->flash('success', 'Popup banner deleted.');
    }

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->photos = [];
        $this->title = '';
        $this->link_url = '';
        $this->sort_order = (HomePopupBanner::max('sort_order') ?? 0) + 1;
        $this->is_active = true;
    }

    public function render()
    {
        return view('livewire.admin.home.home-popup-banners', [
            'banners' => HomePopupBanner::ordered()->get(),
        ]);
    }
}
