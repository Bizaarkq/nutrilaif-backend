<?php

namespace App\Http\Controllers\Expediente;

use App\Http\Controllers\Controller;
use App\Models\Expediente\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ulid\Ulid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\Respuesta;

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
        $nutri=Auth::user()->id;
        /*ACÁ TIENE QUE IR LA LÓGICA DE  COMO USAR EL ID DEL NUTRICIONISTA CON LA LLAVE FORANEA
        QUE TIENE EL PACIENTE PARA SACAR LOS QUE SOLO SON DE ESTE NUTRICIONISTA*/
        $pacientes = DB::table('nutricionista_paciente')
        ->join('paciente', 'paciente.id', 'nutricionista_paciente.id_paciente')
        ->where('nutricionista_paciente.id_nutric', '=', $nutri)
        ->select('paciente.nombre', 'paciente.id')
        ->get();
        return json_encode($pacientes);
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
        try {
            DB::beginTransaction();

            $paciente = new Paciente;
            $paciente->id = Ulid::generate(true);
            $paciente->nombre = $request->nombre;
            $paciente->apellido = $request->apellidos;
            $paciente->correo = $request->correo;
            $paciente->direccion = $request->direccion;
            $paciente->fecha_nacimiento=$request->fecha_nacimiento;
            $paciente->numero_exp = $request->numero_exp;
            $paciente->sexo = $request->sexo;
            $paciente->telefono = $request->telefono;
            $paciente->save();

            DB::commit();
            
            return response()->json([
                'code' => 200,
                'titulo' => Respuesta::titulo_exito_generico,
                'mensaje' => Respuesta::mensaje_exito_generico
            ]);
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return response()->json([
                'code' => 99,
                'titulo' => Respuesta::titulo_error_generico,
                'mensaje' => Respuesta::mensaje_error_generico
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