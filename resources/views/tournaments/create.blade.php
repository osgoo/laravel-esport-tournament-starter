@extends('layouts.app')

@section('content')
    <form class="panel" method="POST" action="{{ route('tournaments.store') }}">
        @csrf
        <h1>Create tournament</h1>
        <label>Name <input name="name" value="{{ old('name') }}" required></label>
        <label>Game <input name="game_title" value="{{ old('game_title') }}" required></label>
        <label>Starts at <input name="starts_at" type="datetime-local" value="{{ old('starts_at') }}"></label>
        <label>Max teams <input name="max_teams" type="number" min="2" max="128" value="{{ old('max_teams', 16) }}" required></label>
        <label>Description <textarea name="description" rows="4">{{ old('description') }}</textarea></label>
        <button type="submit">Save tournament</button>
    </form>
@endsection
