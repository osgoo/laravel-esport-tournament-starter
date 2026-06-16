<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'tournaments' => Tournament::latest()->take(6)->get(),
        ]);
    }
}
