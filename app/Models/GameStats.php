<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Summoner;
use App\Models\Game;

class GameStats extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $gaurded = [];

    public function summoner()
    {
        $this->belongsTo(Summoner::class);
    }

    public function game()
    {
        $this->belongsTo(Game::class);
    }
}
