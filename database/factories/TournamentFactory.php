<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TournamentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'organizer_id' => User::factory()->admin(),
            'name' => fake()->words(3, true),
            'game_title' => fake()->randomElement(['Valorant', 'Counter-Strike 2', 'Dota 2', 'Rocket League']),
            'description' => fake()->paragraph(),
            'status' => 'draft',
            'starts_at' => now()->addDays(7),
            'max_teams' => 16,
        ];
    }
}
