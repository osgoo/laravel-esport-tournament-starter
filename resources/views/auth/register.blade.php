@extends('layouts.app')

@section('content')
    <form class="panel" method="POST" action="{{ route('register') }}">
        @csrf
        <h1>Create account</h1>
        <label>Name <input name="name" value="{{ old('name') }}" required autofocus></label>
        <label>Email <input name="email" type="email" value="{{ old('email') }}" required></label>
        <label>Password <input name="password" type="password" required></label>
        <label>Confirm password <input name="password_confirmation" type="password" required></label>
        <button type="submit">Register</button>
    </form>
@endsection
