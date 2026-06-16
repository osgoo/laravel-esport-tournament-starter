@extends('layouts.app')

@section('content')
    <article class="card">
        <h1>{{ $tournament->name }}</h1>
        <p class="muted">{{ $tournament->game_title }} · {{ $tournament->status }}</p>
        <p>{{ $tournament->description }}</p>

        @auth
            @if($userTeams->isNotEmpty())
                <form method="POST" action="{{ route('tournaments.register', $tournament) }}">
                    @csrf
                    <label>Register one of your teams
                        <select name="team_id">
                            @foreach($userTeams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button type="submit">Submit registration</button>
                </form>
            @endif
        @endauth
    </article>

    <h2>Registrations</h2>
    <table>
        <thead><tr><th>Team</th><th>Status</th></tr></thead>
        <tbody>
            @foreach($tournament->registrations as $registration)
                <tr><td>{{ $registration->team->name }}</td><td>{{ $registration->status }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <h2>Matches</h2>
    <div class="grid">
        @forelse($tournament->matches as $match)
            <article class="card">
                <h3>Round {{ $match->round }}</h3>
                <p>{{ $match->teamOne?->name ?? 'TBD' }} vs {{ $match->teamTwo?->name ?? 'TBD' }}</p>
                <p class="muted">Status: {{ $match->status }}</p>
                @if($match->winner)
                    <p>Winner: {{ $match->winner->name }}</p>
                @endif
                @auth
                    @if(auth()->user()->isAdmin())
                        <a class="button secondary" href="{{ route('matches.edit', $match) }}">Enter result</a>
                    @endif
                @endauth
            </article>
        @empty
            <p class="muted">No bracket generated yet.</p>
        @endforelse
    </div>
@endsection
