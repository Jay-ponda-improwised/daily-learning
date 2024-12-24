<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('welcome');
});

Route::controller(App\Http\Controllers\RedisTesting::class)
    ->prefix('/redis')
    ->group(function (){

    // get view
    Route::get('/', function(){
        return redirect('/redis/1');
    })->name('home-base');

    Route::get('/{id}', 'show')->name('home');

    // add key-value pair
    Route::post('/{id}/upsert/{key}', 'store')->name('store');

    // get key-value pair
    Route::get('/{id}/get/{key}', 'index')->name('index');

    // get all key-value pairs
    Route::get('/{id}/all', 'getAllKeys')->name('all');

})->name('redis-demo.');


Route::fallback(function () {
    return abort(404);
});
