<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;

class AdminUsersController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        if (! $user) {
            return back(303)->with('error', __('Failed to create user'));
        }

        return back(303)->with('success', __('User created successfully'));
    }
}
