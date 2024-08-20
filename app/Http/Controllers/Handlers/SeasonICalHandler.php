<?php

namespace App\Http\Controllers\Handlers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonICalHandler
{
    public function __invoke(Request $request, Season $season)
    {
        return response($season->getICalStream())
                ->header('Content-Type', 'text/calendar; charset=utf-8');
    }
}
