<?php

namespace App\Http\Middleware;

use App\Events\ActionLog;
use Closure;
use Illuminate\Http\Request;

class APIActionLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $path = preg_replace('/api\/v[0-9]*\//', '', $request->route()->uri());

        if($request->user()){
            $action = ['GET', 'POST', 'PUT', 'DELETE'];

            ActionLog::dispatch(array(
                'user' => $request->user()->id,
                'type' => array_search($request->method(), $action),
                'message' => 'API Request: '.ucfirst($path).' | Full URI: '.$request->getRequestUri(),
            ));
        }

        return $next($request);
    }
}
