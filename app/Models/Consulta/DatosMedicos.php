<?php

namespace App\Models\Consulta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUlid;
// para hacer el softdelete
use Illuminate\Database\Eloquent\SoftDeletes;

class DatosMedicos extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUlid;

    protected $table='datos_medicos';
    protected $KeyTipe='string';
    protected $fillable = [
        'diagnostico',
        'medicamento_suplemento',
        'otros_datos',
    ];
    protected $dates=['created_at', 'updated_at', 'deleted_at'];
}
