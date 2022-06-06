<?php

namespace App\Providers;

use RiotAPI\RiotAPI;
use Illuminate\Support\ServiceProvider;

class RiotAPIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('RiotAPI', function ($app) {
            $api = new RiotAPI([
                RiotAPI::SET_KEY            => env('RIOT_API_KEY'),
                RiotAPI::SET_REGION         => env('RIOT_API_REGION'), // Replace it to $app->request->input('region');
            ]);

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
