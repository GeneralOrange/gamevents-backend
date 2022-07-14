<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Summoner;
use App\Models\Team;
use App\Models\GameStats;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $gaurded = [];

    public function summoners()
    {
        return $this->belongsToMany(Summoner::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function gamestats()
    {
        return $this->hasMany(GameStats::class);
    }
}
