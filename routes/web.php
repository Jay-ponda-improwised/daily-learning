<?php

use App\Mail\SMTPTesting;
use Illuminate\Support\Facades\Mail;
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

Route::prefix('/smtp')->group(function () {

    Route::get('/', function () {
        Mail::to(['pondajay637@gmail.com'])->send(new SMTPTesting());
        return (new SMTPTesting())->render();
    })->name('test-mail');
})->name('smtp-demo');


Route::fallback(function () {
    return abort(404);
});
