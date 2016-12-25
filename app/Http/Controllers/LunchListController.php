<?php

namespace App\Http\Controllers;

use App\LunchList;
use App\Name;
use App\Note;
use Illuminate\Http\Request;

/**
 * Class LunchListController
 * In this class we always automatically create a lunchlist. Instead, we store and update the names in the lunchlist
 * @package App\Http\Controllers
 */
class LunchListController extends Controller
{
    protected $lunchList;

    public function __construct(LunchList $lunchList)
    {
        $this->lunchList = $lunchList;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lunchlists = LunchList::orderBy('id', 'desc')->with('names')->paginate(2);
        $hasOpen = $this->lunchList->hasOpen();
        return view('lunchlist.index', compact('lunchlists', 'hasOpen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // In case user tries to open a new lunchlist while another one is open
        // redirect to the first open list. We sacrifice 'speed' for readability here
        // since all these queries and routines can be combined.
        $lunchlist = $this->lunchList->getFirstOpenList();
        if ($lunchlist) {
            return redirect()->route('lunchlist.edit', $lunchlist->id);
        }
        \DB::connection()->enableQueryLog();
//        dd(\DB::getQueryLog());

        $lunchlist = new LunchList;
        $lunchlist->save();

        // In case we have a dinner list we want a fresh list without the persistent names
        if (request('dinner')) {
            $lunchlist->dinner = 1;
            $lunchlist->save();
            return view('lunchlist.edit', compact('lunchlist'));
        }

        // Otherwise we run some hidden uggly queries and attach the names to the list
        $lunchlist->attachNames();

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

        $lunchlist = $this->lunchList->findorFail($request->input('id'));

        // Create a new name and fill the attributes
        $name = Name::firstOrNew(['name' => $request->input('name')]);

        // We only update the persistence of the user in the case that the list is not a dinner list
        if (!$lunchlist->dinner) {
            $name->persist = $request->input('persist', 0);
        }

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
        $lunchlist = $this->lunchList->findOrFail($id);

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
        $lunchlist = $this->lunchList->findOrFail($id);
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
        $lunchlist = $this->lunchList->findOrFail($id);
        $lunchlist->names()->detach();
        $lunchlist->delete();
        return redirect('/');
    }
}
