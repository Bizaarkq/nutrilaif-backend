<?php

namespace App\Models\Consulta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUlid;
use App\Models\Expediente\Paciente;
// para hacer el softdelete
use Illuminate\Database\Eloquent\SoftDeletes;

class Consulta extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUlid;

    protected $table='consulta';
    protected $KeyTipe='string';
    protected $fillable = [
        'fecha_dieta',
        'recordatorio',
        'frecuencia_consumo'
    ];
    protected $dates=['created_at', 'updated_at', 'deleted_at'];
    public function historiaDietetica(){
        return $this->hasOne(HistoriaDietetica::class, 'id_consulta', 'id');
    }
    public function datosAntropo(){
        return $this->hasOne(DatosAntropo::class, 'id_consulta', 'id');
    }
    public function datosMedicos(){
        return $this->hasOne(DatosMedicos::class, 'id_consulta', 'id');
    }
    public function planificacionDieta(){
        return $this->hasOne(PlanificacionDieta::class, 'id_consulta', 'id');
    }
    public function examenLabs(){
        return $this->hasOne(ExamenLabs::class, 'id_consulta', 'id');
    }
    public function paciente(){
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id');
    }
}
