<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    public function lunchList() {
        return $this->belongsTo('App\LunchList');
    }
}
