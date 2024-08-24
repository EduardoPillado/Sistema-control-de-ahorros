<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ahorro;

class Ahorro_controller extends Controller
{
    public function insertar(Request $req){
        $req->validate([
            'cantidadAhorro' => 'required|numeric',
            'fechaIngreso' => 'required|date',
            'fkUsuario' => 'required|exists:usuario,pkUsuario',
        ], [
            'cantidadAhorro.required' => 'La cantidad es obligatoria.',
            'cantidadAhorro.numeric' => 'La cantidad debe ser un valor numérico.',

            'fechaIngreso.required' => 'La fecha es obligatoria.',
            'fechaIngreso.date' => 'La fecha debe ser una fecha válida.',

            'fkUsuario.required' => 'El usuario asociado al ahorro es obligatorio.',
            'fkUsuario.exists' => 'El usuario seleccionado no es válido.',
        ]);

        $ahorro=new Ahorro();
        
        $ahorro->cantidadAhorro=$req->cantidadAhorro;
        $ahorro->fechaIngreso=$req->fechaIngreso;
        $ahorro->fkUsuario=$req->fkUsuario;

        $ahorro->save();
        
        if ($ahorro->pkAhorro) {
            return redirect('/inicio')->with('success', 'Ahorro registrado');
        } else {
            return back()->with('error', 'Hay algún problema con la información');
        }
    }
}
