<?php

namespace App\Http\Controllers\Consulta;

use App\Helpers\Respuesta;
use App\Http\Controllers\Controller;
use App\Models\Consulta\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ulid\Ulid;
use App\Models\Expediente\Paciente;
use Auth;
use Log;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarConsulta($llave=null)
    {
        $nutri=Auth::user()->ID;
        if($llave==null){
            $consultas=Consulta::select('consulta.id','consulta.created_at', 'consulta.es_borrador')
            ->where('id_nutric','=',$nutri)
            ->join('paciente', 'paciente.id', '=', 'consulta.id_paciente')
            ->where('paciente.deleted_at', '=', null)
            ->orderBy('created_at','desc')
            ->get();
        }
        else{
            $consultas=Consulta::select('consulta.id','consulta.created_at', 'consulta.es_borrador')
            ->where([['id_nutric','=',$nutri],['id_paciente','=',$llave],])
            ->join('paciente', 'paciente.id', '=', 'consulta.id_paciente')
            ->where('paciente.deleted_at', '=', null)
            ->orderBy('created_at','desc')
            ->get();
        }
        return json_decode($consultas);
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

            $consulta=new Consulta;
            $consulta->id=Ulid::generate(true);;
            $consulta->id_nutric=$request->id_nutric;
            $consulta->id_paciente=$request->id_paciente;
            $consulta->frecuencia_consumo=$request->frecuencia_consumo;
            $consulta->recordatorio=$request->recordatorio;
            $consulta->fecha_dieta=$request->fecha_dieta;
            $consulta->es_borrador=$request->es_borrador;
            $consulta->save();

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
        try{

            DB::beginTransaction();
            $consultaUpdate=Consulta::find($id);
            if($request->es_borrador!=0){
                $consultaUpdate->update($request->all());
                DB::commit();

                return response()->json([
                    'code'=>200,
                    'titulo'=>Respuesta::titulo_exito_generico,
                    'mensaje'=>Respuesta::mensaje_exito_generico
                ]);
            }
            else{
                DB::rollBack();
                return response()->json([
                    'code'=>99,
                    'titulo'=>Respuesta::titulo_error_generico,
                    'mensaje'=>Respuesta::mensaje_error_generico
                ]);
            }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function guardarConsulta(Request $cuerpo, $id = null){
        try {
        $datosConsulta = $cuerpo->post();
        $subConsulta = $datosConsulta['subconsulta_form'];
        $id_paciente = array_key_exists('id_paciente', $datosConsulta['paciente']) ? $datosConsulta['paciente']['id_paciente'] : null;
        $id_consulta = $id == null ? Ulid::generate(true) : $id;
        $user = Auth::user()->USERNAME;
        $numero_expediente = '';
        DB::beginTransaction();
        DB::enableQueryLog();
        $id_nutricionista =  Auth::user()->ID;
        if ($id==null && $id_paciente == null) {
            // si no existe la consulta y el paciente se crea uno nuevo

            $last_num = DB::table('paciente')->orderByDesc('created_at')->select('numero_exp')->first();
            if($last_num == null){
                $numero_expediente = '01072020';
            }else{
                $correlativo = substr($last_num->numero_exp, 0, 2);
                $correlativo = $correlativo + 1;
                if($correlativo<10){
                    $numero_expediente = '0' . $correlativo . substr($last_num->numero_exp, 2, 6);
                }else if($correlativo==100){
                    $correlativo = substr($last_num->numero_exp, 2, 2);
                    $correlativo = $correlativo + 1;
                    if ($correlativo<10) {
                        $numero_expediente = '010' . $correlativo . substr($last_num->numero_exp, 4, 4);
                    }else{
                        $numero_expediente = '01' . $correlativo . substr($last_num->numero_exp, 4, 4);
                    }
                }else{
                    $numero_expediente = $correlativo .  substr($last_num->numero_exp, 2, 6);
                }
            }

            $paciente = new Paciente;
            $paciente->id = Ulid::generate(true);
            $paciente->numero_exp = $numero_expediente;
            $paciente->nombre = $datosConsulta['paciente']['nombre'];
            $paciente->apellido = $datosConsulta['paciente']['apellido'];
            $paciente->fecha_nacimiento = $datosConsulta['paciente']['fecha_nacimiento'];
            $paciente->sexo = $datosConsulta['paciente']['sexo'];
            $paciente->correo = $datosConsulta['paciente']['correo'];
            $paciente->telefono = $datosConsulta['paciente']['telefono'];
            $paciente->direccion = $datosConsulta['paciente']['direccion'];
            $paciente->departamento = $datosConsulta['paciente']['departamento'];
            $paciente->municipio = $datosConsulta['paciente']['municipio'];
            $paciente->edad = $datosConsulta['paciente']['edad'];
            $paciente->ocupacion = $datosConsulta['paciente']['ocupacion'];
            $paciente->fecha_creacion = $datosConsulta['paciente']['fechaExpediente'];
            $paciente->created_user = $user;
            $paciente->updated_user = $user;
            $paciente->save();
            DB::table('nutricionista_paciente')->insert(
                [
                    'id_nutric' => $id_nutricionista,
                    'id_paciente' => $paciente->id,
                    'tipo_nutri' => 'E'
                ]
            );
            $consulta = new Consulta;
            $consulta->id = $id_consulta;
            $consulta->id_paciente = $paciente->id;
            $consulta->id_nutric = $id_nutricionista;
            $consulta->created_user = $user;
        } elseif ($id==null && $id_paciente!=null) {
            //en caso exista el paciente pero sea una nueva consulta subsecuente
            $consulta = new Consulta;
            $consulta->id = $id_consulta;
            $consulta->id_paciente = $id_paciente;
            $consulta->id_nutric = $id_nutricionista;
            $consulta->created_user = $user;
        } elseif ($id!=null && $id_paciente!=null) {
            //en caso exista la consulta y el paciente sería una edicion de consulta
            $consulta = Consulta::find($id);
            $consulta->dieta = $datosConsulta['dieta'];
        }
        $consulta->recordatorio = json_encode($datosConsulta['recordatorio']);
        $consulta->frecuencia_consumo = $datosConsulta['frecuencia_consumo'];
        $consulta->es_borrador = $datosConsulta['es_borrador'];
        $consulta->updated_user = $user;
        $consulta->save();

        if ($id==null) {
            foreach ($subConsulta as $tabla => $campo) {
                $subConsulta[$tabla]['id_consulta'] = $id_consulta;
                DB::table($tabla)->insert($subConsulta[$tabla]);
            }
        } else {
            foreach ($subConsulta as $tabla => $campo) {
                $subConsulta[$tabla]['id_consulta'] = $id_consulta;
                DB::table($tabla)->where('id_consulta', $id)->update($subConsulta[$tabla]);
            }
        }
        DB::commit();
        return response()->json([
            'code'=>200,
            'titulo'=>Respuesta::titulo_exito_generico,
            'mensaje'=>Respuesta::mensaje_exito_generico,
            'data' => $numero_expediente
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

    public function getConsulta($id){
        try {

            $consulta = Consulta::where('id', $id)->select('id', 'id_paciente', 'fecha_dieta', 'recordatorio', 'frecuencia_consumo','dieta', 'es_borrador')->first();
            $historiaDietetica = $consulta->historiaDietetica->makeHidden(['created_at', 'updated_at', 'created_user', 'updated_user', 'deleted_at']);
            $datosAntropo = $consulta->datosAntropo->makeHidden(['created_at', 'updated_at', 'created_user', 'updated_user', 'deleted_at']);
            $datosMedicos = $consulta->datosMedicos->makeHidden(['created_at', 'updated_at', 'created_user', 'updated_user', 'deleted_at']);
            $planificacionDieta = optional($consulta->planificacionDieta)->makeHidden(['created_at', 'updated_at', 'created_user', 'updated_user', 'deleted_at']);
            $examenLabs = $consulta->examenLabs->makeHidden(['created_at', 'updated_at', 'created_user', 'updated_user', 'deleted_at']);

            $es_subsecuente = Consulta::where('id_paciente', '=', json_decode($consulta,true)['id_paciente'])->count() > 1 ? true : false;
            
            $formulario = [
            'recordatorio' => $consulta->recordatorio,
            'frecuencia_consumo' => json_decode($consulta->frecuencia_consumo, true),
            'planificacion_dieta' => $planificacionDieta,
            'dieta' => json_decode($consulta->dieta,true),
            'subconsulta_form' => [
                'historia_dietetica' => $historiaDietetica,
                'datos_antropo' => $datosAntropo,
                'datos_medicos' => $datosMedicos,
                'examen_labs' => $examenLabs
            ],
            "es_borrador" => $consulta->es_borrador == 1 ? true : false,
            "es_subsecuente" => $es_subsecuente
        ];
            return $formulario;
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'code'=>99,
                'titulo'=>Respuesta::titulo_error_generico,
                'mensaje'=>Respuesta::mensaje_error_generico
            ]);
        }
    }
}
