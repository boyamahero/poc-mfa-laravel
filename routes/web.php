<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\KeycloakController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

/** Facebook OAuth routes */
// Route::get('/auth/facebook/redirect', [FacebookController::class, 'handleFacebookRedirect'])->name('login.facebook');
// Route::get('/auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

/** Keycloak OAuth routes */
Route::get('/auth/keycloak/redirect', [KeycloakController::class, 'handleKeycloakRedirect'])->name('login.keycloak');
Route::get('/auth/keycloak/callback', [KeycloakController::class, 'handleKeycloakCallback']);
