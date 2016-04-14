<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\LunchList;
use App\Name;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class LunchListController
 * In this class we always automatically create a lunchlist. Instead, we store and update the names in the lunchlist
 * @package App\Http\Controllers
 */
class LunchListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lunchlist.index', ['lists' => LunchList::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*
         * Users::where('name', 'John')->where(function($query){
        *  $query->where('votes', '>', 100)->orWhere('title', '<>', 'Admin);
        *  })->get();
         */
        // We get the lunchlist of the day which is still open.
        // If it's already closed an empty collection will be returned allowing us to create a new one!
        $q = LunchList::whereNull('closed_on')->where([
            ['opened_at', '>=', Carbon::today()]
        ])->with('names')->get();

        if ($q->isEmpty()) {
            $persistentNames = DB::table('names')->where('persist', '=', 1)->lists('id');
            $lunchlist = new LunchList;
            $lunchlist->save();
            $lunchlist->names()->attach($persistentNames);
        } else {
            $lunchlist = $q->first();
        }


        return view('lunchlist.edit', compact('lunchlist'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lunchlist = LunchList::findorFail($request->input('id'));

        $name = Name::firstOrNew(['name' => $request->input('name')]);
        $lunchlist->veggy = $request->input('veggy', 0);

        $lunchlist->names()->save($name);
        $lunchlist->save();
        return view('lunchlist.edit', compact('lunchlist'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lunchlist = LunchList::findOrFail($id);

        return view('lunchlist.edit', compact('lunchlist'));
    }

    /**
     * This method is not used. It's always the show() method so we redirect to the 'show' route
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('lunchlist.edit', [$id]);
    }

    public function close($id)
    {
        $lunchlist = LunchList::findOrFail($id);
        $lunchlist->close();
        $lunchlist->save();
        return redirect()->route('lunchlist.show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
