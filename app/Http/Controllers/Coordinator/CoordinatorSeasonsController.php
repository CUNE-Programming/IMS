<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Requests\Coordinator\StoreSeasonRequest;
use App\Models\Season;
use App\Models\Variant;
use Illuminate\Http\Request;

class CoordinatorSeasonsController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $seasons = Season::query()->whereActive()->whereHas('variant', fn ($query) => $query->coordinatorFor($request->user()))->get();

        return view('coordinator.seasons.index', [
            'seasons' => $seasons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('coordinator.seasons.create', [
            'variants' => Variant::query()->coordinatorFor($request->user())->doesNotHaveActiveSeason()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeasonRequest $request)
    {
        $validated = $request->validated();
        $season = Season::create($validated);

        return redirect()->route('coordinator.seasons.show', $season)->with('success', __('Season created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season)
    {
        return view('coordinator.seasons.show', [
            'season' => $season->loadCount(['teams', 'freeAgents']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Season $season)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Season $season)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Season $season)
    {
        //
    }
}
