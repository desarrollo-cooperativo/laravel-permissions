<?php

namespace Cardumen\LaravelPermissions\Middleware;


use Closure;

class LaravelPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route_name = $request->route()->getName();
        if(!$request->user()->routeAllowed($route_name)){
            abort(401,'Acceso no autorizado');
        }
        return $next($request);
    }
}
