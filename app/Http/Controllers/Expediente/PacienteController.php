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
use \PDF;
use Storage;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarPacientes($llave=null)
    {
        //Lista de pacientes enviada como json
        $nutri=Auth::user()->ID;
        $query = DB::table('nutricionista_paciente')
        ->join('paciente', 'paciente.id', 'nutricionista_paciente.id_paciente')
        ->where('nutricionista_paciente.id_nutric', '=', $nutri)
        ->where('paciente.deleted_at', '=', null);

        if($llave==null){
            $pacientes = $query
            ->select( 
                'paciente.numero_exp',
                DB::raw("CONCAT(paciente.nombre, ' ', paciente.apellido) AS nombre_completo"),
                'paciente.nombre',
                'paciente.apellido',
                'paciente.id',
                'paciente.correo',
                'paciente.telefono',
                'paciente.inactivo',
                'paciente.mujerEmbLac'
            )
            ->orderBy('paciente.inactivo', 'asc')
            ->orderByDesc('paciente.created_at')
            ->get();
        }else{
            $pacientes = $query->where('paciente.id', '=', $llave)->get();
            if(!count($pacientes)>0){
                $pacientes = $query->orWhere('paciente.numero_exp', '=', $llave)->get();
                if(!count($pacientes)>0){
                    $pacientes = $query->orWhere('paciente.nombre', 'like', '%'.$llave.'%')
                    ->orWhere('paciente.apellido', 'like', '%'.$llave.'%')
                    ->get();
                }
            }
            $pacientes = $query
            ->join('nutri_catalog.municipios as munic', 'munic.id', 'paciente.municipio')
            ->join('nutri_catalog.departamentos as dep', 'dep.id', 'munic.id_departamento')
            ->join('nutri_catalog.pais as pais', 'pais.codigo', 'dep.cod_pais')
            ->select(
                'paciente.id',
                'paciente.numero_exp',
                DB::raw("CONCAT(paciente.nombre, ' ', paciente.apellido) AS nombre_completo"),
                'paciente.nombre',
                'paciente.apellido',
                'paciente.fecha_nacimiento',
                'paciente.correo',
                'paciente.sexo',
                'paciente.telefono',
                'paciente.direccion',
                'munic.id as municipio',
                'dep.id as departamento',
                'pais.codigo as pais',
                'paciente.ocupacion',
                'paciente.municipio',
                'paciente.edad',
                'paciente.fecha_creacion as fechaExpediente',
                'paciente.mujerEmbLac'
            )->get();
        }
        
        return json_encode($pacientes);
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
            $paciente->nombre = $request->nombre;
            $paciente->apellido = $request->apellidos;
            $paciente->correo = $request->correo;
            $paciente->direccion = $request->direccion;
            $paciente->municipio = $request->municipio;
            $paciente->fecha_nacimiento=$request->fecha_nacimiento;
            $paciente->numero_exp = $request->numero_exp;
            $paciente->sexo = $request->sexo;
            $paciente->telefono = $request->telefono;
            $paciente->mujerEmbLac=$request->mujerEmbLac;
            $paciente->save();

            DB::commit();
            
            return response()->json([
                'code' => 200,
                'titulo' => Respuesta::titulo_exito_generico,
                'mensaje' => Respuesta::mensaje_exito_generico_expediente
            ]);
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return response()->json([
                'code' => 99,
                'titulo' => Respuesta::titulo_error_generico,
                'mensaje' => Respuesta::mensaje_error_expediente
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updatePaciente(Request $request)
    {
        $paciente = $request->post();
        try {
            DB::beginTransaction();
            Paciente::where('numero_exp', '=', $paciente['numero_exp'])->update(
                [
                    'telefono' => $paciente['telefono'],
                    'nombre' => $paciente['nombre'],
                    'apellido' => $paciente['apellido'],
                    'direccion' => $paciente['direccion'],
                    'fecha_nacimiento' => $paciente['fecha_nacimiento'],
                    'sexo' => $paciente['sexo'],
                    'correo' => $paciente['correo'],
                    'municipio' => $paciente['municipio'],
                    'edad' => $paciente['edad'],
                    'ocupacion' => $paciente['ocupacion'],
                    'mujerEmbLac' => $paciente['mujerEmbLac']
                ]
            );
            DB::commit();
            
            return response()->json([
                'code' => 200,
                'titulo' => Respuesta::act_expediente,
                'mensaje' => Respuesta::act_expediente
            ]);
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return response()->json([
                'code' => 99,
                'titulo' => Respuesta::error_act_expediente,
                'mensaje' => Respuesta::error_act_expediente
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function deletePaciente($id){
        try {
            DB::beginTransaction();

            $paciente = Paciente::find($id);
            $paciente->inactivo = $paciente->inactivo == 1 ? 0 : 1;
            $mensajeRespuesta = $paciente->inactivo == 1 ? Respuesta::baja_expediente : Respuesta::alta_expediente;
            $paciente->save();
            DB::commit();
            
            return response()->json([
                'code' => 200,
                'titulo' => Respuesta::titulo_exito_generico,
                'mensaje' => $mensajeRespuesta
            ]);
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return response()->json([
                'code' => 99,
                'titulo' => Respuesta::titulo_error_generico,
                'mensaje' => Respuesta::error_baja_expediente
            ]);
        }
    }

    public function obtenerDietaPdf($id, Request $request)
    {
        $paciente = Paciente::find($id);
        $dieta = $request->post();

        $dieta['fechaCreacionDieta'] = date('d/m/Y', strtotime($dieta['fechaCreacionDieta']));

        $pdf = PDF::loadView('plantillas-pdf/dieta', compact('paciente', 'dieta'));
        $pdf->setPaper('A4', 'landscape');
        $nombreArchivo = 'Dieta-'.$paciente->numero_exp.'-'.date("YmdHis").'.pdf';
        
        Storage::put('public/'.$nombreArchivo, $pdf->output());

        return response()->file(storage_path('app/public/'.$nombreArchivo), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Dieta-'.$paciente->numero_exp.'"'
        ]);
    }



}
