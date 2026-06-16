@extends('layouts.app')

@section('content')
    <section class="card">
        <h1>Laravel Esport Tournament Starter</h1>
        <p class="muted">A public-safe starting point for teams, tournaments, registration approval, and demo match results.</p>
        <div class="actions">
            <a class="button" href="{{ route('tournaments.index') }}">Browse tournaments</a>
            @auth
                <a class="button secondary" href="{{ route('teams.create') }}">Create team</a>
            @else
                <a class="button secondary" href="{{ route('register') }}">Join demo</a>
            @endauth
        </div>
    </section>

    <h2>Latest tournaments</h2>
    <div class="grid">
        @forelse($tournaments as $tournament)
            <article class="card">
                <h3><a href="{{ route('tournaments.show', $tournament) }}">{{ $tournament->name }}</a></h3>
                <p class="muted">{{ $tournament->game_title }} · {{ $tournament->status }}</p>
            </article>
        @empty
            <p>No tournaments yet.</p>
        @endforelse
    </div>
@endsection
