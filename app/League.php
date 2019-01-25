<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class League extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'owner_id'];

    public function players()
    {
        return $this->belongsToMany('App\Player')->withTimestamps();
    }

    public function decks()
    {
        return $this->belongsToMany('App\Deck')
            ->as('membership')
            ->withPivot('wins', 'losses')
            ->withTimestamps();
    }

    public function find(Request $request)
    {
        $model = new App\League;
        foreach ($fillable as $attribute)
        {
            if (isset($request[$attribute])) {
                $model->where($attribute, $request[$attribute]);
            }
        }
        $leagues = $model->get();
        return $leagues;
    }
}
