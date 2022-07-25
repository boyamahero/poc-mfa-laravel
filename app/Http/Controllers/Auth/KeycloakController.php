<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;

class KeycloakController extends Controller
{
    CONST DRIVER_TYPE = 'keycloak';

    public function handleKeycloakRedirect()
    {
        return Socialite::driver(static::DRIVER_TYPE)->redirect();
    }

    public function handleKeycloakCallback()
    {
        $user = Socialite::driver(static::DRIVER_TYPE)->user();

        $user = User::firstOrCreate([
            'email' => $user->email
        ], [
            'name' => $user->name,
            'password' => Hash::make(Str::random(24)),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout()
    {
        Auth::logout(); // Logout of your app

        $redirectUri = Config::get('app.url').'/dashboard'; // The URL the user is redirected to

        return redirect(Socialite::driver('keycloak')->getLogoutUrl($redirectUri)); // Redirect to Keycloak
    }
}
