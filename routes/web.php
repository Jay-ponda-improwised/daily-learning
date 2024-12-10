<?php

use Illuminate\Support\Facades\Redis;

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('welcome');
});

Route::group(['prefix' => 'redis'], function () {

    // get view
    Route::get('/', function () {
        return view('redis', ['redis' => [
            'laravel' => 'redis',
        ]]);
    });

    // add key-value pair
    Route::post('/{id}/upsert/{key}', [App\Http\Controllers\RedisTesting::class, 'store']);

    // get key-value pair
    Route::get('/{id}/get/{key}', [App\Http\Controllers\RedisTesting::class, 'index']);
});
