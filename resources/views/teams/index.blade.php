@extends('layouts.app')

@section('content')
    <div class="actions">
        <h1>Teams</h1>
        @auth <a class="button" href="{{ route('teams.create') }}">Create team</a> @endauth
    </div>
    <div class="grid">
        @foreach($teams as $team)
            <article class="card">
                <h2><a href="{{ route('teams.show', $team) }}">{{ $team->name }}</a></h2>
                <p class="muted">{{ $team->tag ?: 'No tag' }} · Captain: {{ $team->captain->name }}</p>
            </article>
        @endforeach
    </div>
    {{ $teams->links() }}
@endsection
