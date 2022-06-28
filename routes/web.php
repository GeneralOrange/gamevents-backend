<?php

use App\Http\Controllers\SummonerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Summoner;

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
    //dd(new BaseAPI);
    //$api = new RiotAPI;
    // $summoner = $api->getSummonerByName('General Orange');
    //RiotApi::getSummonerByName('General Orange');
    $api = app()->make('RiotApi');
    
    return view('leaderboard', [
        'api' => $api,
        'summoners' => Summoner::with('user')->get()
    ]);
});

Route::get('/user/{id}', [UserController::class, 'show']);

//Route::get('/summoner/{summoner:slug}', [SummonerController::class, 'show']);
Route::get('/summoner/{summoner:slug}', function(Summoner $summoner){
    return view('summoner.profile', [
        'summoner' => $summoner
    ]); 
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
