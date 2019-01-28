<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeckLeagueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deck_league', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deck_id');
            $table->integer('league_id');
            $table->integer('wins')->default(0);
            $table->integer('losses')->default(0);
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
        Schema::dropIfExists('deck_league');
    }
}
