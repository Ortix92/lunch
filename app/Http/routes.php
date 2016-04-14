<?php
Route::group(['middleware' => ['web']], function () {

    Route::get('test', function () {
        $lunchlist = \App\LunchList::find(7)->with('names')->get()->first();
    });

    Route::resource('/', 'LunchListController', ['only' => ['index']]);
    Route::resource('lunchlist', 'LunchListController', ['except' => ['index']]);
    Route::resource('name', 'NameController');
});
