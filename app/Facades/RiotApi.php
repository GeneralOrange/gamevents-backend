<?php

/**
 * Made with https://medium.com/@onezac/laravel-riotapi-part-1-80571c194d91
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;  

class RiotApi extends Facade 
{
    protected static function getFacadeAccessor () {
        return 'RiotApi';
    }
}