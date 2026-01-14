<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UsersModels;

class OtpModels extends Model {

    use HasFactory;

    //Declaracion de la tabla a la que se asocia
    protected $table = 'otp_codes';

    //Atributos que se van a rellenar
    protected $fillable = [
        'user_id',
        'code_hash',
        'expires_at',
    ];

    //Casting de atributos
    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    //Relacion con usuario
    public function user() {
        return $this->belongsTo(UsersModels::class, 'user_id');
    }
}