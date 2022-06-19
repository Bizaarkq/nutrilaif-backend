<?php

namespace App\Models\Consulta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUlid;
// para hacer el softdelete
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoriaDietetica extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUlid;

    protected $table='historia_dietetica';
    protected $KeyTipe='string';
    protected $fillable = [
        'antecedentes_familiares',
        'actividad_fisica',
        'preferencia_alimen',
        'alimentos_no_gustan',
        'intolerancia_alergia',
        'donde_come',
        'quien_cocina',
        'estrenimiento',
        'horas_sueno',
        'alcohol',
        'tabaco',
        'agua',
        'observacion_menu_anterior',
        'saciedad',
        'alimentos_quiere',
        'diagnostico_nutricional'
    ];
    protected $dates=['created_at', 'updated_at', 'deleted_at'];
    public function consulta(){
        return $this->belongsTo(Consulta::class);
    }
}
