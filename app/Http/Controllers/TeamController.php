<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        return view('teams.index', [
            'teams' => Team::with('captain')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('teams.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tag' => ['nullable', 'string', 'max:12'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $team = Team::create($data + ['captain_id' => $request->user()->id]);
        $team->members()->syncWithoutDetaching([$request->user()->id => ['role' => 'captain']]);

        return redirect()->route('teams.show', $team)->with('status', 'Team created.');
    }

    public function show(Team $team): View
    {
        return view('teams.show', [
            'team' => $team->load('captain', 'members'),
        ]);
    }
}
