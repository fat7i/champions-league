<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('season_id')->unsigned();
            $table->foreign('season_id')
                ->references('id')->on('seasons');

            $table->bigInteger('team_id')->unsigned();
            $table->foreign('team_id')
                ->references('id')->on('teams');

            $table->unique(['season_id', 'team_id'], 'season_team');

            $table->integer('played')->unsigned()->default(0);
            $table->integer('won')->unsigned()->default(0);
            $table->integer('drawn')->unsigned()->default(0);
            $table->integer('lost')->unsigned()->default(0);
            $table->integer('goals_for')->default(0);
            $table->integer('goals_against')->default(0);
            $table->integer('points')->unsigned()->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leagues');
    }
}
