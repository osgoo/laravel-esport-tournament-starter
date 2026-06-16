@extends('layouts.app')

@section('content')
    <form class="panel" method="POST" action="{{ route('login') }}">
        @csrf
        <h1>Log in</h1>
        <label>Email <input name="email" type="email" value="{{ old('email') }}" required autofocus></label>
        <label>Password <input name="password" type="password" required></label>
        <label><span><input name="remember" type="checkbox" value="1" style="width:auto"> Remember me</span></label>
        <button type="submit">Log in</button>
    </form>
@endsection
