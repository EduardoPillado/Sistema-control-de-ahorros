<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CantidadesDeudas extends Model
{
    use HasFactory;
    protected $guard_name = 'web';
    protected $table="cantidadesDeudas";
    protected $primaryKey='pkCantidadesDeudas';
    protected $fillable = [
        'cantidadDeudasUsuario',
        'cantidadDeudasOtros',
        'fkUsuario'
    ];
    public $timestamps=false;
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'fkUsuario');
    }
    public function deuda(){
        return $this->hasMany(Deuda::class, 'fkCantidadesDeudas');
    }
}
