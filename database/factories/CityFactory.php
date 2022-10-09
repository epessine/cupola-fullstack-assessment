<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    public function definition()
    {
        $state = $this->faker->state();

        return [
            'name' => $this->faker->city(),
            'state_id' => State::whereName($state)->firstOr(
                fn () => State::factory()->state(['name' => $state])
            ),
        ];
    }
}
