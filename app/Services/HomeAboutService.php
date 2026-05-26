<?php

namespace App\Services;

use App\Models\HomeAbout;
use App\Repositories\Contracts\HomeAboutRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HomeAboutService
{
    public function __construct(
        protected HomeAboutRepositoryInterface $repo
    ) {}

    public function get(): ?HomeAbout
    {
        return $this->repo->get();
    }

    public function save(array $data, ?UploadedFile $image = null): HomeAbout
    {
        if ($image && $image->isValid()) {
            $old = $this->repo->get()?->image_path;
            if ($old && ! str_starts_with($old, 'http') && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $data['image_path'] = $image->store('home/about', 'public');
        }

        // Clean up perks and badges — remove empty entries
        if (isset($data['perks'])) {
            $data['perks'] = array_values(array_filter($data['perks'], fn($p) => trim($p) !== ''));
        }
        if (isset($data['badges'])) {
            $data['badges'] = array_values(array_filter($data['badges'], fn($b) => ! empty($b['label'])));
        }

        return $this->repo->save($data);
    }
}