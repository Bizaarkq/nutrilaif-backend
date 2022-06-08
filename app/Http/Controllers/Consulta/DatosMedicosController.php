<?php

namespace App\Http\Controllers\Consulta;

use App\Helpers\Respuesta;
use App\Http\Controllers\Controller;
use App\Models\Consulta\DatosMedicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatosMedicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarDatosMedicos($llave)
    {
        $datosMedicos=DatosMedicos::where('id_consulta','=',$llave)
            ->latest()
            ->get();
        return json_decode($datosMedicos);
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

            $datosMedicos=new DatosMedicos;
            $datosMedicos->id_datos_medic=$request->id_datos_medic;
            $datosMedicos->id_consulta=$request->id_consulta;
            $datosMedicos->diagnostico_medic=$request->diagnostico_medic;
            $datosMedicos->medicamento_suplemento=$request->medicamento_suplemento;
            $datosMedicos->otros_datos_medic=$request->otros_datos_medic;
            $datosMedicos->save();

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
        $datosMUpdate=DatosMedicos::find($id);
        $datosMUpdate->update($request->all());
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
