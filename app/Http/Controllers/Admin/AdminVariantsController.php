<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVariantRequest;
use App\Http\Requests\Admin\UpdateVariantRequest;
use App\Models\Sport;
use App\Models\Variant;

class AdminVariantsController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.variants.index', [
            'variants' => Variant::query()->withCount(['coordinators', 'seasons'])->with(['seasons', 'sport'])->withHasActiveSeason()->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sports = Sport::query()->withCount('variants')->get();
        $sports = $sports->map(function ($sport) {
            return literal(
                id: $sport->id,
                name: "{$sport->name} ({$sport->variants_count})",
            );
        });

        return view('admin.variants.create', [
            'sports' => $sports,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantRequest $request)
    {
        $validated = $request->validated();
        $successful = Variant::create($validated);

        if (! $successful) {
            return back()->with('error', __('Failed to create variant'));
        }

        return redirect(route('admin.variants.index'))->with('success', __('Variant created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Variant $variant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variant $variant)
    {
        return view('admin.variants.edit', [
            'variant' => $variant->load(['seasons', 'coordinators']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantRequest $request, Variant $variant)
    {
        $validated = $request->validated();
        $successful = $variant->update($validated);

        if (! $successful) {
            return back()->with('error', __('Failed to update variant'));
        }

        return redirect(route('admin.variants.index'))->with('success', __('Variant updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variant $variant)
    {
        //
    }
}
