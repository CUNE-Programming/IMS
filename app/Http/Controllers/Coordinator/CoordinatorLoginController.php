<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Requests\Auth\StoreLoginRequest;
use App\Models\User;

class CoordinatorLoginController
{
    /**
     * Show the login form for the coordinator.
     */
    public function create()
    {
        return view('coordinator.login.create');
    }

    /**
     * Send the login link to the user if they are a coordinator.
     */
    public function store(StoreLoginRequest $request)
    {
        $validated = $request->validated();
        $user = User::findByEmail($validated['email']);
        if (! $user->isCoordinator()) {
            return redirect()->route('coordinator.login.create')->with('error', __('You are not a coordinator.'));
        }

        $user->sendLoginMail('coordinator.login.show', config('app.debug'));

        return redirect()->route('coordinator.login.create')->with('success', __('Login link sent to your email.'));
    }

    /**
     * Login the user based on the signed URL.
     */
    public function show(User $user)
    {
        auth()->login($user);

        return redirect(route('coordinator.seasons.index'))->with('success', __('Logged in successfully.'));
    }

    /**
     * Logout the user
     */
    public function destroy()
    {
        auth()->logout();

        return redirect(route('coordinator.login.create'))->with('success', __('Logged out successfully.'));
    }
}
