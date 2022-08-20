<?php

namespace App\Http\Controllers\Citas;

use App\Http\Controllers\Controller;
use App\Models\Citas\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\Respuesta;
use Log;


class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('vw_citas')->where('id_nutric', Auth::user()->ID)->get();
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
            $nutricionista = Auth::user();

            if($this->consultarDisponibilidad($citaRequest['fecha_cita_inicio'], $citaRequest['fecha_cita_fin'], $nutricionista->ID)){
                DB::beginTransaction();
                $cita = new Cita();
                $cita->id_nutric = $nutricionista->ID;
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

                $cita->created_user = $nutricionista->USERNAME;
                $cita->updated_user = $nutricionista->USERNAME;
                $cita->save();
                DB::commit();
            }else{
                return response()->json([
                    'code'=> 99,
                    'titulo'=>Respuesta::mensaje_cita_horario_no_disponible,
                    'mensaje'=>Respuesta::mensaje_cita_horario_no_disponible
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
    public function update(Request $request, Cita $cita)
    {
        try{
            DB::beginTransaction();

            $citaRequest = $request->post();
            $nutricionista = Auth::user();

            $cita = Cita::find($citaRequest['id']);
            $cita->id_nutric = $nutricionista->ID;
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
            
            $cita->created_user = $nutricionista->USERNAME;
            $cita->updated_user = $nutricionista->USERNAME;
            $cita->save();


            DB::commit();
            return response()->json([
                'code'=>200,
                'titulo'=>Respuesta::mensaje_exito_guardar_cita,
                'mensaje'=>Respuesta::mensaje_exito_guardar_cita
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Citas\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cita $cita)
    {
        //
    }


    public function consultarDisponibilidad($fechaInicio, $fechaFin, $nutricionista){
        $citas = Cita::where('id_nutric', $nutricionista)
            ->where('fecha_cita_inicio', '<=', $fechaInicio)
            ->where('fecha_cita_fin', '>=', $fechaFin)
            ->orWhere(function ($query) use ($fechaInicio) {
                $query->where('fecha_cita_inicio', '<=', $fechaInicio)
                    ->where('fecha_cita_fin', '>=', $fechaInicio);
            })
            ->orWhere(function ($query) use ($fechaFin) {
                $query->where('fecha_cita_inicio', '<=', $fechaFin)
                    ->where('fecha_cita_fin', '>=', $fechaFin);
            })
            ->count();
        return !($citas > 0);
    }
}
