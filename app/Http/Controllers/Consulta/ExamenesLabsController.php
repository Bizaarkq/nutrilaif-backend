<?php

namespace App\Http\Controllers\Consulta;

use App\Helpers\Respuesta;
use App\Http\Controllers\Controller;
use App\Models\Consulta\ExamenLabs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamenesLabsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarExamenes($llave)
    {
        $examenes=ExamenLabs::where('id_consulta','=',$llave)
            ->latest()
            ->get();
        return json_decode($examenes);
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

            $examenMedic=new ExamenLabs;
            $examenMedic->id=$request->id;
            $examenMedic->id_consulta=$request->id_consulta;
            $examenMedic->hemoglobina=$request->hemoglobina;
            $examenMedic->linfocitos=$request->linfocitos;
            $examenMedic->hba_1c=$request->hba_1c;
            $examenMedic->creatinina=$request->creatinina;
            $examenMedic->trigliceridos=$request->trigliceridos;
            $examenMedic->colesterol_total=$request->colesterol_total;
            $examenMedic->chdl=$request->chdl;
            $examenMedic->cldl=$request->cldl;
            $examenMedic->glucosa_ayuno=$request->glucosa_ayuno;
            $examenMedic->glucosa_post_pondrial=$request->glucosa_post_pondrial;
            $examenMedic->acido_urico=$request->acido_urico;
            $examenMedic->albumina=$request->albumina;
            $examenMedic->save();
        
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
        $examenUpdate=ExamenLabs::find($id);
        $examenUpdate->update($request->all());
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
