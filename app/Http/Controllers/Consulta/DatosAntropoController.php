<?php

namespace App\Http\Controllers\Consulta;

use App\Helpers\Respuesta;
use App\Http\Controllers\Controller;
use App\Models\Consulta\DatosAntropo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatosAntropoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarDatosAntropo($llave=null)
    {
        if($llave==null){

            $datosAntropo=DatosAntropo::where('id_consulta','=',$llave)
            ->get();
        }else{
            $datosAntropo=DatosAntropo::latest()
            ->get();
        }
        return json_decode($datosAntropo);
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

            $datosAntropo=new DatosAntropo;
            $datosAntropo->id=$request->id;
            $datosAntropo->id_consulta=$request->id_consulta;
            $datosAntropo->peso_actual=$request->peso_actual;
            $datosAntropo->peso_ideal=$request->peso_ideal;
            $datosAntropo->p_grasa_corporal=$request->p_grasa_corporal;
            $datosAntropo->p_masa_muscular=$request->p_masa_muscular;
            $datosAntropo->p_grasa_visceral=$request->p_grasa_visceral;
            $datosAntropo->peso_meta=$request->peso_meta;
            $datosAntropo->talla=$request->talla;
            $datosAntropo->c_cintura=$request->c_cintura;
            $datosAntropo->c_cadera=$request->c_cadera;
            $datosAntropo->c_muneca=$request->c_muneca;
            $datosAntropo->c_brazo_relajado=$request->c_brazo_relajado;
            $datosAntropo->edad_metabolica=$request->edad_metabolica;
            $datosAntropo->imc=$request->imc;
            $datosAntropo->save();

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
        $datosAUpdate=DatosAntropo::find($id);
        $datosAUpdate->update($request->all());
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
