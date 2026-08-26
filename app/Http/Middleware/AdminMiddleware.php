<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response
    {
        $user = $request->user();

        if (
            ! $user instanceof User
            || ! $user->is_admin
        ) {
            abort(
                403,
                'Nincs jogosultságod az oldal megtekintéséhez.'
            );
        }

        return $next($request);
    }
}