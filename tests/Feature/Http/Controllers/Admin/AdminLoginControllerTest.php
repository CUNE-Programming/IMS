<?php

use App\Mail\Auth\LoginMail;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

describe('Login Controller Test', function () {

    it('should return a view for the login form', function () {
        $response = get('admin/login');

        $response->assertViewIs('admin.login.create');
    });

    it('should send an email to login an admin', function () {
        Mail::fake();
        $user = User::factory()->create(['is_admin' => true]);

        $response = post('admin/login', ['email' => $user->email]);

        $response->assertRedirect('admin/login')->assertSessionHas('success', 'Login link sent to your email.');
        Mail::assertQueued(LoginMail::class);
    });

    it('should redirect with an error if the user is not an admin', function () {
        $user = User::factory()->create(['is_admin' => false]);

        $response = post('admin/login', ['email' => $user->email]);

        $response->assertRedirect('admin/login')->assertSessionHas('error', 'You are not an admin.');
        assertGuest();
    });

    it('should login an admin', function () {
        /** @var User */
        $user = User::factory()->createOne(['is_admin' => true]);
        $loginUrl = URL::temporarySignedRoute('admin.login.show', now()->addHour(), Arr::wrap($user));

        $response = get($loginUrl);

        $response->assertRedirect(route('admin.coordinators.index'))->assertSessionHas('success', 'Logged in successfully.');
        assertAuthenticatedAs($user);
    });

    it('should logout an admin', function () {
        $user = User::factory()->createOne(['is_admin' => true]);
        $loginUrl = URL::temporarySignedRoute('admin.login.show', now()->addHour(), Arr::wrap($user));
        get($loginUrl);

        $response = delete('admin/logout');

        $response->assertRedirect('admin/login')->assertSessionHas('success', 'Logged out successfully.');
        assertGuest();
    });
});
