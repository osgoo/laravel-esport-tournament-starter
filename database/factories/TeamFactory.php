<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'captain_id' => User::factory(),
            'name' => fake()->unique()->words(2, true),
            'tag' => strtoupper(fake()->lexify('???')),
            'description' => fake()->sentence(),
        ];
    }
}
