<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LunchList extends \Eloquent
{
    const CREATED_AT = 'opened_on';
    const UPDATED_AT = 'updated_on';
    protected $table = 'lists';

    protected $dates = ['opened_on', 'updated_on', 'closed_on'];
    protected $fillable = ['description', 'closed', 'closed_on', 'veggy'];

    public function isVeggy()
    {
        return !$this->names()->where('veggy', '=', 1)->get()->isEmpty();
    }

    public function names()
    {
        return $this->belongsToMany('App\Name', 'list_name', 'list_id', 'name_id')->withPivot('note')->orderBy('name');
    }

    /**
     * @return bool true in case there exists a lunch list which is still open and has been created today
     */
    public function hasOpen()
    {
        $q = $this->queryOpenLists()->count();
        return (bool)$q;
    }

    /**
     * @return $this an eloquent query object for lists which are still open
     * and have been created today after midnight
     */
    private function queryOpenLists()
    {
        return $this->where('opened_on', '>=', Carbon::today())->where(function ($query) {
            $query->whereNull('closed_on')->orWhere('closed', '<>', 1);
        });
    }

    /**
     * Attach perrsistent names to the lunchlist to ensure that full time members are always on there
     */
    public function attachNames()
    {
        DB::table('names')->where('persist', '=', 1)->update(['updated_at' => Carbon::now()]);
        $persistentNames = DB::table('names')->where('persist', '=', 1)->lists('id');
        $this->names()->attach($persistentNames);
    }

    public function getFirstOpenList()
    {
        return $this->queryOpenLists()->first();
    }

    public function getLastOpenList()
    {
        return $this->queryOpenLists()->orderBy('opened_on', 'DESC')->first();
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
