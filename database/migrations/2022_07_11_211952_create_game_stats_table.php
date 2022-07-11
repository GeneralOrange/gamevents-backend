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
        Schema::create('game_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id');
            $table->foreignId('summoner_id');
            $table->boolean('win');
            $table->integer('kills');
            $table->integer('assists');
            $table->integer('deaths');
            $table->integer('baron_kills');
            $table->string('lane');
            $table->string('champion_name');
            $table->integer('double_kills');
            $table->integer('triple_kills');
            $table->integer('quadra_kills');
            $table->integer('penta_kills');
            $table->bigInteger('magic_damage');
            $table->bigInteger('physical_damage');
            $table->bigInteger('true_damage');
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
        Schema::dropIfExists('game_stats');
    }
};
