<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\LunchList;
use App\Name;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        // Get today's lunchlist if it exists. Otherwise create it.
        $q = LunchList::where('opened_at', '>=', Carbon::today())->with('names')->get();

        if ($q->isEmpty()) {
            $lunchlist = new LunchList;
            $lunchlist->save();
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
        $lunchlist->names()->save($name);
        return view('lunchlist.edit', compact('lunchlist'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lunchlist = LunchList::findOrFail($id)->first();
        return view('lunchlist.edit',compact('lunchlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('lunchlist.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
