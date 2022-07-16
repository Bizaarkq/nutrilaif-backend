<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuInicio extends Model
{
    use SoftDeletes;
    protected $table="nutri_catalog.menu_inicio";
    protected $primaryKey="id";
    protected $keyType="integer";
    protected $hidden = ['created_at', 'created_user', 'updated_at', 'updated_user','deleted_at'];
}
