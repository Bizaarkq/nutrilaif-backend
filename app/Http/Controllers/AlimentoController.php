<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\alimento\Alimento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AlimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listarAlimentos($llave=null)
    {
        if($llave==null){
            $alimentoQuery=Alimento::all();
        }
        else{
            $alimentoQuery=Alimento::select('nombre_alimento')
                ->where('nombre_alimento','=','%'.$llave.'%')
                ->latest()
                ->take(15)
                ->get();
        }
        return json_encode($alimentoQuery);
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
