<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LunchList extends Model
{
    const CREATED_AT = 'opened_on';
    const UPDATED_AT = 'updated_on';
    protected $table = 'lists';
//    public $timestamps = false;

    protected $fillable = ['description', 'closed', 'closed_on', 'veggy'];


    public function names()
    {
        return $this->belongsToMany('App\Name','list_name','list_id','name_id');
    }

    public function getOpenedOnAttribute($value)
    {
        return Carbon::parse($value)->format('l F jS');
    }

}
