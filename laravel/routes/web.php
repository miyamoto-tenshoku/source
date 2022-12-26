<?php

use Illuminate\Support\Facades\Route;

Route::get('/sendmail',
    '\App\Http\Controllers\SendmailController@index'
)->name('sendmail');

Route::post('/sendmail',
    '\App\Http\Controllers\SendmailController@post'
);

Route::get('/outputdb',
    '\App\Http\Controllers\OutputdbController@index'
)->name('outputdb');

Route::fallback(function(){
    return abort(404);
});
