<?php

namespace App\Models\Consulta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUlid;
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
        'frecuencia_consumo',
        'es_borrador'
    ];
    protected $dates=['created_at', 'updated_at', 'deleted_at'];
}
