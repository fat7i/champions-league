<?php

namespace App\Tasks;

use App\Models\Season;
use App\Repositories\SeasonRepository;

class FindSeasonByIdTask implements TaskInterface
{
    /**
     * @var SeasonRepository
     */
    private $seasonRepository;

    /**
     * @var int
     */
    private $id;

    /**
     * CreateSeasonTask constructor.
     * @param SeasonRepository $seasonRepository
     */
    public function __construct(SeasonRepository $seasonRepository)
    {
        $this->seasonRepository = $seasonRepository;
    }

    /**
     * @return Season
     */
    public function run(): Season
    {
        return $this->seasonRepository->find($this->id);
    }

    /**
     * @param int $id
     * @return FindSeasonByIdTask
     */
    public function setId(int $id): FindSeasonByIdTask
    {
        $this->id = $id;
        return $this;
    }
}
