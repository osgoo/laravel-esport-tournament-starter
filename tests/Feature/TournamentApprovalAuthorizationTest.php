<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentApprovalAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_users_are_redirected_from_tournament_admin_approval_routes(): void
    {
        [$tournament, $registration] = $this->createPendingRegistration();

        $this->get(route('admin.tournaments.index'))
            ->assertRedirect(route('login'));

        $this->post(route('admin.registrations.approve', $registration))
            ->assertRedirect(route('login'));

        $this->post(route('admin.registrations.reject', $registration))
            ->assertRedirect(route('login'));

        $this->post(route('admin.tournaments.demo-bracket', $tournament))
            ->assertRedirect(route('login'));
    }

    public function test_normal_users_cannot_access_tournament_approval_actions(): void
    {
        $user = User::factory()->create();
        [$tournament, $registration] = $this->createPendingRegistration();

        $this->actingAs($user, 'web')
            ->withHeader('Accept', 'application/json')
            ->get(route('admin.tournaments.index'))
            ->assertForbidden();

        $this->actingAs($user, 'web')
            ->withHeader('Accept', 'application/json')
            ->post(route('admin.registrations.approve', $registration))
            ->assertForbidden();

        $this->actingAs($user, 'web')
            ->withHeader('Accept', 'application/json')
            ->post(route('admin.registrations.reject', $registration))
            ->assertForbidden();

        $this->actingAs($user, 'web')
            ->withHeader('Accept', 'application/json')
            ->post(route('admin.tournaments.demo-bracket', $tournament))
            ->assertForbidden();

        $registration->refresh();

        $this->assertSame('pending', $registration->status);
        $this->assertNull($registration->approved_at);
    }

    public function test_admin_users_can_approve_pending_tournament_registrations(): void
    {
        $admin = User::factory()->admin()->create();
        [, $registration] = $this->createPendingRegistration();

        $this->actingAs($admin, 'web')
            ->from(route('admin.tournaments.index'))
            ->post(route('admin.registrations.approve', $registration))
            ->assertRedirect(route('admin.tournaments.index'));

        $registration->refresh();

        $this->assertSame('approved', $registration->status);
        $this->assertNotNull($registration->approved_at);
    }

    /**
     * @return array{Tournament, TournamentRegistration}
     */
    private function createPendingRegistration(): array
    {
        $admin = User::factory()->admin()->create();
        $tournament = Tournament::factory()->create(['organizer_id' => $admin->id]);
        $team = Team::factory()->create();
        $registration = $tournament->registrations()->create([
            'team_id' => $team->id,
            'status' => 'pending',
        ]);

        return [$tournament, $registration];
    }
}
