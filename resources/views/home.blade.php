@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    I am logged in!
                    <div>
                        My Leagues
                        @each('view.name', $leagues, 'league')
                        <button @click="add-league">Add a League</button>
                    </div>
                    <div>
                        My Decks
                        @each('view.name', $decks, 'deck')
                        <button @click="add-deck">Add a Deck</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
