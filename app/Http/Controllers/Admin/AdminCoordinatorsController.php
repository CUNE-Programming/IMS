<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DeleteCoordinatorRequest;
use App\Http\Requests\Admin\StoreCoordinatorRequest;
use App\Models\Coordinator;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Http\Request;

class AdminCoordinatorsController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coordinators = User::query()->whereCoordinator()->with(['coordinators', 'coordinators.variant'])->paginate(15);

        return view('admin.coordinators.index', [
            'coordinators' => $coordinators,
        ]);
    }

    public function create()
    {
        $variants = Variant::query()->withCount('coordinators')->get();
        $variants = $variants->flatMap(fn ($variant) => [$variant->id => "$variant->name ($variant->coordinators_count)"])->flatten();
        $users = User::query()->withCount('coordinators')->get();
        $users = $users->flatMap(fn ($user) => [$user->id => "$user->name ($user->coordinators_count)"])->flatten();
        return view('admin.coordinators.create', [
            'variants' => $variants,
            'users' => $users,
        ]);
    }

    public function store(StoreCoordinatorRequest $request)
    {
        $validated = $request->validated();

        if (Coordinator::where('user_id', $validated['user_id'])->where('variant_id', $validated['variant_id'])->exists()) {
            return back()->with('error', __('Coordinator already exists'));
        }

        Coordinator::create($validated);

        return redirect(route('admin.coordinators.index'))->with('success', __('Coordinator created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Coordinator $coordinator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coordinator $coordinator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coordinator $coordinator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCoordinatorRequest $request)
    {
        $validated = $request->validated();

        Coordinator::query()->whereIn('id', $validated['coordinator_id'])->delete();

        return back(303)->with('success', __("Successfully removed the user as coordinator"));
    }
}
