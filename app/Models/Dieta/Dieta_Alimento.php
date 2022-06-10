<?php

namespace App\Models\Dieta;

use App\Models\alimento\Alimento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Dieta_Alimento extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='dieta_alimento';
    protected $fillable=[
        'tiempo_comida',
        'dia_comida',
        'cantidad',
        'unidad_medida',
    ];
    protected $dates=['created_at','updated_at'];
    public function dieta(){
        return $this->belongsTo(Dieta::class);
    }
    public function alimento(){
        return $this->hasMany(Alimento::class);
    }
}
