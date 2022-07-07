<?php

/**
 * Made with https://medium.com/@onezac/laravel-riotapi-part-1-80571c194d91
 */

namespace App\Providers;
//namespace RiotAPI;

use Illuminate\Support\ServiceProvider;
use RiotAPI\LeagueAPI\LeagueAPI;
use RiotAPI\Base\Definitions\Region;

class RiotApiServiceProvider extends ServiceProvider
{
    //$RIOT_API_REGION = env('RIOT_API_REGION');

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('RiotApi', function ($app) {
            $api = new LeagueAPI([
                LeagueAPI::SET_KEY            => env('RIOT_API_KEY'),
                LeagueAPI::SET_REGION         => Region::EUROPE_WEST, // Replace it to $app->request->input('region')
            ]);

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
