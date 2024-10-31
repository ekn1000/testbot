<?php

namespace Database\Factories;

use App\Models\ProjectGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'targeturl' => $this->faker->domainName,
            'daily_volume_of_tasks'  => $this->faker->randomNumber(3, false),
            'percentage_of_repeat_visits' => $this->faker->numberBetween(10, 100),
            'group_id' => $this->faker->numberBetween(1, 6),
            //'days_of_pumping' =>$this->faker->numberBetween(2, 45),
        ];
    }
}
