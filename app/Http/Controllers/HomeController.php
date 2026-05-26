<?php

namespace App\Http\Controllers;

use App\Services\AboutService;
use App\Services\TeamService;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function about(AboutService $aboutService, TeamService $teamService)
    {
        return view('pages.about', [
            'aboutHero' => $aboutService->getHero(),
            'aboutStory' => $aboutService->getStory(),
            'aboutMilestones' => $aboutService->getMilestones()
                ->where('is_active', true)
                ->values(),
            'aboutStats' => $aboutService->getStats()
                ->where('is_active', true)
                ->values(),
            'aboutMvCards' => $aboutService->getMvCards()
                ->where('is_active', true)
                ->values(),
            'teams' => $teamService->all(),
        ]);
    }
}
