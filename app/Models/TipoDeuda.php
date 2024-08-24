<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeuda extends Model
{
    use HasFactory;
    protected $guard_name = 'web';
    protected $table="tipoDeuda";
    protected $primaryKey='pkTipoDeuda';
    protected $fillable = [
        'nombreTipoDeuda'
    ];
    public $timestamps=false;
    public function deuda(){
        return $this->hasMany(Deuda::class, 'fkTipoDeuda');
    }
}
