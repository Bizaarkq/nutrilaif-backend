<?php

namespace App\Models\Consulta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUlid;
// para hacer el softdelete
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanificacionDieta extends Model
{
    use HasFactory; 
    use SoftDeletes;
    use HasUlid;

    protected $table='planificacion_dieta';
    protected $KeyTipe='string';
    protected $fillable = [
        'requerimiento_energetico',
        'calorias_preescribir',
        'choc',
        'chon',
        'cooh',
        'preescripcion_dieta'
    ];
    protected $dates=['created_at', 'updated_at', 'deleted_at'];
    public function consulta(){
        return $this->belongsTo(Consulta::class);
    }
}
