<?php
Route::group(['middleware' => ['web', 'auth.basic']], function () {

    Route::resource('stats','StatController');

    Route::get('test', function () {
        $lunchlist = \App\LunchList::find(33);
        dd($lunchlist->names()->detach());
    });

    Route::resource('/', 'LunchListController', ['only' => ['index']]);
    Route::resource('lunchlist', 'LunchListController', ['except' => ['index']]);
    Route::resource('name', 'NameController');

    Route::get('lunchlist/{id}/close', ['as' => 'lunchlist.close', 'uses' => 'LunchListController@close',]);
    Route::get('logout', function () {
        Auth::logout();
        return redirect('/');
    });

    /**
     * @todo remove veggy if veggy person is removed from list
     * @todo prevent double name entry
     */
});
