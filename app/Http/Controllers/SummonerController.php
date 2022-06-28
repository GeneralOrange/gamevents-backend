<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Summoner;

class SummonerController extends Controller
{
    /**
     * Show the profile for a given summoner.
     * 
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        return view('summoner.profile', [
            'summoner' => Summoner::findOrFail($slug)
        ]);
    }
}
