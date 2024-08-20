<?php

namespace App\Http\Controllers\Handlers;

use App\Models\Season;
use App\Models\User;
use Illuminate\Http\Request;

class GetPlayersForSelectHandler
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Season $season)
    {
        $email = $request->get('email');

        $players = User::query()
            ->where('email', 'like', "%$email%")
            ->whereDoesntHave('teams', fn ($query) => $query->where('season_id', $season->id))
            ->orWhereDoesntHave('freeAgents', fn ($query) => $query->where('season_id', $season->id))
            ->get();

        return response()
                ->json(
                    $players->map(
                        fn (User $player) => [
                                    'text' => "$player->name <$player->email>",
                                    'value' => $player->email
                                ]
                    )
                );
    }
}
