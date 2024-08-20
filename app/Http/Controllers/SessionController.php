<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SessionController
{
    /**
     * Show the Login Form
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::findByEmail($validated['email']);

        $user?->sendLoginMail('sessions.show', config('app.debug'));

        return back()->with('success', 'Check your email for the login link.');
    }

    /**
     * Verify the email signature and authenticate the user.
     */
    public function show(Request $request, User $user)
    {
        auth()->login($user);
        return redirect()->intended(route('seasons.index'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy()
    {
        auth()->logout();
        return redirect()->route('sessions.create');
    }
}
