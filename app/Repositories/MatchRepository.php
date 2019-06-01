<?php

namespace App\Repositories;

use App\Models\Match;

class MatchRepository
{
    /**
     * @var Match
     */
    private $model;

    /**
     * MatchRepository constructor.
     * @param Match $match
     */
    public function __construct(Match $match)
    {
        $this->model = $match;
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
        return $this->model->create(
            $home_team_id,
            $away_team_id,
            $season_id,
            $week_id,
            $home_team_score,
            $home_team_points,
            $away_team_score,
            $away_team_points,
            $isPlayed
        );
    }

    /**
     * @param int $id
     * @return array|bool
     */
    public function play(int $id): array
    {
        $result = $this->model->play($id);
        if ($result) {
            return $result->toArray();
        }

        return false;
    }
}
