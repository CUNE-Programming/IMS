<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

class ProfileController
{
    /**
     * Show the current user's profile's edit form.
     */
    public function edit(Request $request)
    {
        return view('profiles.edit', [
            'user' => $request->user()
        ]);
    }

    /**
     * Update the current user's profile.
     */
    public function update(UpdateUserRequest $request)
    {
        $request->user()->update($request->validated());
        return back()->with('success', 'Profile updated.');
    }

    /**
     * Delete the current user.
     */
    public function destroy(Request $request)
    {
        $request->user()->delete();
        return redirect()->route('login')->with('success', 'User deleted.');
    }
}
