<?php

namespace App\Models\Especialidades;

use App\Models\Consulta\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pliegues extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='pliegues';
    protected $KeyTipe='string';
    protected $fillable=[
        'p_bicipital',
        'p_tricipital',
        'p_sub_escapular',
        'p_supra_iliaco',
        'p_abdominal',
        'p_muslo_anterior',
        'p_pierna_medial',
        'c_brazo_contraido',
        'c_pierna',
        'p_humero',
        'p_femur'
    ];
    protected $dates=['created_at','updated_at','deleted_at'];
    public function consulta(){
        return $this->belongsTo(Consulta::class);
    }
    
}
