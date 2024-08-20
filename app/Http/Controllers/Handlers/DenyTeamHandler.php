<?php

namespace App\Http\Controllers\Handlers;

use App\Models\Season;
use App\Models\Team;
use Illuminate\Http\Request;

class DenyTeamHandler
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Season $season, Team $team)
    {
        $team->reject('Team denied by coordinator.');

        return redirect(route('seasons.teams.index', $season))->with('success', __('Team denied successfully.'));
    }
}
