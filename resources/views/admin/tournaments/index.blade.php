@extends('layouts.app')

@section('content')
    <h1>Admin tournament approvals</h1>
    @foreach($tournaments as $tournament)
        <section class="card">
            <div class="actions">
                <h2>{{ $tournament->name }}</h2>
                <form method="POST" action="{{ route('admin.tournaments.demo-bracket', $tournament) }}">
                    @csrf
                    <button type="submit" class="button secondary">Generate demo bracket</button>
                </form>
            </div>
            <table>
                <thead><tr><th>Team</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($tournament->registrations as $registration)
                        <tr>
                            <td>{{ $registration->team->name }}</td>
                            <td>{{ $registration->status }}</td>
                            <td class="actions">
                                <form method="POST" action="{{ route('admin.registrations.approve', $registration) }}">
                                    @csrf
                                    <button type="submit">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.registrations.reject', $registration) }}">
                                    @csrf
                                    <button type="submit" class="button secondary">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    @endforeach
@endsection
