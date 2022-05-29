<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;

//endpoint publico
//Route::post('/paciente', 'App\Http\Controllers\PacienteController@store')->name('paciente');


// endpoint protegido
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/paciente', 'App\Http\Controllers\PacienteController@store')->name('paciente');
    // more endpoints ...
});
