<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition()
    {
        $city = $this->faker->city();

        return [
            'name' => $this->faker->unique()->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'description' => $this->faker->sentence(10, true),
            'city_id' => City::whereName($city)->firstOr(
                fn () => City::factory()->state(['name' => $city])
            ),
        ];
    }
}
