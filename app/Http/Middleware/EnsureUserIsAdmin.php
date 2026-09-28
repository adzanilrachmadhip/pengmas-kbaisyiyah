<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Gate every /admin/* route behind both an authenticated session and
     * the 'access-admin' Gate (defined in AppServiceProvider from
     * users.is_admin — auth:web alone isn't enough).
     */
    public function handle(Request $request, Closure $next): Response
    {
        Gate::authorize('access-admin');

        return $next($request);
    }
}
