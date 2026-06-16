@extends('layouts.app')

@section('content')
    <form class="panel" method="POST" action="{{ route('teams.store') }}">
        @csrf
        <h1>Create team</h1>
        <label>Name <input name="name" value="{{ old('name') }}" required></label>
        <label>Tag <input name="tag" value="{{ old('tag') }}" maxlength="12"></label>
        <label>Description <textarea name="description" rows="4">{{ old('description') }}</textarea></label>
        <button type="submit">Save team</button>
    </form>
@endsection
