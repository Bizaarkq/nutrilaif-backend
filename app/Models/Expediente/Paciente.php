<?php

namespace App\Models\Expediente;

use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// para hacer el softdelete
use Illuminate\Database\Eloquent\SoftDeletes;
class Paciente extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUlid;
    protected $table='paciente';
    protected $KeyTipe='string';
    protected $fillable = [];
    protected $dates=['created_at', 'updated_at'];
}
