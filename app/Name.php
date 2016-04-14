<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    protected $fillable = ['name', 'persist'];

    public function lunchLists()
    {
        return $this->belongsToMany('App\LunchList', 'list_name', 'name_id', 'list_id');
    }
}
