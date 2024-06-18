<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeasonRequest;
use App\Http\Requests\UpdateSeasonRequest;
use App\Models\Season;
use App\Models\Sport;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $seasons = Season::query()->filterBySportName($request->query('sport', ''))->get();
        $sports = Sport::all();

        return view('seasons.index', [
            'seasons' => $seasons,
            'sports' => $sports,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return <<<'HTML'
        <h1>Hello from Create</h1>
        HTML;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeasonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season)
    {
        return view('seasons.show', [
            'season' => $season->load('sport'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Season $season)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeasonRequest $request, Season $season)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Season $season)
    {
        //
    }
}
