@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="row">
            {{$league->name}}
            <div class="col-md-12">
                <league-decks :my_decks="{{$my_decks}}" :league="{{$league}}"></league-decks>
            </div>
        </div>
    </div>
@endsection