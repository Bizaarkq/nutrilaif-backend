<?php

namespace App\Models\expediente;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// para hacer el softdelete
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class Paciente extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUlid;
    protected $table='nutrilaif.paciente';
    protected $KeyTipe='string';
    protected $fillable = [
        'nombre',
        'apellidos',
        'correo',
        'direccion',
        'fecha_nacimiento',
        'numero_exp',
        'sexo',
        'telefono'
    ];
    protected $dates=['created_at', 'updated_at', 'deleted:at'];
    
}
Schema::table('nutrilaif.paciente',function(Blueprint $table){
    $table->softDeletes();
});
Schema::table('nutrilaif.paciente', function(Blueprint $table){
    $table->dropSoftDeletes();
});
