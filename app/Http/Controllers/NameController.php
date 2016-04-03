<?php

namespace App\Http\Controllers;

use App\LunchList;
use App\Name;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NameController extends Controller
{
    /**
     * @var Name
     */
    private $name;

    /**
     * NameController constructor.
     * @param Name $name
     */
    public function __construct(Name $name)
    {
        $this->name = $name;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->createList();
        return view('names', [
            'names' => Name::orderBy('created_at', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        $this->name->name = $request->name;

        // Stupid server doesn't run PHP7 yet..
        $this->name->persist = $request->persist;
        if (!$request->persist) {
            $this->name->persist = 0;
        }
        $this->name->save();

        return redirect('/name');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $this->name->findOrFail($id)->delete();
        return redirect('/name');
    }

    private function createList()
    {
        $lists = LunchList::all();
        if ($lists->isEmpty()) {
            $list = new LunchList();
        } else {
            $list = $lists->last();
        }
        $list->opened_on = Carbon::now();
        $list->save();
    }
}
