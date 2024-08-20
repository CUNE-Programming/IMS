<?php

namespace App\Http\Controllers;

use App\Models\FreeAgent;
use App\Models\Season;
use Illuminate\Http\Request;

class SeasonFreeAgentsController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Season $season)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $season->freeAgents()->create([
            'user_id' => $validated['user_id'],
        ]);

        return redirect(route('seasons.show', $season->id))->with('success', 'You have successfully registered as a free agent for this season.');
    }
}
