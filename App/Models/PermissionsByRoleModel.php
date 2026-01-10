<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use App\Models\RolesModel;
use App\Models\PermissionsModel;

class PermissionsByRoleModel extends Model {

    use HasFactory;

    //Tabla pivot para asignación de permisos a roles
    protected $table =  'permissions_role';

    protected $fillable = [
        'role_id',
        'permission_id',
        //Auditoria error mio la auditoria no se rellena como espacio solo es una funcion y ya no es necesario colocarla aqui
    ];

    //Relación con roles
    public function role() {
        return $this->belongsTo(RolesModel::class, 'role_id');
    }

    //Relación con permisos
    public function permission() {
        return $this->belongsTo(PermissionsModel::class, 'permission_id');
    }
}