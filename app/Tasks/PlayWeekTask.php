<?php

namespace App\Tasks;

use App\Repositories\WeekRepository;
use Illuminate\Support\Collection;

class PlayWeekTask implements TaskInterface
{
    /**
     * @var WeekRepository
     */
    private $weekRepository;

    /**
     * @var PlayMatchTask
     */
    private $playMatchTask;

    /**
     * @var int
     */
    private $weekId;

    /**
     * PlayWeekTask constructor.
     * @param PlayMatchTask $playMatchTask
     * @param WeekRepository $weekRepository
     */
    public function __construct(PlayMatchTask $playMatchTask, WeekRepository $weekRepository)
    {
        $this->playMatchTask = $playMatchTask;
        $this->weekRepository = $weekRepository;
    }


    /**
     * @return array
     */
    public function run(): ?array
    {
        $output = [];

        $matches = $this->getMatches();

        if ($matches) {
            foreach ($matches as $match) {
                $output[] = $this->playMatchTask->setMatchId($match->id)->run();
            }
        }

        return $output;
    }

    /**
     * @param int $weekId
     * @return PlayWeekTask
     */
    public function setWeekId(int $weekId): PlayWeekTask
    {
        $this->weekId = $weekId;
        return $this;
    }

    /**
     * @return Collection
     */
    private function getMatches(): Collection
    {
        $week = $this->weekRepository->find($this->weekId);
        return $week->matches;
    }
}