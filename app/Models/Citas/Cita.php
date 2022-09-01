<?php

namespace App\Models\Citas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Expediente\Paciente;

class Cita extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='cita';
    protected $KeyTipe='integer';

    protected $dates=['created_at', 'updated_at', 'deleted_at'];

    public function paciente(){
        return $this->hasOne(Paciente::class, 'id', 'id_paciente');
    }
}
