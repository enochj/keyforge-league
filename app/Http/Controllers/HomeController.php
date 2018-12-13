<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $player = Auth::user()->player()->with('leagues')->with('decks')->get();
        dd($player->toArray());
        $id = Auth::id();
        $leagues = array();
        $decks = array();
        return view('home', ['leagues' => $leagues, 'decks' => $decks]);
    }
}
