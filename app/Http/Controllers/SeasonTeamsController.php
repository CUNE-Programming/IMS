<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Mail\PlayerInvitation;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeasonTeamsController
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $season)
    {
        $season = Season::query()->with('teams')->withCoordinatorStatus(auth()->user())->findOrFail($season);

        return view('seasons.teams.index', ['season' => $season]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, int $season)
    {
        $season = Season::query()->withMaxTeamSize()->findOrFail($season);
        return view('seasons.teams.create', ['season' => $season]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request, Season $season)
    {
        $captain = $request->user();
        $validated = $request->safe()['team'];
        $validated['season_id'] = $season->id;
        $team = Team::createWithCaptain($validated, $captain);
        foreach ($request->safe()['players'] as $player) {
            Mail::to($player)->send(new PlayerInvitation($team, $player));
        }

        return redirect(route('seasons.show', $season))->with('success', __('Team created successfully. Your players have been invited to join.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $season, Team $team)
    {
        $season = Season::query()->withCoordinatorStatus(auth()->user())->findOrFail($season);

        return view('seasons.teams.show', ['season' => $season, 'team' => $team]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Season $season, Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Season $season, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Season $season, Team $team)
    {
        //
    }
}
