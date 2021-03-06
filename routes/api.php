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
        Route::get('/list/{llave?}', 'App\Http\Controllers\Expediente\PacienteController@listarPacientes')->name('lista-pacientes');
        Route::delete('/delete/{id?}', 'App\Http\Controllers\Expediente\PacienteController@deletePaciente')->name('delete-paciente');
    });
    
    Route::prefix('catalogo')->group(function(){
        Route::get('/alimento/listar/{llave?}', 'App\Http\Controllers\AlimentoController@listarAlimentos')->name('listar-alimentos');
        Route::post('/alimento/store', 'App\Http\Controllers\AlimentoController@store')->name('guardar-alimento');
        Route::post('/alimento/update', 'App\Http\Controllers\AlimentoController@update')->name('editar-alimento');
        Route::post('/alimento/delete', 'App\Http\Controllers\AlimentoController@destroy')->name('eliminar-alimento');

        Route::get('/menu', 'App\Http\Controllers\CatalogController@getMenu')->name('obtener-menu');
        Route::get('/departamentos', 'App\Http\Controllers\CatalogController@getDepartamentos')->name('obtener-departamentos');
        Route::get('/municipios/{id}', 'App\Http\Controllers\CatalogController@getMunicipios')->name('obtener-municipios');
    });

    Route::prefix('consulta')->group(function(){
        Route::post('/save/{id?}', 'App\Http\Controllers\Consulta\ConsultaController@guardarConsulta')->name('guardar-consulta');
        Route::post('/update/{id}', 'App\Http\Controllers\Consulta\ConsultaController@editarConsulta')->name('editar-consulta');
        Route::get('/get/{id}', 'App\Http\Controllers\Consulta\ConsultaController@getConsulta')->name('obtener-consulta');
        Route::get('/list/{id?}', 'App\Http\Controllers\Consulta\ConsultaController@listarConsulta')->name('listar-consulta');
    });

    Route::prefix('alimento')->group(function(){
        Route::post('/store', 'App\Http\Controllers\AlimentoController@store')->name('alimento');
        Route::get('/list', 'App\Http\Controllers\AlimentoController@listarAlimentos')->name('lista-alimentos');
        Route::get('/update','App\Http\Controllers\AlimentoController@update')->name('editar-alimento');
        Route::get('/delete','App\Http\Controllers\AlimentoController@update')->name('eliminar-alimento');
        });
        

});
