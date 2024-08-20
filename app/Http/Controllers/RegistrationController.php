<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegistrationController
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('registration.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistrationRequest $request)
    {
        $user = User::create($request->safe());

        // $user->sendEmailVerificationNotification();

        Auth::login($user);

        return redirect(route('seasons.index'))->with('success', __('You have successfully registered! Please check your email to confirm your registration.'));
    }
}
