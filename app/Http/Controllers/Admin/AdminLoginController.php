<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Auth\StoreLoginRequest;
use App\Models\User;

class AdminLoginController
{
    /**
     * Display the login form for the admin.
     */
    public function create()
    {
        return view('admin.login.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoginRequest $request)
    {
        $validated = $request->validated();
        $user = User::findByEmail($validated['email']);
        if (! $user->is_admin) {
            return redirect()->route('admin.login.create')->with('error', __('You are not an admin.'));
        }

        $user->sendLoginMail('admin.login.show', env('APP_DEBUG'));

        return redirect()->route('admin.login.create')->with('success', __('Login link sent to your email.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        auth()->login($user);

        return redirect(route('admin.coordinators.index'))->with('success', __('Logged in successfully.'));
    }

    /**
     * Logout the user.
     */
    public function destroy()
    {
        auth()->logout();

        return redirect(route('admin.login.create'))->with('success', __('Logged out successfully.'));
    }
}
