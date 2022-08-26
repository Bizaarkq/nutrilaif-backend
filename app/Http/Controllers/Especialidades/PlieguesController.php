<?php

namespace App\Http\Controllers\Especialidades;

use App\Helpers\Respuesta;
use App\Http\Controllers\Controller;
use App\Models\Consulta\Consulta;
use App\Models\Especialidades\Pliegues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlieguesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarPliegues($llave=null)
    {
        if($llave!=null){
            $pliegues=Pliegues::where('id_consulta','=',$llave)
            ->get();
        }
        else{
            $pliegues=Pliegues::latest()
            ->get();
        }
        return json_decode($pliegues);
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

        $pliegues=new Pliegues;
        $pliegues->id=$request->id;
        $pliegues->id_consulta=$request->id_consulta;
        $pliegues->p_bicipital=$request->p_bicipital;
        $pliegues->p_tricipital=$request->p_tricipital;
        $pliegues->p_sub_escapular=$request->p_sub_escapular;
        $pliegues->p_supra_iliaco=$request->p_supra_iliaco;
        $pliegues->p_abdominal=$request->p_abdominal;
        $pliegues->p_muslo_anterior=$request->p_muslo_anterior;
        $pliegues->p_pierna_medial=$request->p_pierna_medial;
        $pliegues->c_brazo_contraido=$request->c_brazo_contraido;
        $pliegues->c_pierna=$request->c_pierna;
        $pliegues->p_humero=$request->p_humero;
        $pliegues->p_femur=$request->p_femur;
        $pliegues->save();

        DB::commit();
        
        return response()->json([
            'code'=>200,
            'titulo'=>Respuesta::titulo_exito_generico,
            'mensaje'=>Respuesta::mensaje_exito_generico_pliegues
        ]);
        }catch(\Exception $e){
            report($e);
            DB::rollBack();
            return response()->json([
                'code'=>99,
                'titulo'=>Respuesta::titulo_error_generico,
                'mensaje'=>Respuesta::mensaje_error_pliegues
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
        $plieguesUpdate=Pliegues::find($id);
        $plieguesUpdate->update($request->all());
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
    public function getPliegues($id){
        try{
            /*Obtiene las últimas 5 pliegues de un paciente*/
            $pliegues=Consulta::
                join('pliegues','pliegues.id_consulta','consulta.id')
                ->where('consulta.id_paciente','=',$id)
                ->select(
                    'pliegues.id',
                    'id_consulta',
                    'p_bicipital',
                    'p_tricipital',
                    'p_sub_escapular',
                    'p_supra_iliaco',
                    'p_abdominal',
                    'p_muslo_anterior',
                    'p_pierna_medial',
                    'c_brazo_contraido',
                    'c_pierna',
                    'p_humero',
                    'p_femur',
                    'pliegues.created_at as fecha'
                )->orderByDesc('pliegues.created_at')->limit(5)->get();
                return $pliegues;
                
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'code'=>99,
                'titutlo'=>Respuesta::titulo_error_generico,
                'mensaje'=>Respuesta::error_obt_pliegues
            ]);
        }
    }
}
