@extends('layouts.app')

@section('content')
    <form class="panel" method="POST" action="{{ route('matches.update', $match) }}">
        @csrf
        @method('PUT')
        <h1>Enter result</h1>
        <p>{{ $match->teamOne?->name }} vs {{ $match->teamTwo?->name }}</p>
        <label>{{ $match->teamOne?->name }} score <input name="team_one_score" type="number" min="0" value="{{ old('team_one_score', $match->team_one_score ?? 0) }}" required></label>
        <label>{{ $match->teamTwo?->name }} score <input name="team_two_score" type="number" min="0" value="{{ old('team_two_score', $match->team_two_score ?? 0) }}" required></label>
        <button type="submit">Save result</button>
    </form>
@endsection
