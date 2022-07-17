<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Summoner;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $erik = User::create([
            'name' => 'Erik',
            'email' => 'erik@erik.com',
            'password' => bcrypt('password')
        ]);
        
        $dylan = User::create([
            'name' => 'Dylan',
            'email' => 'dylan@dylan.com',
            'password' => bcrypt('password')
        ]);

        $jarno = User::create([
            'name' => 'Jarno',
            'email' => 'jarno@jarno.com',
            'password' => bcrypt('password')
        ]);

        Summoner::create([
            'user_id' => $erik->id,
            'name' => 'General Orange',
            'slug' => 'general-orange'
        ]);

        Summoner::create([
            'user_id' => $dylan->id,
            'name' => 'Xîght',
            'slug' => 'xight'
        ]);

        Summoner::create([
            'user_id' => $jarno->id,
            'name' => 'Mr xerioNN',
            'slug' => 'mr-xerionn'
        ]);
    }
}
