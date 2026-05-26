<?php

namespace App\Http\Controllers;

use App\Services\VentureService;
use Illuminate\View\View;

class VentureController extends Controller
{
    public function __construct(protected VentureService $service) {}

    public function index(): View
    {
        $ventures = $this->service->allActive();
        $featured = $ventures->where('is_featured', true)->first() ?? $ventures->first();
        $portfolio = $ventures->reject(fn ($v) => $v->is($featured));

        return view('pages.ventures', compact('ventures', 'featured', 'portfolio'));
    }

    public function show(string $slug): View
    {
        $venture = $this->service->findBySlug($slug);
        $otherVentures = $this->service->allActive()
            ->reject(fn ($v) => $v->is($venture))
            ->take(3);

        return view('pages.venture-detail', compact('venture', 'otherVentures'));
    }
}
