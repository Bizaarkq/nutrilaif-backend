<?php

namespace App\Models\Consulta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUlid;
// para hacer el softdelete
use Illuminate\Database\Eloquent\SoftDeletes;

class DatosAntropo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUlid;

    protected $table='datos_antropo';
    protected $KeyTipe='string';
    protected $fillable = [
        'peso_actual',
        'peso_ideal',
        'p_grasa_corporal',
        'p_masa_muscular',
        'p_grasa_viceral',
        'peso_meta',
        'talla',
        'c_cintura',
        'c_cadera',
        'c_muneca',
        'c_brazo_relaj',
        'edad_metabolica',
        'imc'
    ];
    protected $dates=['created_at', 'updated_at', 'deleted_at'];
    public function consulta(){
        return $this->belongsTo(Consulta::class);
    }
}
