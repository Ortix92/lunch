<?php

namespace App;

use Carbon\Carbon;

class LunchList extends \Eloquent
{
    const CREATED_AT = 'opened_on';
    const UPDATED_AT = 'updated_on';
    protected $table = 'lists';

    protected $dates = ['opened_on', 'updated_on', 'closed_on'];
    protected $fillable = ['description', 'closed', 'closed_on', 'veggy'];


    public function names()
    {
        return $this->belongsToMany('App\Name', 'list_name', 'list_id', 'name_id');
    }

    public function isVeggy()
    {
        return !$this->names()->where('veggy', '=', 1)->get()->isEmpty();
    }

    public function close()
    {
        $this->attributes['closed'] = 1;
        $this->attributes['closed_on'] = Carbon::now();
    }

    public function getOpenedOnAttribute($value)
    {
        return Carbon::parse($value)->format('l F jS');
    }

}
