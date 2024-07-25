<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreSportRequest;
use App\Http\Requests\Admin\UpdateSportRequest;
use App\Models\Sport;

class AdminSportsController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sports.index', [
            'sports' => Sport::query()->withCount('variants')->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSportRequest $request)
    {
        $validated = $request->validated();
        $validated['image'] = $request->file('image')?->store('sports', 'public');

        $successful = Sport::create($validated);

        if (! $successful) {
            return back()->with('error', __('Failed to create sport'));
        }

        return redirect(route('admin.sports.index'))->with('success', __('Sport created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Sport $sport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sport $sport)
    {
        return view('admin.sports.edit', [
            'sport' => $sport,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSportRequest $request, Sport $sport)
    {
        $validated = $request->validated();
        $validated['image'] = $request->file('image')?->store('sports', 'public') ?? $sport->getAttribute('image');
        $successful = $sport->update($validated);

        if (! $successful) {
            return back()->with('error', __('Failed to update sport'));
        }

        return redirect(route('admin.sports.index'))->with('success', __('Sport updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {
        //
    }
}
