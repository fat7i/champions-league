<?php

namespace App\Tasks;

use App\Models\Season;
use App\Repositories\SeasonRepository;

class CreateSeasonTask implements TaskInterface
{
    /**
     * @var SeasonRepository
     */
    private $seasonRepository;

    /**
     * @var string
     */
    private $name;

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
        return $this->seasonRepository->create($this->name);
    }

    /**
     * @param string $name
     * @return CreateSeasonTask
     */
    public function setName(string $name): CreateSeasonTask
    {
        $this->name = $name;
        return $this;
    }
}
