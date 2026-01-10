<?php

namespace App\Models;

//Configuraciones para el modelo de usuario 1. Uso de extensiones de Laravel Auth, Notifiable, HasFactory
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RolesModel;

class UsersModels extends Authenticatable {

    //¿Que hacen estas?
    /**
     * HasFactory: trait que añade soporte para factories de Eloquent. 
     * Permite llamar a Model::factory() para crear instancias en seeds/tests 
     * (ej.: UsersModels::factory()->count(5)->create()). No cambia la lógica del modelo en producción; 
     * facilita pruebas y generación de datos.
     * 
     * Notifiable: trait que añade la capacidad de enviar notificaciones al modelo. 
     * Proporciona el método notify() y la integración con canales (mail, database, broadcast, etc.). 
     * Ej.: $user->notify(new InvoicePaid($invoice));. También define métodos de routing para canales 
     * (p. ej. routeNotificationForMail).
     */
    use HasFactory, Notifiable;

    //Declaracion de la tabla a la que se asocia
    protected $table = 'users';

    //Atributos que se van a rellenar
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'is_active',
        'role_id',
    ];

    //Atributos que se van a ocultar
    protected $hidden = [
        'password',
        'remember_token',
    ];

    //Casting de atributos
    //usar cuando
    //El tipo importa en PHP
    //No quieres strings ambiguos
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    //Relacion con roles y creaciones
    public function role() {
        return $this->belongsTo(RolesModel::class, 'role_id');
    }


    public function creator() {
        return $this->belongsTo(self::class, 'created_by');
    }

}