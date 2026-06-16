<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TournamentApprovalController extends Controller
{
    public function index(): View
    {
        return view('admin.tournaments.index', [
            'tournaments' => Tournament::with(['registrations.team', 'matches'])->latest()->get(),
        ]);
    }

    public function approve(TournamentRegistration $registration): RedirectResponse
    {
        $registration->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Registration approved.');
    }

    public function reject(TournamentRegistration $registration): RedirectResponse
    {
        $registration->update([
            'status' => 'rejected',
            'approved_at' => null,
        ]);

        return back()->with('status', 'Registration rejected.');
    }

    public function generateDemoBracket(Tournament $tournament): RedirectResponse
    {
        $teams = $tournament->approvedRegistrations()->with('team')->take(2)->get()->pluck('team');

        if ($teams->count() < 2) {
            return back()->withErrors(['bracket' => 'Approve at least two teams before generating the demo bracket.']);
        }

        $tournament->matches()->updateOrCreate(
            ['round' => 1],
            [
                'team_one_id' => $teams[0]->id,
                'team_two_id' => $teams[1]->id,
                'status' => 'scheduled',
            ]
        );

        $tournament->update(['status' => 'running']);

        return back()->with('status', 'Demo bracket generated.');
    }
}
