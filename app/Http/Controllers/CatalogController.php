<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Departamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Catalogo\MenuInicio;
use Arcanedev\LogViewer\Entities\Log as EntitiesLog;

class CatalogController extends Controller
{
    
    public function getMenu(){
        return MenuInicio::all();
    }

    public function getDepartamentos(){
        return Departamento::all();
    }

    public function getMunicipios($id){
        return Departamento::find($id)->municipios;
    }
    public function getFrecuenciaBase(){
        $listaBase=DB::table('nutri_catalog.alimentos_frecuencia_base')
        ->select('nombre')->orderBy('id','asc')->get();
        Log::warning(gettype($listaBase));
        return $listaBase;
    }

}
