<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $guard_name = 'web';
    protected $table="usuario";
    protected $primaryKey='pkUsuario';
    protected $fillable = [
        'nombreUsuario',
        'correo',
        'contraseña',
        'estatusUsuario'
    ];
    public $timestamps=false;
    public function movimientos(){
        return $this->hasMany(Movimientos::class, 'fkUsuario');
    }
    public function ahorro(){
        return $this->hasMany(Ahorro::class, 'fkUsuario');
    }
    public function cantidadesDeudas(){
        return $this->hasMany(CantidadesDeudas::class, 'fkUsuario');
    }
}
