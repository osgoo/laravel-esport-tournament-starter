<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TournamentController extends Controller
{
    public function index(): View
    {
        return view('tournaments.index', [
            'tournaments' => Tournament::withCount('approvedRegistrations')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('tournaments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'game_title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'starts_at' => ['nullable', 'date'],
            'max_teams' => ['required', 'integer', 'min:2', 'max:128'],
        ]);

        $tournament = Tournament::create($data + [
            'organizer_id' => $request->user()->id,
            'status' => 'draft',
        ]);

        return redirect()->route('tournaments.show', $tournament)->with('status', 'Tournament created.');
    }

    public function show(Tournament $tournament): View
    {
        return view('tournaments.show', [
            'tournament' => $tournament->load(['registrations.team', 'matches.teamOne', 'matches.teamTwo', 'matches.winner']),
            'userTeams' => auth()->check()
                ? Team::where('captain_id', auth()->id())->orderBy('name')->get()
                : collect(),
        ]);
    }

    public function register(Request $request, Tournament $tournament): RedirectResponse
    {
        $data = $request->validate([
            'team_id' => ['required', 'exists:teams,id'],
        ]);

        $team = Team::where('captain_id', $request->user()->id)->findOrFail($data['team_id']);

        $tournament->registrations()->firstOrCreate(
            ['team_id' => $team->id],
            ['status' => 'pending']
        );

        return back()->with('status', 'Registration submitted for admin approval.');
    }
}
