<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id');
            $table->integer('riot_team_id');
            $table->boolean('win');
            $table->boolean('baron_first');
            $table->boolean('champion_first');
            $table->boolean('dragon_first');
            $table->boolean('inhib_first');
            $table->boolean('rift_herald_first');
            $table->boolean('tower_first');
            $table->integer('baron_kills');
            $table->integer('champion_kills');
            $table->integer('dragon_kills');
            $table->integer('inhib_kills');
            $table->integer('rift_herald_kills');
            $table->integer('tower_kills');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
};
