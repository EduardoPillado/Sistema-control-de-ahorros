<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    use HasFactory;
    protected $guard_name = 'web';
    protected $table="movimientos";
    protected $primaryKey='pkMovimientos';
    protected $fillable = [
        'fechaMovimiento',
        'cantidadMovimiento',
        'descripcion',
        'fkTipoMovimiento',
        'fkUsuario'
    ];
    public $timestamps=false;
    public function tipoMovimiento(){
        return $this->belongsTo(TipoMovimiento::class, 'fkTipoMovimiento');
    }
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'fkUsuario');
    }
    public function deuda(){
        return $this->hasMany(Deuda::class, 'fkMovimientos');
    }
}
