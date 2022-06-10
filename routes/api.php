<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\expediente\PacienteController;

//endpoint publico
//Route::post('/paciente', 'App\Http\Controllers\PacienteController@store')->name('paciente');


Route::group(['middleware' => 'auth:api'], function () {
    //Route::post('/paciente', 'App\Http\Controllers\PacienteController@store')->name('paciente');
    Route::prefix('paciente')->group(function(){
        Route::post('/store', 'App\Http\Controllers\Expediente\PacienteController@store')->name('paciente');
        Route::get('/list', 'App\Http\Controllers\Expediente\PacienteController@listarPacientes')->name('lista-pacientes');
    });
    
    Route::prefix('catalogo')->group(function(){
        Route::get('/alimento/listar/{llave?}', 'App\Http\Controllers\AlimentoController@listarAlimentos')->name('listar-alimentos');
        Route::post('/alimento/store', 'App\Http\Controllers\AlimentoController@store')->name('guardar-alimento');
        Route::post('/alimento/update', 'App\Http\Controllers\AlimentoController@update')->name('editar-alimento');
        Route::get('/alimento/{id}', 'App\Http\Controllers\AlimentoController@destroy')->name('eliminar-alimento');
        
    });
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('alimento')->group(function(){
    Route::post('/store', 'App\Http\Controllers\AlimentoController@store')->name('alimento');
    Route::get('/list', 'App\Http\Controllers\AlimentoController@listarAlimentos')->name('lista-alimentos');
    Route::get('/update','App\Http\Controllers\AlimentoController@update')->name('editar-alimento');
    Route::get('/delete','App\Http\Controllers\AlimentoController@update')->name('eliminar-alimento');
    });
    
});