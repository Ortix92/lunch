<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\LunchList;
use App\Name;
use App\Note;
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
        $lunchlists = LunchList::orderBy('id', 'desc')->with('names')->paginate(10);
        return view('lunchlist.index', compact('lunchlists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        \DB::connection()->enableQueryLog();
        // We get the lunchlist of the day which is still open.
        // If it's already closed an empty collection will be returned allowing us to create a new one!
        $q = LunchList::where('opened_on', '>=', Carbon::today())->where(function ($query) {
            $query->whereNull('closed_on')->orWhere('closed', '<>', 1);
        });

        // Let's lazy load the names as well to reduce queries
        $q->with('names');
        $result = $q->get();
//        dd(\DB::getQueryLog());
        if ($result->isEmpty()) {
            // Touch timestamps
            DB::table('names')->where('persist', '=', 1)->update(['updated_at' => Carbon::now()]);

            // Get all the persistent names
            // @todo combine these 2 statements into a single query
            $persistentNames = DB::table('names')->where('persist', '=', 1)->lists('id');
            $lunchlist = new LunchList;
            $lunchlist->save();
            $lunchlist->names()->attach($persistentNames);
        } else {
            $lunchlist = $result->first();
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
        $this->validate($request,
            [
                'name'    => 'required|max:255',
                'persist' => 'sometimes|accepted',
                'veggy'   => 'sometimes|accepted'
            ], [
                'persist.accepted' => 'Brah what are you doing?',
                'veggy.accepted'   => 'Brah what are you doing?',
            ]
        );

        $lunchlist = LunchList::findorFail($request->input('id'));

        // Create a new name and fill the attributes
        $name = Name::firstOrNew(['name' => $request->input('name')]);
        $name->persist = $request->input('persist', 0);
        $name->veggy = $request->input('veggy', 0);
        $name->touch(); // Update timestamp

        // Automatically save to pivot table
        $lunchlist->names()->save($name, ['note' => $request->input('note', '')]);

        // Nothing is actually being saved to the lunchlist model but I'll leave this here for the future
        $lunchlist->save();
        return redirect()->route('lunchlist.edit', $lunchlist->id);
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
        $lunchlist = LunchList::findOrFail($id);
        $lunchlist->names()->detach();
        $lunchlist->delete();
        return redirect('/');
    }
}
