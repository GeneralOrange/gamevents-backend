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
        Schema::create('summoners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->string('riot_puuid')->unique();
            $table->string('riot_id')->unique();
            $table->string('riot_account_id')->unique();
            $table->string('icon_id');
            $table->string('level');
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
        Schema::dropIfExists('summoners');
    }
};
