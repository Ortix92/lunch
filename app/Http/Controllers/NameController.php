<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Name;
use Illuminate\Http\Request;

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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $name = $this->name->findOrFail($id);

        // Remove entry from the pivot table
        $name->lunchLists()->detach($request->list_id);
        $name->delete();

        return redirect()->route('lunchlist.show', ['lunch_id' => $request->list_id]);
    }

}
