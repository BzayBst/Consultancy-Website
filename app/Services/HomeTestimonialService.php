<?php

namespace App\Services;

use App\Models\HomeTestimonial;

class HomeTestimonialService
{
    public function get(): ?HomeTestimonial
    {
        return HomeTestimonial::first();
    }

    public function save(array $data): HomeTestimonial
    {
        if (isset($data['testimonials'])) {
            $data['testimonials'] = collect($data['testimonials'])
                ->map(fn ($testimonial) => [
                    'quote' => trim($testimonial['quote'] ?? ''),
                    'name' => trim($testimonial['name'] ?? ''),
                    'role' => trim($testimonial['role'] ?? ''),
                    'avatar' => trim($testimonial['avatar'] ?? ''),
                    'rating' => max(1, min(5, (int) ($testimonial['rating'] ?? 5))),
                ])
                ->filter(fn ($testimonial) => $testimonial['quote'] !== '' || $testimonial['name'] !== '')
                ->values()
                ->all();
        }

        $record = HomeTestimonial::firstOrNew(['id' => 1]);
        $record->fill($data)->save();

        return $record->fresh();
    }
}
