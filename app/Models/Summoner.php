<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Game;
use App\Models\Team;
use App\Models\GameStats;

class Summoner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $gaurded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsToMany(Game::class);
    }

    public function team()
    {
        return $this->belongsToMany(Team::class);
    }

    public function gamestats()
    {
        return $this->hasMany(GameStats::class);
    }
}
