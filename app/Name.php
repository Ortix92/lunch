<?php

namespace App;

class Name extends \Eloquent
{
    protected $fillable = ['name', 'persist'];

    public function lunchLists()
    {
        return $this->belongsToMany('App\LunchList', 'list_name', 'name_id', 'list_id')->withPivot('note');
    }
}
