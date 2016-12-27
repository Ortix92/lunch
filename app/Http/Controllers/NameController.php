<?php

namespace App\Http\Controllers;

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
        $this->validate($request,
            [
                'persist' => 'required|boolean',
            ], [
                'persist.accepted' => 'Brah what are you doing?',
            ]
        );
        $name = $this->name->findOrFail($id);
        $name->persist = $request->persist;
        $name->save();
        // Remove entry from the pivot table
        $name->lunchLists()->detach($request->list_id);

        // @todo message flashing on user delete not working
        if ($name->persist) {
            $request->session()->flash('status', ucfirst($name->name) . ' has been removed from the current list.');
        } else {
            $request->session()->flash('status', ucfirst($name->name) . ' has been unsubscribed from all lunch lists');
        }
        return redirect()->route('lunchlist.show', ['lunch_id' => $request->list_id]);
    }

}
