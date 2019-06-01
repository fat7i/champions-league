<?php

namespace App\Services;

use App\Exceptions\CreateSeasonFailedException;
use App\Exceptions\NoTeamsFoundException;
use App\Models\Season;
use App\Tasks\CreateLeagueMatchesTask;
use App\Tasks\CreateLeagueTableTask;
use App\Tasks\CreateSeasonTask;
use App\Tasks\FindSeasonByIdTask;
use App\Tasks\GetTeamsTask;

class SeasonService
{
    /**
     * @var CreateSeasonTask
     */
    private $createSeasonTask;

    /**
     * @var GetTeamsTask
     */
    private $getTeamsTask;

    /**
     * @var CreateLeagueTableTask
     */
    private $createLeagueTableTask;

    /**
     * @var CreateLeagueMatchesTask
     */
    private $createLeagueMatchesTask;

    /**
     * @var FindSeasonByIdTask
     */
    private $findSeasonByIdTask;


    /**
     * SeasonService constructor.
     * @param CreateSeasonTask $createSeasonTask
     * @param GetTeamsTask $getTeamsTask
     * @param CreateLeagueTableTask $createLeagueTableTask
     * @param CreateLeagueMatchesTask $createLeagueMatchesTask
     * @param FindSeasonByIdTask $findSeasonByIdTask
     */
    public function __construct(
        CreateSeasonTask $createSeasonTask,
        GetTeamsTask $getTeamsTask,
        CreateLeagueTableTask $createLeagueTableTask,
        CreateLeagueMatchesTask $createLeagueMatchesTask,
        FindSeasonByIdTask $findSeasonByIdTask
    ) {
        $this->createSeasonTask = $createSeasonTask;
        $this->getTeamsTask = $getTeamsTask;
        $this->createLeagueTableTask = $createLeagueTableTask;
        $this->createLeagueMatchesTask = $createLeagueMatchesTask;
        $this->findSeasonByIdTask = $findSeasonByIdTask;
    }

    /**
     * @param string $name
     * @return Season
     * @throws CreateSeasonFailedException
     * @throws NoTeamsFoundException
     */
    public function create(string $name): Season
    {
        $teams = $this->getTeamsTask->run();

        if (!$teams->count()) {
            throw new NoTeamsFoundException();
        }

        try {
            // create season
            $season = $this->createSeasonTask->setName($name)->run();
        } catch (\Exception $exception) {
            throw new CreateSeasonFailedException();
        }

        //create league table
        $this->createLeagueTableTask->setTeams($teams)->setSeasonId($season->id)->run();

        //create matches
        $this->createLeagueMatchesTask->setTeams($teams)->setSeasonId($season->id)->run();

        return $season;
    }

    /**
     * @param int $id
     * @return Season
     */
    public function find(int $id): ?Season
    {
        return $this->findSeasonByIdTask->setId($id)->run();
    }
}
