<?php

namespace App\Models\Consulta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// para hacer el softdelete
use Illuminate\Database\Eloquent\SoftDeletes;

class Consulta extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table='consulta';
    protected $KeyTipe='string';
    protected $fillable = [
        'fecha_dieta',
        'recordatorio',
        'frecuencia_consumo',
        'es_borrador'
    ];
    protected $dates=['created_at', 'updated_at', 'deleted_at'];
    public function historiaDietetica(){
        return $this->hasOne(HistoriaDietetica::class);
    }
    public function datosAntropo(){
        return $this->hasOne(DatosAntropo::class);
    }
    public function datosMedicos(){
        return $this->hasOne(DatosMedicos::class);
    }
    public function planificacionDieta(){
        return $this->hasOne(PlanificacionDieta::class);
    }
    public function examenesLabs(){
        return $this->hasOne(ExamenLabs::class);
    }
}
