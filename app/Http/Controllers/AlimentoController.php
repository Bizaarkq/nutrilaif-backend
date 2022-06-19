<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\alimento\Alimento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\Respuesta;
use Illuminate\Support\Facades\Auth;
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
            $user = Auth::user()->USERNAME;

            $alimento= new Alimento;
            $alimento->nombre=$request->nombre;
            $alimento->codigo=$request->codigo;
            $alimento->calorias=$request->calorias;
            $alimento->grasas=$request->grasas;
            $alimento->proteinas=$request->proteinas;
            $alimento->carbohidratos=$request->carbohidratos;
            $alimento->hierro=$request->hierro;
            $alimento->potasio=$request->potasio;
            $alimento->calcio=$request->calcio;
            $alimento->sodio=$request->sodio;
            $alimento->created_user=$user;
            $alimento->updated_user=$user;
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
    public function update(Request $request)
    {
        //Si lo encuentra actualiza toda la información
        $alimento = $request->post();
        try {
            DB::beginTransaction();
            Alimento::where('codigo', '=', $alimento['codigo'])->update($alimento);
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
        //$alimentoUpdate->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id_alimento = $request->post();
        $fechaBA=Carbon::now();
        DB::beginTransaction();
        Alimento::where('codigo','=', $id_alimento[0])->update(['deleted_at'=>$fechaBA]);
        DB::commit();
    }
}
