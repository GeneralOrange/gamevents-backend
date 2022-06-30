<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Summoner;

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
}
