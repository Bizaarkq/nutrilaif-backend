<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\alimento\Alimento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\Respuesta;
use Log;

class AlimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listarAlimentos($llave=null)
    {
        if ($llave==null) {
            $alimentoQuery=Alimento::select(
                'id', 
                'codigo', 
                'nombre', 
                'calorias', 
                'calcio', 
                'carbohidratos', 
                'grasas', 
                'hierro', 
                'potasio', 
                'proteinas', 
                'sodio')
                ->get();
        } else {
            $alimentoQuery=Alimento::select(
                'id', 
                'codigo', 
                'nombre', 
                'calorias', 
                'calcio', 
                'carbohidratos', 
                'grasas', 
                'hierro', 
                'potasio', 
                'proteinas', 
                'sodio'
                )
                ->where('nombre', 'like', '%'.$llave.'%')
                ->latest()
                ->take(15)
                ->get();
        }
        return $alimentoQuery;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       try{
            DB::beginTransaction();

            $alimento= new Alimento;
            $alimento->nombre_alimento=$request->nombre_alimento;
            $alimento->calorias_alimento=$request->calorias_alimento;
            $alimento->grasas_alimento=$request->grasas_alimento;
            $alimento->proteinas_alimento=$request->proteinas_alimento;
            $alimento->carbohidratos_alimento=$request->carbohidratos_alimento;
            $alimento->hierro_alimento=$request->hierro_alimento;
            $alimento->potasio_alimento=$request->potasio_alimento;
            $alimento->calcio_alimento=$request->calcio_alimento;
            $alimento->sodio_alimento=$request->sodio_alimento;
            $alimento->save();

            DB::commit();
            return response()->json([
                'code'=>200,
                'titulo'=>Respuesta::titulo_exito_generico,
                'mensaje'=>Respuesta::mensaje_exito_generico
            ]);
        }catch(\Exception $e){
            report($e);
            DB::rollBack();
            return response()->json([
                'code'=>99,
                'titulo'=>Respuesta::titulo_error_generico,
                'mensaje'=>Respuesta::mensaje_error_generico
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Si lo encuentra actualiza toda la información
        $alimentoUpdate=Alimento::find($id);
        $alimentoUpdate->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fechaBA=Carbon::now();
        $alimentoDelete=Alimento::find($id);
        $alimentoDelete->deleted_at=$fechaBA;
        $alimentoDelete->update();
    }
}
