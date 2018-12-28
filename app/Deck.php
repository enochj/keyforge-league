<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $fillable = [
        'player_id', 'name', 'kf_id',
    ];

    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    public function leagues()
    {
        return $this->belongsToMany('App\League')->withTimestamps();
    }
}
