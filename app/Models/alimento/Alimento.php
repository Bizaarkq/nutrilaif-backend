<?php

namespace App\Models\alimento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Alimento extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='alimentos';
    protected $fillable=[
        'nombre_alimento',
        'calorias_alimento',
        'grasas_alimento',
        'proteinas_alimento',
        'carbohidratos_alimento',
        'hierro_alimento',
        'potasio_alimento',
        'calcio_alimento',
        'sodio_alimento'
    ];
    protected $dates=['created_at','updated_at'];
}
