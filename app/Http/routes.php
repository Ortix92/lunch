<?php
Route::group(['middleware' => ['web','auth.basic']], function () {

    Route::get('test', function () {
        $lunchlist = \App\LunchList::with('names')->first()->isVeggy();
        dd($lunchlist);
    });

    Route::resource('/', 'LunchListController', ['only' => ['index']]);
    Route::resource('lunchlist', 'LunchListController', ['except' => ['index']]);
    Route::resource('name', 'NameController');

    Route::get('lunchlist/{id}/close', ['as' => 'lunchlist.close', 'uses' => 'LunchListController@close',]);

    /**
     * @todo remove veggy if veggy person is removed from list
     */
});
