@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    <div class="grid">
        <section class="card">
            <h2>Your teams</h2>
            @forelse($teams as $team)
                <p><a href="{{ route('teams.show', $team) }}">{{ $team->name }}</a></p>
            @empty
                <p class="muted">No teams yet.</p>
            @endforelse
            <a class="button" href="{{ route('teams.create') }}">Create team</a>
        </section>
        <section class="card">
            <h2>Tournaments</h2>
            @foreach($tournaments as $tournament)
                <p><a href="{{ route('tournaments.show', $tournament) }}">{{ $tournament->name }}</a></p>
            @endforeach
        </section>
    </div>
@endsection
