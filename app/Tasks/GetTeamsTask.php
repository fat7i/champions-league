<?php

namespace App\Tasks;

use App\Repositories\TeamRepository;
use Illuminate\Support\Collection;

class GetTeamsTask
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * GetTeamsTask constructor.
     * @param TeamRepository $teamRepository
     */
    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * @return \App\Models\Team[]|\Illuminate\Database\Eloquent\Collection
     */
    public function run(): Collection
    {
        return $this->teamRepository->getAll();
    }
}
