<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Departamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Catalogo\MenuInicio;

class CatalogController extends Controller
{
    
    public function getMenu(){
        return MenuInicio::all();
    }

    public function getDepartamentos($codigo){
        return Departamento::where('cod_pais', $codigo)
        ->select('id', 'nombre', 'cod_departamento')
        ->orderBy('nombre', 'asc')
        ->get();
    }

    public function getMunicipios($id){
        return Departamento::find($id)->municipios;
    }

    public function getFrecuenciaBase(){
        $listaBase=DB::table('nutri_catalog.alimentos_frecuencia_base')
        ->select('nombre')->orderBy('id','asc')->get();
        return $listaBase;
    }
    
    public function getPaises(){
        $listaPaises=DB::table('nutri_catalog.pais')
        ->select('codigo', 'nombre')
        ->orderBy('nombre', 'asc')
        ->get();
        return $listaPaises;
    }

}
