<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvitationController
{
    public function show(Team $team, string $email)
    {
        if(($user = User::findByEmail($email))?->exists) {
            if($team->players->contains($user)) {
                return redirect(route('seasons.show', $team->season));
            }
            if($team->teamCaptain->is($user)) {
                return redirect(route('seasons.show', $team->season));
            }
            if($user->isFreeAgentIn($team->season)) {
                $team->pickUpFreeAgent($user->freeAgents()->where('season_id', $team->season_id)->first());
            }
            $team->players()->attach($user);

            return redirect(route('seasons.show', $team->season));
        } else {
            // Return a custom registration form for the user to sign up
            $user = new User(['email' => $email]);
            return view('invitations.show', ['team' => $team, 'user' => $user]);
        }
    }

    public function update(RegistrationRequest $request, Team $team)
    {
        DB::transaction(function () use ($request, $team) {
            $user = User::create($request->safe()->toArray());
            $team->players()->attach($user);
        });

        return redirect(route('seasons.show', $team->season));
    }
}
