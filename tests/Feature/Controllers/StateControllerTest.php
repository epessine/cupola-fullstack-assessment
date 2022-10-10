<?php

namespace Tests\Feature\Controllers;

use App\Models\State;
use Tests\TestCase;

class StateControllerTest extends TestCase
{
    public function test_index_endpoint_should_return_states()
    {
        $number = $this->faker->numberBetween(2, 50);

        State::factory($number)->create();

        $response = $this->get('/api/states');

        $response->assertStatus(200);

        $expectedStates = State::all()->map(fn (State $state) => [
            'id' => $state->id,
            'name' => $state->name,
        ]);

        $response->assertJsonPath('data', $expectedStates->all());
    }
}
