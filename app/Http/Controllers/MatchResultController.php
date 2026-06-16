<?php

namespace App\Http\Controllers;

use App\Models\TournamentMatch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MatchResultController extends Controller
{
    public function edit(TournamentMatch $match): View
    {
        return view('matches.edit', ['match' => $match->load('teamOne', 'teamTwo', 'tournament')]);
    }

    public function update(Request $request, TournamentMatch $match): RedirectResponse
    {
        $data = $request->validate([
            'team_one_score' => ['required', 'integer', 'min:0'],
            'team_two_score' => ['required', 'integer', 'min:0'],
        ]);

        if ($data['team_one_score'] === $data['team_two_score']) {
            return back()->withErrors(['score' => 'Demo matches need a winner.']);
        }

        $winnerId = $data['team_one_score'] > $data['team_two_score']
            ? $match->team_one_id
            : $match->team_two_id;

        $match->update($data + [
            'winner_team_id' => $winnerId,
            'status' => 'completed',
        ]);

        $match->tournament->update(['status' => 'completed']);

        return redirect()->route('tournaments.show', $match->tournament)->with('status', 'Match result saved.');
    }
}
