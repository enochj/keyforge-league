@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                My Decks
                <decks></decks>
                <deck-form></deck-form>
            </div>
        </div>
    </div>
@endsection