<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    use HasFactory;
    protected $guard_name = 'web';
    protected $table="tipoMovimiento";
    protected $primaryKey='pkTipoMovimiento';
    protected $fillable = [
        'nombreTipoMovimiento'
    ];
    public $timestamps=false;
    public function movimientos(){
        return $this->hasMany(Movimientos::class, 'fkTipoMovimiento');
    }
}
