<?php

namespace App\Http\Controllers\Handlers;

use App\Models\Game;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostponeGameHandler
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Season $season, Game $game)
    {
        $validated = $request->validate([
            'postpone_date' => ['required', 'date'],
            'postpone_time' => ['required', 'date_format:H:i'],
        ]);

        $postponed_at = Carbon::parse($validated['postpone_date'])->setTimeFrom($validated['postpone_time']);

        // Postpone the game
        $game->postpone($postponed_at);

        return redirect(route('seasons.games.index', $season))->with('success', __('Game postponed successfully.'));
    }
}
