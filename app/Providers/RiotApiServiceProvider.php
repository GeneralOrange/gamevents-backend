<?php

/**
 * Made with https://medium.com/@onezac/laravel-riotapi-part-1-80571c194d91
 */

namespace App\Providers;
//namespace RiotAPI;

use Illuminate\Support\ServiceProvider;
use RiotAPI\LeagueAPI\LeagueAPI as LeagueAPILeagueAPI;

class RiotApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('RiotApi', function ($app) {
            $api = 'test';
            // dd(new LeagueAPILeagueAPI);
            // $api = new RiotAPI([
            //     RiotAPI::SET_KEY            => env('RIOT_API_KEY'),
            //     RiotAPI::SET_REGION         => env('RIOT_API_REGION'), // Replace it to $app->request->input('region');
            // ]);

            //dd(env('RIOT_API_KEY'));

            return $api;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
