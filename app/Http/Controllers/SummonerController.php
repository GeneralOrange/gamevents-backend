<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Summoner;
use App\Facades\RiotApi;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;

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
        $summonerId = $summoner->id;

        $matches = Cache::remember("summoner.{$summonerId}", now()->addMinutes(5), function() use($summoner){
            return $this->getMatchList($summoner);
        });

        return view('summoner.profile', [
            'summoner' => $summoner,
            'matches' => $matches
        ]);
    }

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
            'riot_puuid' => $summonerFetch->puuid,
            'riot_id' => $summonerFetch->id,
            'riot_account_id' => $summonerFetch->accountId
        ]);
    
        return redirect(RouteServiceProvider::HOME)->with('success', 'You succesfully added your Summoner!');
    }

    /**
     * Handle deleting a summoner
     */
    public function delete(Request $request)
    {
        $user = Auth::user();

        Summoner::where('user_id', $user->id)->delete();

        return redirect(RouteServiceProvider::HOME)->with('success', 'You succesfully deleted your Summoner!');
    }

    /**
     * Fetch matchlist from RiotApi
     */
    public function getMatchList($summoner)
    {
        $matchList = $this->getMatchDetails(RiotApi::getMatchIdsByPUUID($summoner->riot_puuid));

        return $matchList;
    }


    public function getMatchDetails($matchList)
    {
        $renderedMatches = array();

        foreach($matchList as $matchId){
            $renderedMatches[] = RiotApi::getMatch($matchId);
        }

        return $renderedMatches;
    }
}
