<?php

namespace App\Http\Controllers;

use Bouncer;
use App\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class InstallSystemController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, \Closure $next) {

            if (User::all()->isNotEmpty()) {
                return redirect('home');
            }

            return $next($request);
        });
    }

    public function index()
    {
        if (Role::all()->isNotEmpty()) {
            return redirect()->route('install.admin');
        }

        return view('install.index');
    }

    public function installDatabase()
    {
        try{
            Artisan::call('migrate:refresh');
            Artisan::call('db:seed');
        }catch (\Exception $e) {}

        return redirect()->route('install.admin');
    }

    public function createAdmin()
    {
        if (Role::all()->isEmpty()) {
            return redirect()->route('install');
        }

        return view('install.create_user');
    }

    public function storeAdmin()
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
        ]);

        Bouncer::assign('admin')->to($user);

        auth()->login($user);

        return redirect('/home');
    }
}
