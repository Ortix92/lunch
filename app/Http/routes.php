<?php
Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return redirect('name'); // Redirect to resource controller
    });
    Route::resource('/', 'LunchListController', ['only' => ['index']]);
    Route::resource('lunchlist', 'LunchListController', ['except' => ['index']]);
    Route::resource('name', 'NameController');
});
