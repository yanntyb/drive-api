<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        ds($request->user->roles);
        return $next($request);
    }
}
