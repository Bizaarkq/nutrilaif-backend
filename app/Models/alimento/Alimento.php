<?php

namespace App\Models\alimento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Alimento extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='nutrilaif.alimentos';
    protected $fillable=[
        'codigo',
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
}
