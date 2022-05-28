<?php

namespace App\Models\expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Paciente extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='nutrilaif.paciente';
    protected $KeyTipe='String';
    protected $dates=['created_at', 'updated_at', 'deleted:at'];
}
