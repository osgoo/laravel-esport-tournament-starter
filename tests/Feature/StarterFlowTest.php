<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StarterFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_team_and_request_tournament_registration(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();
        $tournament = Tournament::factory()->create(['organizer_id' => $admin->id]);

        $this->actingAs($user, 'web')
            ->post('/teams', [
                'name' => 'Open Source Squad',
                'tag' => 'OSS',
            ])
            ->assertRedirect();

        $team = Team::firstWhere('name', 'Open Source Squad');

        $this->actingAs($user, 'web')
            ->post(route('tournaments.register', $tournament), ['team_id' => $team->id])
            ->assertRedirect();

        $this->assertDatabaseHas('tournament_registrations', [
            'tournament_id' => $tournament->id,
            'team_id' => $team->id,
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_approve_registration_and_generate_demo_match(): void
    {
        $admin = User::factory()->admin()->create();
        $tournament = Tournament::factory()->create(['organizer_id' => $admin->id]);
        $teamOne = Team::factory()->create();
        $teamTwo = Team::factory()->create();
        $regOne = $tournament->registrations()->create(['team_id' => $teamOne->id, 'status' => 'pending']);
        $regTwo = $tournament->registrations()->create(['team_id' => $teamTwo->id, 'status' => 'pending']);

        $this->actingAs($admin, 'web')->post(route('admin.registrations.approve', $regOne))->assertRedirect();
        $this->actingAs($admin, 'web')->post(route('admin.registrations.approve', $regTwo))->assertRedirect();
        $this->actingAs($admin, 'web')->post(route('admin.tournaments.demo-bracket', $tournament))->assertRedirect();

        $this->assertDatabaseHas('tournament_matches', [
            'tournament_id' => $tournament->id,
            'team_one_id' => $teamOne->id,
            'team_two_id' => $teamTwo->id,
            'status' => 'scheduled',
        ]);
    }
}
