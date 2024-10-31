<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $coefficient = $this->faker->randomFloat(2, 0, 100);
        $frequency = $this->faker->numberBetween(0, 250000000);

        return [
            'keyword' => $this->faker->words(2, true),
            'targeturl' => $this->faker->domainName,
            'frequency' => $frequency,
            'position_up' => $this->faker->numberBetween(0, 100),
            'target_position' => $this->faker->numberBetween(21, 40),
            'coefficient' =>  $coefficient,
            'frequency_of_cheating' => ($coefficient * $frequency) / 30,
            'project_id' => $this->faker->numberBetween(1, 20),
        ];
    }
}
