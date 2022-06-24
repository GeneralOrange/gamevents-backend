<?php

use Illuminate\Support\Facades\Route;
//use RiotAPI\BaseAPI;

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

Route::get('/leaderboard', function () {
    //dd(new BaseAPI);
    //$api = new RiotAPI;
    // $summoner = $api->getSummonerByName('General Orange');
    //RiotApi::getSummonerByName('General Orange');
    $api = app()->make('RiotApi');
    dd($api);
    
    return view('leaderboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
