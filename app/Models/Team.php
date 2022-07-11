<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Game;
use App\Models\Summoner;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $gaurded = [];

    public function game()
    {
        $this->belongsTo(Game::class);
    }

    public function summoner()
    {
        $this->belongsToMany(Summoner::class);
    }
}
