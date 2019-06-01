<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class League extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'leagues';

    /**
     * @var array
     */
    protected $fillable = [
        'season_id',
        'team_id',
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
        'points'
    ];

    /**
     * @var array
     */
    public static $rules = [
        'season_id' => 'required',
        'team_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo('App\Models\Team', 'team_id');
    }

    /**
     * @param int $season_id
     * @param int $team_id
     * @param int $played
     * @param int $won
     * @param int $drawn
     * @param int $lost
     * @param int $goalsFor
     * @param int $goalsAgainst
     * @param int $points
     * @return League
     */
    public function create(
        int $season_id,
        int $team_id,
        int $played = 0,
        int $won = 0,
        int $drawn = 0,
        int $lost = 0,
        int $goalsFor = 0,
        int $goalsAgainst = 0,
        int $points = 0
    ): League {

        $league = new static();
        $league->season_id = $season_id;
        $league->team_id = $team_id;
        $league->played = $played;
        $league->won = $won;
        $league->drawn = $drawn;
        $league->lost = $lost;
        $league->goals_for = $goalsFor;
        $league->goals_against = $goalsAgainst;
        $league->points = $points;

        $league->save();

        return $league;
    }

    /**
     * @param int $season_id
     * @param int $team_id
     * @param int $won
     * @param int $drawn
     * @param int $lost
     * @param int $goalsFor
     * @param int $goalsAgainst
     * @param int $points
     * @return League
     */
    public function updateTeam(
        int $season_id,
        int $team_id,
        int $won = 0,
        int $drawn = 0,
        int $lost = 0,
        int $goalsFor = 0,
        int $goalsAgainst = 0,
        int $points = 0
    ): League {

        $league = self::where('season_id', $season_id)->where('team_id', $team_id)->first();

        $league->season_id = $season_id;
        $league->team_id = $team_id;
        $league->played = $league->played + 1;
        $league->won = $league->won + $won;
        $league->drawn = $league->drawn + $drawn;
        $league->lost = $league->lost + $lost;
        $league->goals_for = $league->goals_for + $goalsFor;
        $league->goals_against = $league->goals_against + $goalsAgainst;
        $league->points = $league->points + $points;

        $league->save();

        return $league;
    }
}
