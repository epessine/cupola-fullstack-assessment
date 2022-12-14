<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StateFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->state(),
        ];
    }
}
