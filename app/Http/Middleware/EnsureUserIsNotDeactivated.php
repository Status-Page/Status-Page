<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class EnsureUserIsNotDeactivated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()){
            if($request->user()->deactivated){
                // throw new UserDeactivatedException();
                abort(423, 'User deactivated');
            }
        }

        return $next($request);
    }
}
