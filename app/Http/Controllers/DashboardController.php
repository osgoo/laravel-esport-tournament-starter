<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('dashboard', [
            'teams' => Team::where('captain_id', $request->user()->id)->latest()->get(),
            'tournaments' => Tournament::latest()->take(5)->get(),
        ]);
    }
}
