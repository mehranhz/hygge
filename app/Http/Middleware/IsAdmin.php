<?php

namespace App\Http\Middleware;

use App\Exceptions\ServiceCallException;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->isAdmin()){
            return $next($request);
        }
        throw new AuthorizationException("you don't have access to this resource.");
    }
}
