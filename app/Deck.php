<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Deck extends Model
{
    protected $fillable = [
        'player_id', 'name', 'kf_id',
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function(Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    public function leagues()
    {
        return $this->belongsToMany('App\League')
            ->as('membership')
            ->withPivot('wins', 'losses')
            ->withTimestamps();
    }
}
