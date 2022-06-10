<?php

namespace App\Models\Dieta;

use App\Models\Consulta\PlanificacionDieta;
use App\Models\Expediente\Paciente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dieta extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='dieta';
    protected $fillable=[];
    protected $dates=['created_at','updated_at'];
    public function planificacionD(){
        return $this->belongsTo(PlanificacionDieta::class);
    }
    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }
    public function dieta_A(){
        return $this->hasMany(Dieta_Alimento::class);
    }
}
