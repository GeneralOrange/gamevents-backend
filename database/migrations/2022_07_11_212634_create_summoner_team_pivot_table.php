<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummonerTeamPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summoner_team', function (Blueprint $table) {
            $table->unsignedBigInteger('summoner_id')->index();
            $table->foreign('summoner_id')->references('id')->on('summoners')->onDelete('cascade');
            $table->unsignedBigInteger('team_id')->index();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->primary(['summoner_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('summoner_team');
    }
}
