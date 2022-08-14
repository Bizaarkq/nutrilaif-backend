<?php

namespace App\Http\Controllers;

use App\Models\Catalogo\Departamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Catalogo\MenuInicio;
use App\Helpers\Estados;

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
        $listaPaises = DB::table('nutri_catalog.pais')
        ->select('codigo', 'nombre')
        ->orderBy('nombre', 'asc')
        ->get();
        return $listaPaises;
    }

    public function getEstadosByEstadoActual($estadoActual = null){
        $listadoEstados = null;
        if($estadoActual == null){
            $listadoEstados = DB::table('nutri_catalog.estados_consulta')
            ->select('codigo', 'opcion')
            ->where('estado_previo', Estados::BORRADOR_CONSULTA)
            ->orderBy('opcion', 'desc')
            ->get();
        }else{
            $listado = DB::table('nutri_catalog.estados_consulta')
            ->select('estado_posterior')
            ->where('codigo', '=', $estadoActual)
            ->first();

            $listado = explode(',',$listado->estado_posterior);
            $listadoEstados = DB::table('nutri_catalog.estados_consulta')
            ->whereIn('codigo', $listado)
            ->select('codigo', 'opcion')
            ->get();
        }

        return $listadoEstados;
    }

}
