<?php

namespace App\Repositories;

use App\Models\Week;

class WeekRepository
{
    /**
     * @var Week
     */
    private $model;

    /**
     * MatchRepository constructor.
     * @param Week $week
     */
    public function __construct(Week $week)
    {
        $this->model = $week;
    }

    /**
     * @param int $seasonId
     * @param string $name
     * @return Week
     */
    public function create(int $seasonId, string $name): Week
    {
        return $this->model->create($seasonId, $name);
    }

    /**
     * @param int $id
     * @return Week
     */
    public function find(int $id): Week
    {
        return $this->model->find($id);
    }
}
