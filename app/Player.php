<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id'];

    public function leagues()
    {
        return $this->belongsToMany('App\League')->withTimestamps();
    }

    public function decks()
    {
        return $this->hasMany('App\Deck');
    }
}
