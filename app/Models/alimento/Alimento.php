<?php

namespace App\Models\alimento;

use App\Models\Dieta\Dieta_Alimento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Alimento extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='alimentos';
    protected $fillable=[
        'nombre',
        'calorias',
        'grasas',
        'proteinas',
        'carbohidratos',
        'hierro',
        'potasio',
        'calcio',
        'sodio'
    ];
    protected $dates=['created_at','updated_at'];
    public function dieta_A(){
        return $this->hasMany(Dieta_Alimento::class);
    }
}
