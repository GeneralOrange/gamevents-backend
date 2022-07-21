<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\RiotApi;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Summoner;
use App\Models\Game;
use App\Models\GameStats;
use Illuminate\Support\Carbon;

class SummonerController extends Controller
{   
    /**
     * Show all the available summoners
     * @return \Illuminate\View\View
     */
    public function index()
    {   
        $summoners = Cache::remember("summoners.all", now()->addSeconds(10), function(){
            return Summoner::with('gamestats')
                ->get()
                ->sortByDesc(function($summoner)
                {
                    return $summoner->gamestats()->sum('kills');
                });
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
            return $this->initMatchList($summoner);
        });
        
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
    public function initMatchList($summoner)
    {
        $gameList = Game::whereHas('summoners', function($query) use($summoner)
        {
            $query->where('id', $summoner->id);
        })->get();

        $matchIds = RiotApi::getMatchIdsByPUUID($summoner->riot_puuid);

        if(!$gameList->isEmpty()){
            foreach($gameList as $game){
                $search = array_search($game->riot_match_id, $matchIds);
                if($search !== false){
                    unset($matchIds[$search]);
                }
            }
        }
        
        return $this->getMatchList($matchIds, $summoner);
    }

    /**
     * Get the details of a matchlist
     * 
     * @param array $matchList
     * @param object $summoner
     * @return array $renderedMatches
     */
    public function getMatchList($matchList, $summoner)
    {
        if(count($matchList) >= 1){
            foreach($matchList as $matchId){
                $this->saveMatch($matchId, $summoner);
            }
        }
        
        return GameStats::where('summoner_id', $summoner->id)
            ->get()
            ->sortByDesc(function($gamestats)
            {
                return $gamestats->game->creation;
            });
    }

    public function fetchMatchDetails($matchId)
    {
        return RiotApi::getMatch($matchId);
    }

    public function saveMatch($matchId, $summoner)
    {
        $matchDetails = $this->filterMatchParticipants($this->fetchMatchDetails($matchId), $summoner);

        $game = Game::where('riot_match_id', $matchId)->first();
        
        if(!$game){
            $game = new Game;
            $game->riot_match_id = $matchId;
            $game->riot_id = $matchDetails->info->gameId;
            $game->riot_map_id = $matchDetails->info->mapId;
            $game->start = Carbon::createFromTimestampMs($matchDetails->info->gameStartTimestamp)->toDateTimeString();
            $game->creation = Carbon::createFromTimestampMs($matchDetails->info->gameCreation)->toDateTimeString();
            $game->duration = Carbon::parse($matchDetails->info->gameDuration)->format('H:i:s');
            $game->save();
        }

        $game->summoners()->attach($summoner->id);

        GameStats::create([
            'game_id' => $game->id,
            'summoner_id' => $summoner->id,
            'win' => $matchDetails->info->mainParticipant->win,
            'kills' => $matchDetails->info->mainParticipant->kills,
            'assists' => $matchDetails->info->mainParticipant->assists,
            'deaths' => $matchDetails->info->mainParticipant->deaths,
            'baron_kills' => $matchDetails->info->mainParticipant->baronKills,
            'lane' => $matchDetails->info->mainParticipant->lane,
            'champion_name' => $matchDetails->info->mainParticipant->championName,
            'double_kills' => $matchDetails->info->mainParticipant->doubleKills,
            'triple_kills' => $matchDetails->info->mainParticipant->tripleKills,
            'quadra_kills' => $matchDetails->info->mainParticipant->quadraKills,
            'penta_kills' => $matchDetails->info->mainParticipant->pentaKills,
            'magic_damage' => $matchDetails->info->mainParticipant->magicDamageDealt,
            'physical_damage' => $matchDetails->info->mainParticipant->physicalDamageDealt,
            'true_damage' => $matchDetails->info->mainParticipant->trueDamageDealt,
        ]);
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

    public function getTotalKills($matchList){
        $totalKills = 0;

        foreach($matchList as $match){
            $totalKills += $match->info->mainParticipant->kills;
        }

        return $totalKills;
    }
}
