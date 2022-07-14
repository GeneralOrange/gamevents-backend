<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameSummonerPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_summoner', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id')->index();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->unsignedBigInteger('summoner_id')->index();
            $table->foreign('summoner_id')->references('id')->on('summoners')->onDelete('cascade');
            $table->primary(['game_id', 'summoner_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_summoner');
    }
}
