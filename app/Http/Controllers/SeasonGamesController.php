<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SeasonGamesController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Season $season)
    {
        return view('seasons.games.index', ['season' => $season, 'games' => $season->games()->orderBy('scheduled_at')->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Season $season)
    {
        return view('seasons.games.create', ['season' => $season]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request, Season $season)
    {
        $validated = $request->safe()->toArray();
        $validated['season_id'] = $season->id;
        $validated['scheduled_at'] = Carbon::parse($validated['scheduled_date'])->setTimeFrom($validated['scheduled_time']);
        unset($validated['scheduled_date'], $validated['scheduled_time']);
        $game = Game::createWithTeams($validated['teams'], $validated);

        return redirect(route('seasons.games.index', $season))->with('success', __('Game created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season, Game $game)
    {
        return view('seasons.games.show', ['season' => $season, 'game' => $game->load('teams')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Season $season, Game $game)
    {
        return view('seasons.games.edit', ['season' => $season, 'game' => $game->load('teams')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameRequest $request, Season $season, Game $game)
    {
        $validated = $request->safe()->toArray();
        $score_records = collect($validated['teams'])->map(fn($record) => [$record['id'], $record['score']]);

        if($game->recordAsPlayed($score_records)) {
            return redirect(route('seasons.games.index', $season))->with('success', __('Game results recorded successfully.'));
        }

        return back()->with('error', __('Failed to record game results.'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Season $season, Game $game)
    {
        if($game->cancel()) {
            return redirect(route('seasons.games.index', $season))->with('success', __('Game cancelled successfully.'));
        }

        return back()->with('error', __('Failed to cancel game.'));
    }
}
