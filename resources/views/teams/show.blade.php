@extends('layouts.app')

@section('content')
    <article class="card">
        <h1>{{ $team->name }}</h1>
        <p class="muted">{{ $team->tag ?: 'No tag' }}</p>
        <p>{{ $team->description }}</p>
        <h2>Members</h2>
        <ul>
            @foreach($team->members as $member)
                <li>{{ $member->name }} · {{ $member->pivot->role }}</li>
            @endforeach
        </ul>
    </article>
@endsection
