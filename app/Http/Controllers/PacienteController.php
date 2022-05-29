<?php

namespace App\Http\Controllers;

use App\Models\expediente\Paciente;
use Illuminate\Http\Request;
use Ulid\Ulid;
use Log;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarPacientes()
    {
        //Lista de pacientes enviada como json
        $listaPaciente=Paciente::all();
        $data=['success'=>true, 'listaP'=>$listaPaciente];
        return response()->json($data,200);
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
        $paciente = new Paciente;
        $paciente->id = Ulid::generate(true);
        $paciente->nombre = $request->nombre;
        $paciente->apellidos = $request->apellidos;
        $paciente->correo = $request->correo;
        $paciente->direccion = $request->direccion;
        $paciente->fecha_nacimiento=$request->fecha_nacimiento;
        $paciente->numero_exp = $request->numero_exp;
        $paciente->sexo = $request->sexo;
        $paciente->telefono = $request->telefono;
        $paciente->save();
        return $request;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
