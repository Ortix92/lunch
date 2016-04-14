<?php
Route::group(['middleware' => ['web']], function () {

    Route::get('test', function () {
        $lunchlist = \App\LunchList::find(7)->with('names')->first();
    });

    Route::resource('/', 'LunchListController', ['only' => ['index']]);
    Route::resource('lunchlist', 'LunchListController', ['except' => ['index']]);
    Route::resource('name', 'NameController');

    Route::get('lunchlist/{id}/close', ['as' => 'lunchlist.close', 'uses' => 'LunchListController@close',]);

    /**
     * @todo remove veggy if veggy person is removed from list
     */
});
