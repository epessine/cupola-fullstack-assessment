<?php

namespace Tests\Feature\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Support\Str;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    public function test_index_endpoint_should_return_cities()
    {
        $number = $this->faker->numberBetween(2, 100);

        City::factory($number)->create();

        $response = $this->get('/api/cities');

        $response->assertStatus(200);

        $expectedCities = City::all()->map($this->mapResource());

        $response->assertJsonPath('data', $expectedCities->all());
    }

    public function test_index_endpoint_should_return_cities_filtered_by_state()
    {
        $number = $this->faker->numberBetween(2, 100);

        City::factory($number)->create();

        $state = State::all()->random();

        $response = $this->get("/api/cities?state_id={$state->id}");

        $response->assertStatus(200);

        $expectedCities = City::whereStateId($state->id)
            ->get()
            ->map($this->mapResource());

        $response->assertJsonPath('data', $expectedCities->all());
    }

    public function test_index_endpoint_should_validate_state_id()
    {
        $number = $this->faker->numberBetween(2, 50);

        State::factory($number)->create();

        $string = Str::random(5);

        $response = $this->get("/api/cities?state_id=$string");

        $response->assertInvalid(['state_id']);

        $missingId = $number + $this->faker->numberBetween(1, 100);

        $response = $this->get("/api/cities?state_id=$missingId");

        $response->assertInvalid(['state_id']);
    }

    private function mapResource(): callable
    {
        return fn (City $city) => [
            'id' => $city->id,
            'name' => $city->name,
            'state' => [
                'id' => $city->state->id,
                'name' => $city->state->name,
            ],
        ];
    }
}
