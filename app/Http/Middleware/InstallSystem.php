<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class InstallSystem
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            if (User::all()->isEmpty()) {
                return redirect()->route('install');
            }

        }catch (\Exception $e) {
            return redirect()->route('install');
        }

        return redirect('login');
    }
}
