<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

*/

Route::group(['middleware' => 'auth:api'], function () {
    //Route::post('/paciente', 'App\Http\Controllers\PacienteController@store')->name('paciente');
    Route::prefix('paciente')->group(function(){
        Route::post('/store', 'App\Http\Controllers\PacienteController@store')->name('paciente');
        Route::get('/list', 'App\Http\Controllers\PacienteController@listarPacientes')->name('lista-pacientes');
    });
    
});