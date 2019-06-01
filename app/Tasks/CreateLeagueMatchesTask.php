<?php

namespace App\Tasks;

use App\Repositories\MatchRepository;
use App\Repositories\WeekRepository;
use Illuminate\Database\Eloquent\Collection;
use ScheduleBuilder;

class CreateLeagueMatchesTask implements TaskInterface
{
    /**
     * @var MatchRepository
     */
    private $matchRepository;

    /**
     * @var WeekRepository
     */
    private $weekRepository;

    /**
     * @var int
     */
    private $season_id;

    /**
     * @var array
     */
    private $teams;

    /**
     * CreateLeagueMatchesTask constructor.
     * @param MatchRepository $matchRepository
     * @param WeekRepository $weekRepository
     */
    public function __construct(MatchRepository $matchRepository, WeekRepository $weekRepository)
    {
        $this->matchRepository = $matchRepository;
        $this->weekRepository = $weekRepository;
    }

    /**
     * @return mixed|void
     */
    public function run(): void
    {
        $teams = $this->teams->shuffle()->toArray();

        $rounds = (($count = count($teams)) % 2 === 0 ? $count - 1 : $count) * 2;
        $scheduleBuilder = new ScheduleBuilder($teams, $rounds);
        $schedule = $scheduleBuilder->build();

        foreach ($schedule as $week_number => $weekMatches) {
            // create week
            $week = $this->weekRepository->create($this->season_id, $week_number);

            foreach ($weekMatches as $match) {
                $this->matchRepository->create(
                    $match[0]['id'],
                    $match[1]['id'],
                    $this->season_id,
                    $week->id
                );
            }
        }
    }

    /**
     * @param int $season_id
     * @return CreateLeagueMatchesTask
     */
    public function setSeasonId(int $season_id): CreateLeagueMatchesTask
    {
        $this->season_id = $season_id;
        return $this;
    }

    /**
     * @param $teams
     * @return CreateLeagueMatchesTask
     */
    public function setTeams(Collection $teams): CreateLeagueMatchesTask
    {
        $this->teams = $teams;
        return $this;
    }
}