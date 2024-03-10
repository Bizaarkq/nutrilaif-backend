<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use SoftDeletes;
    protected $table="departamentos";
    protected $primaryKey="id";
    protected $keyType="integer";
    protected $hidden = ['created_at', 'created_user', 'updated_at', 'updated_user','deleted_at'];

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'id_departamento')->orderBy('nombre', 'asc');
    }
}
