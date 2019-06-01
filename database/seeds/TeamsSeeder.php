<?php

use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            [
                'name' => 'Liverpool',
                'strengths' => rand(85, 99),
            ],
            [
                'name' => 'Chelsea',
                'strengths' => rand(85, 99),
            ],
            [
                'name' => 'Manchester City',
                'strengths' => rand(85, 99),
            ],
            [
                'name' => 'Arsenal',
                'strengths' => rand(85, 99),
            ],
        ];

        \App\Models\Team::insert($teams);
    }
}
