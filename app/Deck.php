<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    public function leagues()
    {
        return $this->belongsToMany('App\League');
    }
}
