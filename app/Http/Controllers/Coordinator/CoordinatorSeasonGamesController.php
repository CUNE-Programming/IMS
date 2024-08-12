<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Requests\Coordinator\StoreGameRequest;
use App\Models\Game;
use App\Models\Season;
use Illuminate\Http\Request;

class CoordinatorSeasonGamesController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Season $season)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Season $season)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request, Season $season)
    {
        $validated = $request->validated();
        $game = $season->games()->create($validated);

        return back()->with('success', __('Game created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season, Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Season $season, Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Season $season, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Season $season, Game $game)
    {
        //
    }
}
