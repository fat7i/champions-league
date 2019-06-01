<?php

namespace App\Repositories;

use App\Models\Season;

class SeasonRepository
{
    /**
     * @var Season
     */
    private $model;

    /**
     * MatchRepository constructor.
     * @param Season $match
     */
    public function __construct(Season $match)
    {
        $this->model = $match;
    }

    /**
     * @param string $name
     * @return Season
     */
    public function create(string $name): Season
    {
        return $this->model->create($name);
    }

    /**
     * @param int $id
     * @return Season
     */
    public function find(int $id): Season
    {
        return $this->model->find($id);
    }
}
