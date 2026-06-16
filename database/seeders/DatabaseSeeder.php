<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Demo Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        $player = User::firstOrCreate(
            ['email' => 'player@example.com'],
            ['name' => 'Demo Player', 'password' => Hash::make('password'), 'role' => 'user']
        );

        $team = Team::firstOrCreate(
            ['name' => 'Demo Dragons'],
            ['captain_id' => $player->id, 'tag' => 'DDG', 'description' => 'Seeded team for local demos.']
        );
        $team->members()->syncWithoutDetaching([$player->id => ['role' => 'captain']]);

        $tournament = Tournament::firstOrCreate(
            ['name' => 'Starter Cup'],
            [
                'organizer_id' => $admin->id,
                'game_title' => 'Valorant',
                'description' => 'Seeded demo tournament with approval flow.',
                'status' => 'draft',
                'starts_at' => now()->addWeek(),
                'max_teams' => 8,
            ]
        );

        $tournament->registrations()->firstOrCreate(
            ['team_id' => $team->id],
            ['status' => 'pending']
        );
    }
}
