<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $redirect = '/admin/login'): Response
    {
        if (! auth()->user()?->is_admin) {
            return redirect($redirect)->with('error', __('You do not have permission to access this page.'));
        }

        return $next($request);
    }
}
