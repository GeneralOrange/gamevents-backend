<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\RiotApi;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Summoner;
use App\Models\Game;

class SummonerController extends Controller
{   
    /**
     * Show all the available summoners
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $summoners = Cache::remember("summoners.all", now()->addMinute(), function(){
            return Summoner::with('user')->get();
        });

        return view('leaderboard', [
            'summoners' => $summoners
        ]);
    }

    /**
     * Show the profile for a given summoner.
     * 
     * @param object $summoner
     * @return \Illuminate\View\View
     */
    public function show(Summoner $summoner)
    {
        $matches = Cache::remember("summoner.{$summoner->id}", now()->addMinutes(15), function() use($summoner){
            return $this->getMatchList($summoner);
        });

        //$matches = $this->getMatchList($summoner);

        return view('summoner.profile', [
            'summoner' => $summoner,
            'matches' => $matches,
        ]);
    }

    /**
     * Handle an incoming api request for summoner to riot api
     * 
     * @param object $request
     * @return Illuminate\Support\Facades\Redirect
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
            'riot_account_id' => $summonerFetch->accountId,
            'icon_id' => $summonerFetch->profileIconId,
            'level' => $summonerFetch->summonerLevel
        ]);
    
        return redirect(RouteServiceProvider::HOME)->with('success', 'You succesfully added your Summoner!');
    }

    /**
     * Handle deleting a summoner
     * 
     * @return Illuminate\Support\Facades\Redirect
     */
    public function delete()
    {
        $user = Auth::user();

        Summoner::where('user_id', $user->id)->delete();

        return redirect(RouteServiceProvider::HOME)->with('success', 'You succesfully deleted your Summoner!');
    }

    /**
     * Fetch matchlist from RiotApi
     * 
     * @param object $summoner
     * @return array $matchList
     */
    public function getMatchList($summoner)
    {
        // $gameList = Game::whereHas('summoners', function($query) use($summoner)
        // {
        //     $query->where('id', $summoner->id);
        // })->get();
        $gameList = Game::all();
        $matchIds = array_slice(RiotApi::getMatchIdsByPUUID($summoner->riot_puuid), 0, 5);
        $remainingMatchIds = $matchIds;

        if(!$gameList->isEmpty()){
            $remainingMatchIds = array_filter($matchIds, function($matchId) use($gameList)
            {
                foreach($gameList as $game){
                    if($game->riot_match_id === $matchId) return false;
                }
                return true;
            });
            
        }
        
        return $this->getMatchDetails($remainingMatchIds, $summoner);
    }

    /**
     * Get the details of a matchlist
     * 
     * @param array $matchList
     * @param object $summoner
     * @return array $renderedMatches
     */
    public function getMatchDetails($matchList, $summoner)
    {
        $renderedMatches = array();

        foreach($matchList as $matchId){
            $matchDetails = RiotApi::getMatch($matchId);

            //dd($matchDetails);

            $game = new Game;
            $game->riot_match_id = $matchId;
            $game->riot_id = $matchDetails->info->gameId;
            $game->start = $matchDetails->info->gameStartTimestamp;
            $game->riot_map_id = $matchDetails->info->mapId;
            $game->creation = $matchDetails->info->gameCreation;
            $game->duration = $matchDetails->info->gameDuration;
            $game->save();

            $game->summoners()->attach($summoner->id);

            $renderedMatches[] = $this->filterMatchParticipants($matchDetails ,$summoner);
        }

        return $renderedMatches;
    }

    /**
     * Filter match participants by current summoner id
     * 
     * @param object $match
     * @param object $summoner
     * @return object $match
     */
    public function filterMatchParticipants($match, $summoner){
    
        $participants = $match->info->participants;

        $mainParticipant = array_filter($participants, function($participant) use($summoner){
            if(isset($participant->puuid)){
                if($participant->puuid != $summoner->riot_puuid) return false;
            }
            return true;
        });

        $match->info->mainParticipant = reset($mainParticipant);

        return $match;
    }

    public function getSummonerChampionMasteries($summonerId){
        return RiotApi::getChampionMasteries($summonerId);
    }

    public function getTotalKillsPerMatchList($matchList){
        $totalKills = 0;

        foreach($matchList as $match){
            $totalKills += $match->info->mainParticipant->kills;
        }

        return $totalKills;
    }
}
