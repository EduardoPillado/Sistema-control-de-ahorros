<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ahorro extends Model
{
    use HasFactory;
    protected $guard_name = 'web';
    protected $table="ahorro";
    protected $primaryKey='pkAhorro';
    protected $fillable = [
        'cantidadAhorro',
        'fechaIngreso',
        'fkUsuario'
    ];
    public $timestamps=false;
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'fkUsuario');
    }
}
