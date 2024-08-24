<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    use HasFactory;
    protected $guard_name = 'web';
    protected $table="deuda";
    protected $primaryKey='pkDeuda';
    protected $fillable = [
        'fkMovimientos',
        'nombrePersona',
        'cantidadAbonoRestante',
        'fkTipoDeuda',
        'fkCantidadesDeudas',
        'estatusDeuda'
    ];
    public $timestamps=false;
    public function tipoDeuda(){
        return $this->belongsTo(TipoDeuda::class, 'fkTipoDeuda');
    }
    public function movimientos(){
        return $this->belongsTo(Movimientos::class, 'fkMovimientos');
    }
    public function cantidadesDeudas(){
        return $this->belongsTo(CantidadesDeudas::class, 'fkCantidadesDeudas');
    }
}
