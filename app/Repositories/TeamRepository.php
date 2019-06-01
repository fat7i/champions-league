<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository
{
    /**
     * @var Team
     */
    private $model;

    /**
     * MatchRepository constructor.
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->model = $team;
    }

    /**
     * @return Team[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): Collection
    {
        return $this->model->getAll();
    }
}
