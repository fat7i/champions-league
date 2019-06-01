<?php

namespace App\Tasks;

interface TaskInterface
{

    /**
     * Run the task
     * @return mixed
     */
    public function run();
}
