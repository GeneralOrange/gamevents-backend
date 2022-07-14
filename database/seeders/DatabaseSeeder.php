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
        User::create([
            'name' => 'Erik',
            'email' => 'erik@erik.com',
            'password' => bcrypt('password')
        ]);
        
        User::create([
            'name' => 'Dylan',
            'email' => 'dylan@dylan.com',
            'password' => bcrypt('password')
        ]);
        //Summoner::create();
    }
}
