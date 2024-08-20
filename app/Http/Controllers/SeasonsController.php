<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeasonRequest;
use App\Models\Season;
use App\Models\Variant;
use Illuminate\Http\Request;

class SeasonsController
{
    /**
     * List all active seasons on the platform.
     */
    public function index(Request $request)
    {
        $seasons = Season::query()->whereActive()->withCoordinatorStatus($request->user())->with('variant')->get();

        return view('seasons.index', [
            'seasons' => $seasons,
        ]);
    }

    /**
     * Create a new Season.
     * This is restricted for coordinators or admins.
     */
    public function create(Request $request)
    {
        $variants = Variant::query()->coordinatorFor($request->user())->doesNotHaveActiveSeason()->get();
        return view('seasons.create', [
            'variants' => $variants,
        ]);
    }

    /**
     * Store the new Season.
     * This is restricted for coordinators or admins.
     */
    public function store(StoreSeasonRequest $request)
    {
        $season = Season::create($request->validated()["season"]);
        return redirect()->route('seasons.show', $season->id)->with('success', 'Season created successfully.');
    }

    /**
     * Display the current details for the season, such as:
     * - # of Teams
     * - # of Free Agents
     * - The top 5 teams
     * - Registration Period, Start Date, and End Date
     */
    public function show(Request $request, int $season)
    {
        $season = Season::query()->withCount(['teams', 'freeAgents'])->with('games')->withCoordinatorStatus($request->user())->findOrFail($season);
        $seasons = Season::query()->whereActive()->withCoordinatorStatus($request->user())->with('variant')->get();
        return response()->view('seasons.show', [
            'season' => $season,
            'seasons' => $seasons,
        ],
        headers: ['HX-Push-Url' => route('seasons.show', $season->id)]);
    }
}
