<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel Esport Tournament Starter') }}</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <nav class="nav">
        <a class="brand" href="{{ route('home') }}">Esport Starter</a>
        <div class="nav-links">
            <a href="{{ route('tournaments.index') }}">Tournaments</a>
            <a href="{{ route('teams.index') }}">Teams</a>
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.tournaments.index') }}">Admin</a>
                    <a href="{{ route('tournaments.create') }}">New Tournament</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="button secondary">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}">Log in</a>
                <a class="button" href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </nav>
    <main class="shell">
        @if(session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="errors">
                <strong>Fix these fields:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
