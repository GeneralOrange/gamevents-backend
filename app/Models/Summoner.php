<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summoner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'slug',
        'name',
        'riot_puuid',
        'riot_id',
        'riot_account_id',
        'icon_id',
        'level'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
