<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LunchList extends Model
{
    protected $table = 'lists';
    public $timestamps = false;
    
    public function names() {
        return $this->hasMany('App\Name');
    }
}
