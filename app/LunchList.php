<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LunchList extends Model
{
    protected $table = 'lists';
    public $timestamps = false;

    public function names()
    {
        return $this->hasMany('App\Name');
    }

    public function getOpenedOnAttribute($value)
    {
        return Carbon::parse($value)->format('l F jS');
    }
}
