<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('home_team_id')->unsigned();
            $table->foreign('home_team_id')
                ->references('id')->on('teams');

            $table->integer('home_team_score')->unsigned()->default(0);
            $table->integer('home_team_points')->unsigned()->default(0);

            $table->bigInteger('away_team_id')->unsigned();
            $table->foreign('away_team_id')
                ->references('id')->on('teams');

            $table->integer('away_team_score')->unsigned()->default(0);
            $table->integer('away_team_points')->unsigned()->default(0);

            $table->bigInteger('season_id')->unsigned();
            $table->foreign('season_id')
                ->references('id')->on('seasons');

            $table->bigInteger('week_id')->unsigned();
            $table->foreign('week_id')
                ->references('id')->on('weeks');

            $table->tinyInteger('is_played')->unsigned()->default(0);

            $table->unique(['home_team_id', 'away_team_id', 'week_id', 'season_id'], 'unique_match_in_season');

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
        Schema::dropIfExists('matches');
    }
}
