<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Allow the request only when the authenticated user has one of the
     * given roles, e.g. `role:admin` or `role:admin,staff`.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles, true)) {
            abort(403, 'Akses ditolak untuk peran Anda.');
        }

        return $next($request);
    }
}
