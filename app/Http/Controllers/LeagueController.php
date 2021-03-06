<?php

namespace App\Http\Controllers;

use App\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leagues = Auth::user()->player()->first()->leagues()->get();
        return $leagues;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $player = Auth::user()->player()->first();

        $validatedData = $request->validate([
            'name' => 'bail|required|unique:leagues,name,,id,deleted_at,NULL'
        ]);

        $league = null;
        if (isset($request->name)) {
            $league = League::create([
                'owner_id' => $player->id,
                'name' => $request->name,
            ])->players()->attach($player);
        }
        return $league;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $player = Auth::user()->player()->first();
        $my_decks = $player->decks;
        $league = League::with('players.decks')->findOrFail($id);
        return view('league.show')->with([
            'league' => $league,
            'my_decks' => $my_decks
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\League  $league
     * @return \Illuminate\Http\Response
     */
    public function edit(League $league)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        return League::findOrFail($id)->decks()
            ->syncWithoutDetaching([$request->input('id')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $player = Auth::user()->player()->first();
        $player_id = $player->id;
        $is_deleted = false;
        if (League::findOrFail($id)->owner_id == $player_id) {
            $is_deleted = League::destroy($id);
        } else {
            return League::findOrFail($id)->players()->detach($player);
        }
        return $is_deleted;
    }

    public function findLeagues(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $leagues = League::where('name', 'like', '%'.$request->name.'%')->get();
        return $leagues;
    }

    public function joinLeague(Request $request)
    {
        $player = Auth::user()->player()->first();
        $league = League::findOrFail($request->id);
        if ($league->players->contains($player)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error',
                'errors' => array('name' => array("I'm already in this league."))
            ], 422);
        }
        return League::findOrFail($request->id)->players()->attach($player);
    }

    public function decks(Request $request)
    {
        $player = Auth::user()->player()->first();
        $league = League::with('decks')->findOrFail($request->id);
        if ($league->players->contains($player)) {
            return $league->decks;
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Error',
            'errors' => array('name' => array("I'm not in this league."))
        ], 422);
    }

    public function removeDeck(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'deck_id' => 'required'
        ]);
        $player = Auth::user()->player()->first();
        $league = League::findOrFail($request->id);
        $response_code = 404;
        $status = 'error';
        $message = 'User does not own this league.';
        if ($league->owner_id == $player->id) {
            $message =
                'Deck could not be unassigned.';
            if ($league->decks()
                ->detach($request->deck_id)) {
                    $response_code = 200;
                    $status = 'success';
                    $message = 'The operation was successful.';
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $response_code);
    }
}
