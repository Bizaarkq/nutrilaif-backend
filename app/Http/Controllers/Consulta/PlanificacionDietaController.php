<?php

namespace App\Http\Controllers\Consulta;

use App\Helpers\Respuesta;
use App\Http\Controllers\Controller;
use App\Models\Consulta\PlanificacionDieta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanificacionDietaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarPlanificacionDieta($llave)
    {
        $planificacion=DB::table('dieta')
            ->join('planificacion_dieta','planificacion_dieta.id','dieta.id_planif_dieta')
            ->where('dieta.id_planif_dieta','like',$llave)
            ->get();

        return json_decode($planificacion);
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

            $planificacionD=new PlanificacionDieta;
            $planificacionD->id=$request->id;
            $planificacionD->id_consulta=$request->id_consulta;
            $planificacionD->requerimiento_energetico=$request->requerimiento_energetico;
            $planificacionD->calorias_prescribir=$request->calorias_prescribir;
            $planificacionD->choc=$request->choc;
            $planificacionD->chon=$request->chon;
            $planificacionD->cooh=$request->cooh;
            $planificacionD->prescripcion_dieta=$request->prescripcion_dieta;
            $planificacionD->save();

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
        $planificacionUpdate=PlanificacionDieta::find($id);
        $planificacionUpdate->update($request->all());
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
