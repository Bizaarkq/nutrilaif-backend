<?php

namespace App\Http\Controllers\Citas;

use App\Http\Controllers\Controller;
use App\Models\Citas\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\Respuesta;
use Log;
use Carbon\Carbon;

class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('vw_citas')->where('id_nutric', Auth::user()->id)->get();
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
            
            $citaRequest = $request->post();

            $nutricionista = $citaRequest['id_nutric'] ??  Auth::user()->id;
            $disponibilidad = $this->consultarDisponibilidad($citaRequest['fecha_cita_inicio'], $citaRequest['fecha_cita_fin'], $nutricionista, $citaRequest['id']);
            if(!(array)$disponibilidad){
                DB::beginTransaction();
                $cita = $citaRequest['id'] ? Cita::find($citaRequest['id']) : new Cita();
                $cita->id_nutric = $nutricionista;
                $cita->titulo = $citaRequest['titulo'];
                $cita->fecha_cita_inicio = $citaRequest['fecha_cita_inicio'];
                $cita->fecha_cita_fin = $citaRequest['fecha_cita_fin'];

                if( $citaRequest['id_paciente'] == null ){
                    $cita->nombre = $citaRequest['nombre'];
                    $cita->telefono = $citaRequest['telefono'];
                    $cita->correo = $citaRequest['correo'];
                    $cita->direccion = $citaRequest['direccion'];
                    $cita->edad = $citaRequest['edad'];
                    $cita->fecha_nacimiento = substr($citaRequest['fecha_nacimiento'], 0, 10);
                    $cita->objetivo = $citaRequest['objetivo'];
                }else{
                    $cita->id_paciente = $citaRequest['id_paciente'];
                }

                $nutri = Auth::user()->codigo;

                if(!$citaRequest['id']) $cita->created_user = $nutri;
                $cita->updated_user = $nutri;
                $cita->save();

                if($citaRequest['id_paciente'] != null){
                    $this->asignarNutricionistaAuxiliar($nutricionista, $citaRequest['id_paciente'], $citaRequest['fecha_cita_fin']);
                }

                DB::commit();
            }else{
                $fecha = Carbon::parse(explode(" ",$disponibilidad->fecha_cita_inicio)[0]);
                $message = Respuesta::mensaje_cita_horario_no_disponible . 
                ': ' . ($citaRequest['id_nutric'] ? 'el nutricionista seleccionado tiene' : 'ya existe') . ' una cita para el día ' .
                $fecha->dayName . ', ' . $fecha->day . ' de ' . $fecha->monthName . ' de ' . $fecha->year .
                ' a las ' . substr(explode(" ", $disponibilidad->fecha_cita_inicio)[1],0,5) 
                . ' - ' . substr(explode(" ", $disponibilidad->fecha_cita_fin)[1],0,5);
                return response()->json([
                    'code'=> 99,
                    'titulo'=>Respuesta::mensaje_cita_horario_no_disponible,
                    'mensaje'=> $message
                ]);
            }
            
            return response()->json([
                'code'=>200,
                'titulo'=>Respuesta::mensaje_exito_guardar_cita,
                'mensaje'=>Respuesta::mensaje_exito_guardar_cita,
                'data' => $cita->id
            ]);
        }catch(\Exception $e){  
            report($e);
            DB::rollBack();
            return response()->json([
                'code'=>99,
                'titulo'=>Respuesta::mensaje_error_guardar_cita,
                'mensaje'=>Respuesta::mensaje_error_guardar_cita
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Citas\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function show(Cita $cita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Citas\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function edit(Cita $cita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Citas\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function updateFechaHora(Request $request)
    {
        try{
            
            $citaRequest = $request->post();
            $nutricionista = $citaRequest['id_nutric'] ??  Auth::user()->id;

            $disponibilidad = $citaRequest['id_nutric'] != null ? $this->consultarDisponibilidad($citaRequest['fecha_cita_inicio'], $citaRequest['fecha_cita_fin'],$citaRequest['id_nutric']) : null;    
            
            if(!(array)$disponibilidad){

                DB::beginTransaction();
                $cita = Cita::find($citaRequest['id']);
                $cita->fecha_cita_inicio = $citaRequest['fecha_cita_inicio'];
                $cita->fecha_cita_fin = $citaRequest['fecha_cita_fin'];
                $cita->updated_user = Auth::user()->codigo;
                $cita->save();

                if($citaRequest['id_paciente'] != null){
                    $this->asignarNutricionistaAuxiliar($nutricionista, $citaRequest['id_paciente'], $citaRequest['fecha_cita_fin']);
                }
                DB::commit();
                
                return response()->json([
                    'code'=>200,
                    'titulo'=>Respuesta::mensaje_exito_actualizar_cita,
                    'mensaje'=>Respuesta::mensaje_exito_actualizar_cita
                ]);
            }else{
                $fecha = Carbon::parse(explode(" ",$disponibilidad->fecha_cita_inicio)[0]);
                $message = Respuesta::mensaje_cita_horario_no_disponible . 
                ': ' . ($citaRequest['id_nutric'] ? 'el nutricionista seleccionado tiene' : 'ya existe') . ' una cita para el día ' .
                $fecha->dayName . ', ' . $fecha->day . ' de ' . $fecha->monthName . ' de ' . $fecha->year .
                ' a las ' . substr(explode(" ", $disponibilidad->fecha_cita_inicio)[1],0,5) 
                . ' - ' . substr(explode(" ", $disponibilidad->fecha_cita_fin)[1],0,5);
                return response()->json([
                    'code'=> 99,
                    'titulo'=>Respuesta::mensaje_cita_horario_no_disponible,
                    'mensaje'=> $message
                ]);
            }
            
        }catch(\Exception $e){  
            report($e);
            DB::rollBack();
            return response()->json([
                'code'=>99,
                'titulo'=>Respuesta::mensaje_error_actualizar_cita,
                'mensaje'=>Respuesta::mensaje_error_actualizar_cita
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Citas\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try{
            DB::beginTransaction();
            $cita = Cita::find($id);
            $cita->delete();
            DB::commit();
            return response()->json([
                'code'=>200,
                'titulo'=>Respuesta::mensaje_exito_eliminar_cita,
                'mensaje'=>Respuesta::mensaje_exito_eliminar_cita
            ]);
        }catch(\Exception $e){  
            report($e);
            DB::rollBack();
            return response()->json([
                'code'=>99,
                'titulo'=>Respuesta::mensaje_error_eliminar_cita,
                'mensaje'=>Respuesta::mensaje_error_eliminar_cita
            ]);
        }
    }


    public function consultarDisponibilidad($fechaInicio, $fechaFin, $nutricionista, $id=null){
        $citas = Cita::where(function($query) use ($fechaInicio, $fechaFin, $nutricionista){
                $query->where(function($query) use ($fechaInicio, $fechaFin, $nutricionista){
                        $query->where('fecha_cita_inicio', '>=', $fechaInicio)
                            ->where('fecha_cita_inicio', '<=', $fechaFin)
                            ->where('id_nutric', $nutricionista);
                    })
                    ->orWhere(function ($query) use ($fechaInicio, $nutricionista) {
                        $query->where('fecha_cita_inicio', '<=', $fechaInicio)
                            ->where('fecha_cita_fin', '>=', $fechaInicio)
                            ->where('id_nutric', $nutricionista);
                    })
                    ->orWhere(function ($query) use ($fechaFin, $nutricionista) {
                        $query->where('fecha_cita_inicio', '<=', $fechaFin)
                            ->where('fecha_cita_fin', '>=', $fechaFin)
                            ->where('id_nutric', $nutricionista);
                    });
            })
            ->where(function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })
            ->orderBy('created_at', 'desc');

        return $citas->first();
    }

    public function asignarNutricionistaAuxiliar($idNutricionista, $idPaciente, $fechaFin){
        $nutriPaciente = DB::table('nutricionista_paciente')
            ->where('id_nutric', $idNutricionista)
            ->where('id_paciente', $idPaciente)
            ->first();
        
        $fecha = Carbon::parse($fechaFin);
        $fecha->addDays(7);
        if(!(array)$nutriPaciente){
            DB::table('nutricionista_paciente')->insert([
                'id_nutric' => $idNutricionista,
                'id_paciente' => $idPaciente,
                'tipo_nutri' => 'A',
                'cita_especial' => $fecha,
                'created_at' => Carbon::now(),
                'created_user' => Auth::user()->codigo,
                'updated_at' => Carbon::now(),
                'updated_user' => Auth::user()->codigo
            ]);
        }else{
            if($nutriPaciente->tipo_nutri == 'A'){
                DB::table('nutricionista_paciente')
                ->where('id_nutric', $idNutricionista)
                ->where('id_paciente', $idPaciente)
                ->update([
                    'cita_especial' => $fecha,
                    'updated_at' => Carbon::now(),
                    'updated_user' => Auth::user()->codigo
                ]);
            }
        }
    }


}
