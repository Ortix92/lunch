<?php
Route::group(['middleware' => ['web']], function () {
    Route::get('/', function() {
        return redirect('name'); // Redirect to resource controller
    });
    Route::resource('name','NameController');
});
