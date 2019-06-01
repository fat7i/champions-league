<?php

namespace App\Tasks;

use App\Models\Season;
use App\Repositories\SeasonRepository;
use App\Repositories\TeamRepository;

class CalculateSeasonPredictionsTask implements TaskInterface
{

    /**
     * @var int
     */
    private $seasonId;

    /**
     * @var Season
     */
    private $season;

    /**
     * @var SeasonRepository
     */
    private $seasonRepository;

    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * @var array
     */
    private $indicators = [
        'strengths',
        'points'
    ];

    /**
     * CalculateSeasonPredictionsTask constructor.
     * @param SeasonRepository $seasonRepository
     * @param TeamRepository $teamRepository
     */
    public function __construct(SeasonRepository $seasonRepository, TeamRepository $teamRepository)
    {
        $this->seasonRepository = $seasonRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
     * @return array
     */
    public function run(): ?array
    {
        //TODO no predictions when Season end
        //TODO add "match" indicators: "calculate the chances of W/D/L for rest of matches"

        return $this->calculate();
    }

    /**
     * @return array
     */
    private function calculate(): ?array
    {
        $data = $this->prepareTeamsInfo();

        $result = [];
        foreach ($data['teams'] as $team) {
            $output = [];
            $percentageArr = [];
            $output['name'] = $team['name'];

            if (in_array('strengths', $this->indicators)) {
                $percentageArr['strengths'] = $this->calcStrengths($team['strengths'], $data['total_teams_strengths']);
            }

            if (in_array('points', $this->indicators) && $data['total_teams_points']>0) {
                $percentageArr['points'] = $this->calcPoints($team['points'], $data['total_teams_points']);
            }

            if ($percentageArr) {
                $output['percentage'] = $this->calcTotalPercentage($percentageArr);
            }

            $result[] = $output;
        }

        usort($result, [$this, 'sort']);

        return $result;
    }

    /**
     * @param array $percentages
     * @return float
     */
    private function calcTotalPercentage(array $percentages): float
    {
        $totalIndicators = count($percentages) * 100;

        $totalPercentages = array_sum($percentages);

        return  round((($totalPercentages) / $totalIndicators) * 100, 2);
    }


    /**
     * @return mixed
     */
    private function prepareTeamsInfo(): array
    {
        $teams = $this->season->leagueTable;

        $output['total_teams']  = (int) $this->season->leagueTable->count();


        $totalTeamsStrengths = 0;
        $totalTeamsPoints = 0;

        $teamsInfo = [];

        foreach ($teams as $team) {
            $teamArray = [];

            $teamArray['name'] = $team->team->name;

            $teamArray['strengths'] = $team->team->strengths;
            $totalTeamsStrengths += $teamArray['strengths'];

            $teamArray['points'] = $team->points;
            $totalTeamsPoints += $teamArray['points'];

            $teamsInfo[] = $teamArray;
        }

        $output['total_teams_strengths'] = $totalTeamsStrengths;
        $output['total_teams_points'] = $totalTeamsPoints;
        $output['teams'] = $teamsInfo;


        return $output;
    }

    /**
     * @param int $seasonId
     * @return CalculateSeasonPredictionsTask
     */
    public function setSeasonId(int $seasonId): CalculateSeasonPredictionsTask
    {
        $this->seasonId = $seasonId;
        $this->setSeason($seasonId);
        return $this;
    }

    /**
     * @param int $seasonId
     */
    private function setSeason(int $seasonId): void
    {
        $this->season = $this->seasonRepository->find($seasonId);
    }

    /**
     * @param int $strengths
     * @param int $totalTeamsStrengths
     * @return float
     */
    private function calcStrengths(int $strengths, int $totalTeamsStrengths = 1): float
    {
        return round(($strengths / $totalTeamsStrengths) * 100, 2);
    }

    /**
     * @param int $points
     * @param int $totalTeamsPoints
     * @return float
     */
    private function calcPoints(int $points, int $totalTeamsPoints = 1): float
    {
        return round(($points / $totalTeamsPoints) * 100, 2);
    }

    /**
     * @param $a
     * @param $b
     * @return int
     */
    private function sort($a, $b)
    {
        if ($a["percentage"] == $b["percentage"]) {
            return 0;
        }
        return ($a["percentage"] > $b["percentage"]) ? -1 : 1;
    }
}
