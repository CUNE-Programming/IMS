<?php

use App\Http\Middleware\RedirectIfAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\actingAs;

it('redirects the user if they are not an admin', function () {
    $middleware = new RedirectIfAdmin;
    $request = new Request;
    $request->setUserResolver(fn () => null);
    $response = $middleware->handle($request, fn () => new Response);
    expect($response->getStatusCode())->toBe(302);
    expect($response->isRedirect())->toBeTrue();
});

it('allows the user to continue if they are an admin', function () {
    $middleware = new RedirectIfAdmin;
    $request = new Request;
    $user = User::factory()->admin()->create();
    actingAs($user);
    $response = $middleware->handle($request, fn () => new Response);
    expect($response->getStatusCode())->toBe(200);
});
