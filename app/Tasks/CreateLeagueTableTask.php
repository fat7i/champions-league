<?php

namespace App\Tasks;

use App\Repositories\LeagueRepository;
use Illuminate\Support\Collection;

class CreateLeagueTableTask implements TaskInterface
{

    /**
     * @var LeagueRepository
     */
    private $leagueRepository;

    /**
     * @var array
     */
    private $teams;

    /**
     * @var int
     */
    private $season_id;

    /**
     * CreateLeagueTask constructor.
     * @param LeagueRepository $leagueRepository
     */
    public function __construct(LeagueRepository $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        foreach ($this->teams as $team) {
            $this->leagueRepository->create(
                $this->season_id,
                $team->id
            );
        }
    }

    /**
     * @param mixed $teams
     * @return CreateLeagueTableTask
     */
    public function setTeams(Collection $teams): CreateLeagueTableTask
    {
        $this->teams = $teams;
        return $this;
    }

    /**
     * @param int $season_id
     * @return CreateLeagueTableTask
     */
    public function setSeasonId(int $season_id): CreateLeagueTableTask
    {
        $this->season_id = $season_id;
        return $this;
    }
}
