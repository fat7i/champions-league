<?php

namespace App\Services;

use App\Tasks\CalculateSeasonPredictionsTask;

class PredictionsServices
{
    /**
     * @var CalculateSeasonPredictionsTask
     */
    private $calculateSeasonPredictionsTask;

    /**
     * PredictionsServices constructor.
     * @param CalculateSeasonPredictionsTask $calculateSeasonPredictionsTask
     */
    public function __construct(CalculateSeasonPredictionsTask $calculateSeasonPredictionsTask)
    {
        $this->calculateSeasonPredictionsTask = $calculateSeasonPredictionsTask;
    }

    /**
     * @param int $seasonId
     * @return array|mixed
     */
    public function get(int $seasonId): ?array
    {
        return $this->calculateSeasonPredictionsTask
            ->setSeasonId($seasonId)
            ->run();
    }
}
