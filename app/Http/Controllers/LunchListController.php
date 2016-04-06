<?php

namespace App\Http\Controllers;

use App\LunchList;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        \DB::connection()->enableQueryLog();
        $q = LunchList::where('opened_on', '=', date('now'))->get(); // needs fixing
        dd($q);
        dd(\DB::getQueryLog());
        if ($q->isEmpty()) {
            $lunchlist = new LunchList;
            $lunchlist->save();
        } else {
            $lunchlist = $q->first();
        }
        dd($lunchlist);
        return view('lunchlist.edit', compact('lunchlist'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(
        Request $request
    ) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show(
        $id
    ) {
        return view('lunchlist.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit(
        $id
    ) {
        return view('lunchlist.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(
        Request $request,
        $id
    ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(
        $id
    ) {
        //
    }
}
