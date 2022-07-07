<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Summoner;
use App\Facades\RiotApi;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Route;

class SummonerController extends Controller
{   
    /**
     * Show all the available summoners
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('leaderboard', [
            'summoners' => Summoner::with('user')->get()
        ]);
    }

    /**
     * Show the profile for a given summoner.
     * 
     * @param string $summoner
     * @return \Illuminate\View\View
     */
    public function show(Summoner $summoner)
    {
        return view('summoner.profile', [
            'summoner' => $summoner
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255', 'unique:summoners']
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect(RouteServiceProvider::HOME);
    // }

    /**
     * Handle an incoming api request for summoner to riot api
     */
    public function findInApi(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:summoners,name']
        ]);

        $user = Auth::user();

        $summonerFetch = RiotApi::getSummonerByName($request->name);

        Summoner::create([
            'user_id' => $user->id,
            'slug' => strtolower(str_replace(' ', '-', $summonerFetch->name)),
            'name' => $summonerFetch->name,
            'riot_uuid' => $summonerFetch->id
        ]);
    
        return redirect(RouteServiceProvider::HOME)->with('success', 'You succesfully added your Summoner!');
    }
}
