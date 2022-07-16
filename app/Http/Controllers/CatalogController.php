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

    public function getDepartamentos(){
        return Departamento::all();
    }

    public function getMunicipios($id){
        return Departamento::find($id)->municipios;
    }

}
