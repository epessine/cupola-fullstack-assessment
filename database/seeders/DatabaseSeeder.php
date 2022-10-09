<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => fake()->name(),
            'email' => 'assessment@cupola.com',
            'password' => Hash::make('password'),
        ]);

        Company::factory(200)->create();
    }
}
