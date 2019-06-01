<?php

namespace App\Repositories;

use App\Models\League;

class LeagueRepository
{
    /**
     * @var League
     */
    private $model;

    /**
     * MatchRepository constructor.
     * @param League $league
     */
    public function __construct(League $league)
    {
        $this->model = $league;
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

        return $this->model->create(
            $season_id,
            $team_id,
            $played,
            $won,
            $drawn,
            $lost,
            $goalsFor,
            $goalsAgainst,
            $points
        );
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

        return $this->model->updateTeam(
            $season_id,
            $team_id,
            $won,
            $drawn,
            $lost,
            $goalsFor,
            $goalsAgainst,
            $points
        );
    }
}
