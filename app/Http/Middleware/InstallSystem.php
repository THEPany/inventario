<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class InstallSystem
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
        try{
            if (User::all()->isEmpty()) {
                return redirect()->route('install');
            }

        }catch (\Exception $e) {
            return redirect()->route('install');
        }

        return $next($request);
    }
}
