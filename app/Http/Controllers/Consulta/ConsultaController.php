<?php

namespace App\Http\Controllers\Consulta;

use App\Helpers\Respuesta;
use App\Http\Controllers\Controller;
use App\Models\Consulta\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarConsulta($llave=null)
    {
        if($llave==null){
            $nutri=Auth::user()->id;
            $consultas=Consulta::select('created_at')
            ->where('nutricionista_consulta.id_nutric','=',$nutri)
            ->latest()
            ->paginate(15)
            ->get();
        
        }
        else{
            $nutri=Auth::user()->id;
            $consultas=Consulta::select('created_at')
            ->where([['nutricionista_consulta.id_nutric','=',$nutri],['id_paciente','=',$llave],])
            ->latest()
            ->paginate(10)
            ->get();
        }
        return json_decode($consultas);
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

            $consulta=new Consulta;
            $consulta->id_consulta=$request->id_consulta;
            $consulta->id_nutric=$request->id_nutric;
            $consulta->id_paciente=$request->id_paciente;
            $consulta->frecuencia_consumo=$request->frecuencia_consumo;
            $consulta->recordatorio=$request->recordatorio;
            $consulta->fecha_dieta=$request->fecha_dieta;
            $consulta->es_borrador=$request->es_borrador;
            $consulta->save();

            DB::commit();

            return response()->json([
                'code'=>200,
                'titulo'=>Respuesta::titulo_exito_generico,
                'mensaje'=>Respuesta::mensaje_exito_generico
            ]);
        } catch(\Exception $e){
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
            $consultaUpdate=Consulta::find($id);
            if($request->es_borrador!=0){
                $consultaUpdate->update($request->all());
                DB::commit();

                return response()->json([
                    'code'=>200,
                    'titulo'=>Respuesta::titulo_exito_generico,
                    'mensaje'=>Respuesta::mensaje_exito_generico
                ]);
            }
            else{
                DB::rollBack();
                return response()->json([
                    'code'=>99,
                    'titulo'=>Respuesta::titulo_error_generico,
                    'mensaje'=>Respuesta::mensaje_error_generico
                ]);
            }
        } catch(\Exception $e){
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
