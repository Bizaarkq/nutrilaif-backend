<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipio extends Model
{
    use SoftDeletes;
    protected $table="municipios";
    protected $primaryKey="id";
    protected $keyType="integer";
    protected $hidden = ['created_at', 'created_user', 'updated_at', 'updated_user','deleted_at'];
}
