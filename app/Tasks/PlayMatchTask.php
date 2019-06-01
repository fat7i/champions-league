<?php

namespace App\Tasks;

use App\Models\League;
use App\Repositories\LeagueRepository;
use App\Repositories\MatchRepository;

/**
 * Class PlayMatchTask
 * @package App\Tasks
 */
class PlayMatchTask implements TaskInterface
{
    /**
     * @var MatchRepository
     */
    private $matchRepository;

    /**
     * @var LeagueRepository
     */
    private $leagueRepository;

    /**
     * @var int
     */
    private $matchId;

    /**
     * PlayMatchTask constructor.
     * @param MatchRepository $matchRepository
     * @param LeagueRepository $leagueRepository
     */
    public function __construct(MatchRepository $matchRepository, LeagueRepository $leagueRepository)
    {
        $this->matchRepository = $matchRepository;
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @return array
     */
    public function run(): ?array
    {
        $result = $this->matchRepository->play($this->matchId);

        // update league table
        if ($result) {
            $this->updateLeagueTable($result);
        }

        return $result;
    }

    /**
     * @param mixed $matchId
     * @return PlayMatchTask
     */
    public function setMatchId(int $matchId): PlayMatchTask
    {
        $this->matchId = $matchId;
        return $this;
    }

    /**
     * @param array $match
     */
    private function updateLeagueTable(array $match)
    {
        $homeWon = 0;
        $homeDrawn = 0;
        $homeLost = 0;

        $awayWon = 0;
        $awayDrawn = 0;
        $awayLost = 0;


        if ($match['home_team_points'] > $match['away_team_points']) {
            //homeWon
            $homeWon = 1;
            $awayLost = 1;
        } elseif ($match['home_team_points'] < $match['away_team_points']) {
            //awayWon
            $awayWon = 1;
            $homeLost = 1;
        } else {
            //drawn
            $homeDrawn = 1;
            $awayDrawn = 1;
        }

        $season_id = $match['season_id'];

        //update home team
        $this->updateTeamInLeagueTable(
            $season_id,
            $match['home_team_id'],
            $homeWon,
            $homeDrawn,
            $homeLost,
            $match['home_team_score'],
            $match['away_team_score'],
            $match['home_team_points']
        );


        //update away team
        $this->updateTeamInLeagueTable(
            $season_id,
            $match['away_team_id'],
            $awayWon,
            $awayDrawn,
            $awayLost,
            $match['away_team_score'],
            $match['home_team_score'],
            $match['away_team_points']
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
    private function updateTeamInLeagueTable(
        int $season_id,
        int $team_id,
        int $won,
        int $drawn,
        int $lost,
        int $goalsFor,
        int $goalsAgainst,
        int $points
    ): League {
        return $this->leagueRepository->updateTeam(
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
