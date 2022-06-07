<?php

namespace App\Http\Controllers\Consulta;

use App\Helpers\Respuesta;
use App\Http\Controllers\Controller;
use App\Models\Consulta\HistoriaDietetica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriaDieteticaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarHistoriaDietetica($llave)
    {
        $historiaD=HistoriaDietetica::where('id_consulta','=',$llave)
            ->latest()
            ->get();
        return json_decode($historiaD);
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

            $historialD=new HistoriaDietetica;
            $historialD->id_historia_diet=$request->id_historia_diet;
            $historialD->id_consulta=$request->id_consulta;
            $historialD->antecedentes_familiares=$request->antecedentes_familiares;
            $historialD->actividad_fisica=$request->actividad_fisica;
            $historialD->preferencia_alimen=$request->preferencia_alimen;
            $historialD->alimentos_no_gustan=$request->alimentos_no_gustan;
            $historialD->intolerancia_alergia=$request->intolerancia_alergia;
            $historialD->donde_come=$request->donde_come;
            $historialD->quien_cocina=$request->quien_cocina;
            $historialD->estrenimiento=$request->estrenimiento;
            $historialD->horas_sueno=$request->horas_sueno;
            $historialD->alcohol=$request->alcohol;
            $historialD->tabaco=$request->tabaco;
            $historialD->agua=$request->agua;
            $historialD->observacion_menu_anterior=$request->observacion_menu_anterior;
            $historialD->saciedad=$request->saciedad;
            $historialD->alimentos_requiere=$request->alimentos_requiere;
            $historialD->diagnostico_nutricional=$request->diagnostico_nutricional;
            $historialD->save();
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
        $historiaDUpdate=HistoriaDietetica::find($id);
        $historiaDUpdate->update($request->all());
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
