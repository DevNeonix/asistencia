<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Closure;

class UserIsLoginMiddleware
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
        if (empty(Session::get('usuario'))) {
            return redirect()->to(route('login'));
        }
        return $next($request);
    }
}
