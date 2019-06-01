<?php

namespace App\Services;

use App\Tasks\PlayWeekTask;

class WeekService
{
    /**
     * @var PlayWeekTask
     */
    private $playWeekTask;

    /**
     * WeekService constructor.
     * @param PlayWeekTask $playWeekTask
     */
    public function __construct(PlayWeekTask $playWeekTask)
    {
        $this->playWeekTask = $playWeekTask;
    }

    /**
     * @param int $id
     * @return array
     */
    public function play(int $id): ?array
    {
        return $this->playWeekTask->setWeekId($id)->run();
    }
}
