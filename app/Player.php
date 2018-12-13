<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use SoftDeletes;

    public function leagues()
    {
        return $this->belongsToMany('App\League');
    }

    public function decks()
    {
        return $this->hasMany('App\Deck');
    }
}
