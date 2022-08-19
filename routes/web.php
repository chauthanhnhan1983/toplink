<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/auth/twitter', [App\Http\Controllers\Social\TwitterController::class, 'redirectToTwitter'])->name('auth.twitter');
Route::get('/auth/twitter/callback', [App\Http\Controllers\Social\TwitterController::class, 'handleTwitterCallback'])->name('auth.twitter_callback');
Route::get('/twitter/calculating', [App\Http\Controllers\Social\TwitterController::class, 'calculating'])->name('twitter_calculating');
