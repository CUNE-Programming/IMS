<?php

namespace App\Http\Controllers\Handlers;

use App\Models\Season;
use App\Models\Team;
use Illuminate\Http\Request;

class ApproveTeamHandler
{
    public function __invoke(Request $request, Season $season, Team $team)
    {
        $team->approve();

        return redirect(route('seasons.teams.index', $season))->with('success', __('Team approved successfully.'));
    }
}
