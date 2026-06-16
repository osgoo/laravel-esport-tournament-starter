@extends('layouts.app')

@section('content')
    <div class="actions">
        <h1>Tournaments</h1>
        @auth
            @if(auth()->user()->isAdmin())
                <a class="button" href="{{ route('tournaments.create') }}">Create tournament</a>
            @endif
        @endauth
    </div>
    <div class="grid">
        @foreach($tournaments as $tournament)
            <article class="card">
                <h2><a href="{{ route('tournaments.show', $tournament) }}">{{ $tournament->name }}</a></h2>
                <p class="muted">{{ $tournament->game_title }} · {{ $tournament->status }}</p>
                <p>{{ $tournament->approved_registrations_count }} approved teams</p>
            </article>
        @endforeach
    </div>
    {{ $tournaments->links() }}
@endsection
