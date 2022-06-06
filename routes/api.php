<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;

//endpoint publico
//Route::post('/paciente', 'App\Http\Controllers\PacienteController@store')->name('paciente');





Route::group(['middleware' => 'auth:api'], function () {
    //Route::post('/paciente', 'App\Http\Controllers\PacienteController@store')->name('paciente');
    Route::prefix('paciente')->group(function(){
    Route::post('/store', 'App\Http\Controllers\PacienteController@store')->name('paciente');
    Route::get('/list', 'App\Http\Controllers\PacienteController@listarPacientes')->name('lista-pacientes');
    });
    
});
