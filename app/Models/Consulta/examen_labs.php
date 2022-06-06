<?php

namespace App\Models\Consulta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUlid;
// para hacer el softdelete
use Illuminate\Database\Eloquent\SoftDeletes;

class examen_labs extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUlid;

    protected $table='examen_labs';
    protected $KeyTipe='string';
    protected $fillable = [
        'hemoglobina',
        'linfocitos',
        'hba_1c',
        'creatinina',
        'trigliceridos',
        'colesterol_total',
        'chdl',
        'cldl',
        'glucosa_ayuno',
        'glucosa_post_pondrial',
        'acido_urico',
        'albumina'
    ];
    protected $dates=['created_at', 'updated_at', 'deleted_at'];
}
