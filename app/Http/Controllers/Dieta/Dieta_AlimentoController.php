<?php

namespace App\Http\Controllers\Dieta;

use App\Helpers\Respuesta;
use App\Http\Controllers\Controller;
use App\Models\Dieta\Dieta_Alimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dieta_AlimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarDietaAlim($llave)
    {
        $dietaA=DB::table('alimentos')
        ->join('dieta_alimento','dieta_alimento.id_alimento','alimentos.id')
        ->where('alimentos.id','=',$llave)
        ->get();
        return json_decode($dietaA);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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

            $dieta=new Dieta_Alimento;
            $dieta->id_alimento=$request->id_alimento;
            $dieta->id_dieta=$request->id_dieta;
            $dieta->tiempo_comida=$request->tiempo_comida;
            $dieta->dia_comida=$request->dia_comida;
            $dieta->cantidad=$request->cantidad;
            $dieta->unidad_medida=$request->unidad_medida;
            $dieta->save();
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
        try{
            DB::beginTransaction();
            $dietaUpdate=Dieta_Alimento::find($id);
            $dietaUpdate->update($request->all());
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
