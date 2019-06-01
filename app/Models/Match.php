<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Match extends Model
{
    /**
     *
     */
    const HOME_SUPPORT = 3;

    /**
     *
     */
    const WIN_POINTS = 3;

    /**
     *
     */
    const DRAW_POINTS = 1;

    /**
     *
     */
    const LOSE_POINTS = 0;

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'matches';

    /**
     * @var array
     */
    protected $fillable = [
        'home_team_id',
        'home_team_score',
        'home_team_points',
        'away_team_id',
        'away_team_score',
        'away_team_points',
        'season_id',
        'week_id',
        'is_played',
    ];

    /**
     * @var array
     */
    public static $rules = [
        'home_team_id' => 'required',
        'away_team_id' => 'required',
        'season_id' => 'required',
        'week_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $with = ['home', 'away'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season()
    {
        return $this->belongsTo('App\Models\Season', 'season_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function home()
    {
        return $this->belongsTo('App\Models\Team', 'home_team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function away()
    {
        return $this->belongsTo('App\Models\Team', 'away_team_id');
    }

    /**
     * @param int $home_team_id
     * @param int $away_team_id
     * @param int $season_id
     * @param int $week_id
     * @param int $home_team_score
     * @param int $home_team_points
     * @param int $away_team_score
     * @param int $away_team_points
     * @param int $isPlayed
     * @return Match
     */
    public function create(
        int $home_team_id,
        int $away_team_id,
        int $season_id,
        int $week_id,
        int $home_team_score = 0,
        int $home_team_points = 0,
        int $away_team_score = 0,
        int $away_team_points = 0,
        int $isPlayed = 0
    ): Match {

        $match = new static();
        $match->home_team_id = $home_team_id;
        $match->home_team_score = $home_team_score;
        $match->home_team_points = $home_team_points;

        $match->away_team_id = $away_team_id;
        $match->away_team_score = $away_team_score;
        $match->away_team_points = $away_team_points;

        $match->season_id = $season_id;
        $match->week_id = $week_id;
        $match->is_played = $isPlayed;


        $match->save();

        return $match;
    }

    /**
     * @param $id
     * @return Match|bool
     */
    public function play(int $id): ?Match
    {
        $match = self::findOrFail($id);

        if ($match->is_played==0) {
            if ($match->home->strengths + self::HOME_SUPPORT > $match->away->strengths) {
                return $this->setMatchResult(
                    $id,
                    rand(3, 6),
                    self::WIN_POINTS,
                    rand(0, 2),
                    self::LOSE_POINTS
                );
            } elseif ($match->home->strengths + self::HOME_SUPPORT == $match->away->strengths) {
                $score = rand(0, 6);

                return $this->setMatchResult(
                    $id,
                    $score,
                    self::DRAW_POINTS,
                    $score,
                    self::DRAW_POINTS
                );
            } else {
                return $this->setMatchResult(
                    $id,
                    rand(0, 2),
                    self::LOSE_POINTS,
                    rand(6, 3),
                    self::WIN_POINTS
                );
            }
        }//-- is played

        return false;
    }


    /**
     * @param int $match_id
     * @param int $home_team_score
     * @param int $home_team_points
     * @param int $away_team_score
     * @param int $away_team_points
     * @return Match
     */
    private function setMatchResult(
        int $match_id,
        int $home_team_score = 0,
        int $home_team_points = 0,
        int $away_team_score = 0,
        int $away_team_points = 0
    ): Match {

        $match = self::findOrFail($match_id);

        $match->home_team_score = $home_team_score;
        $match->home_team_points = $home_team_points;


        $match->away_team_score = $away_team_score;
        $match->away_team_points = $away_team_points;

        $match->is_played = 1;


        $match->save();

        return $match;
    }
}
