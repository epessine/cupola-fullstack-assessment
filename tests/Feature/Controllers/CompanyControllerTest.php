<?php

namespace Tests\Feature\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\State;
use Illuminate\Support\Str;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    public function test_index_endpoint_should_return_companies_with_limit()
    {
        $number = $this->faker->numberBetween(2, 100);

        $limit = $this->faker->numberBetween(2, 100);

        Company::factory($number)->create();

        $response = $this->get('/api/companies?'.http_build_query([
            'limit' => $limit,
        ]));

        $response->assertStatus(200);

        $expectedCompanies = Company::all()->take($limit)->map($this->mapResource());

        $response->assertJsonPath('data', $expectedCompanies->all());
    }

    public function test_index_endpoint_should_return_companies_filtered_by_state()
    {
        $number = $this->faker->numberBetween(2, 100);

        Company::factory($number)->create();

        $state = State::all()->random();

        $response = $this->get('/api/companies?'.http_build_query([
            'limit' => 10,
            'state_id' => $state->id,
        ]));

        $response->assertStatus(200);

        $expectedCompanies = Company::whereRelation('city', 'state_id', $state->id)
            ->get()
            ->take($number)
            ->map($this->mapResource());

        $response->assertJsonPath('data', $expectedCompanies->all());
    }

    public function test_index_endpoint_should_return_companies_filtered_by_city()
    {
        $number = $this->faker->numberBetween(2, 100);

        Company::factory($number)->create();

        $city = City::all()->random();

        $response = $this->get('/api/companies?'.http_build_query([
            'limit' => 10,
            'city_id' => $city->id,
        ]));

        $response->assertStatus(200);

        $expectedCompanies = Company::whereCityId($city->id)
            ->get()
            ->take($number)
            ->map($this->mapResource());

        $response->assertJsonPath('data', $expectedCompanies->all());
    }

    public function test_index_endpoint_should_return_companies_filtered_by_search()
    {
        $number = $this->faker->numberBetween(2, 100);

        Company::factory($number)->create();

        $search = Company::all()->random()->name;

        $response = $this->get('/api/companies?'.http_build_query([
            'limit' => 10,
            'search' => $search,
        ]));

        $response->assertStatus(200);

        $expectedCompanies = Company::where('name', 'LIKE', "%$search%")
            ->get()
            ->take($number)
            ->map($this->mapResource());

        $response->assertJsonPath('data', $expectedCompanies->all());
    }

    public function test_index_endpoint_should_validate_fields()
    {
        $string = Str::random(5);

        $response = $this->get('/api/companies?'.http_build_query([
            'limit' => $string,
            'search' => $string,
            'state_id' => $string,
            'city_id' => $string,
        ]));

        $response->assertInvalid(['state_id', 'city_id', 'limit']);

        $string = Str::random(256);

        $response = $this->get('/api/companies?'.http_build_query([
            'limit' => 10,
            'search' => $string,
        ]));

        $response->assertInvalid(['search']);

        $limit = $this->faker->numberBetween(1, 5);

        $response = $this->get('/api/companies?'.http_build_query([
            'limit' => $limit,
        ]));

        $response->assertInvalid(['limit']);
    }

    private function mapResource(): callable
    {
        return fn (Company $company) => [
            'id' => $company->id,
            'name' => $company->name,
            'description' => $company->description,
            'email' => $company->email,
            'phone' => $company->phone,
            'formatted_phone' => Str::slug($company->phone, ''),
            'city' => [
                'id' => $company->city->id,
                'name' => $company->city->name,
                'state' => [
                    'id' => $company->city->state->id,
                    'name' => $company->city->state->name,
                ],
            ],
        ];
    }
}
