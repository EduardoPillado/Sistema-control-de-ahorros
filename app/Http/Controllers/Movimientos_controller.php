<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimientos;
use App\Models\TipoMovimiento;
use App\Models\Ahorro;
use App\Models\Deuda;
use App\Models\CantidadesDeudas;

class Movimientos_controller extends Controller
{
    public function insertar(Request $req){
        $req->validate([
            'fechaMovimiento' => 'required|date',
            'cantidadMovimiento' => 'required|numeric',
            'descripcion' => 'required|string|max:255',
            'fkTipoMovimiento' => 'required|exists:tipoMovimiento,pkTipoMovimiento',
            'fkUsuario' => 'required|exists:usuario,pkUsuario',
        ], [
            'fechaMovimiento.required' => 'La fecha es obligatoria.',
            'fechaMovimiento.date' => 'La fecha debe ser una fecha válida.',

            'cantidadMovimiento.required' => 'La cantidad es obligatoria.',
            'cantidadMovimiento.numeric' => 'La cantidad debe ser un valor numérico.',

            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser un texto.',
            'descripcion.max' => 'La descripción no puede exceder los 255 caracteres.',

            'fkTipoMovimiento.required' => 'El tipo de movimiento es obligatorio.',
            'fkTipoMovimiento.exists' => 'El tipo de movimiento seleccionado no es válido.',
            
            'fkUsuario.required' => 'El usuario asociado al movimiento es obligatorio.',
            'fkUsuario.exists' => 'El usuario seleccionado no es válido.',
        ]);

        $movimiento = new Movimientos();
        $movimiento->fechaMovimiento = $req->fechaMovimiento;
        $movimiento->cantidadMovimiento = $req->cantidadMovimiento;
        $movimiento->descripcion = $req->descripcion;
        $movimiento->fkTipoMovimiento = $req->fkTipoMovimiento;
        $movimiento->fkUsuario = $req->fkUsuario;
        $movimiento->save();

        $tipoMovimiento = TipoMovimiento::findOrFail($req->fkTipoMovimiento);
        $ahorro = Ahorro::where('fkUsuario', $req->fkUsuario)->first();
        if ($tipoMovimiento->nombreTipoMovimiento == 'Ingreso') {
            $ahorro->cantidadAhorro += $req->cantidadMovimiento;
        } elseif ($tipoMovimiento->nombreTipoMovimiento == 'Egreso') {
            $ahorro->cantidadAhorro -= $req->cantidadMovimiento;
        }
        $ahorro->save();

        if ($req->has('esDeuda')) {
            $cantidadesDeudas = CantidadesDeudas::firstOrCreate(['fkUsuario' => $req->fkUsuario]);
            if ($req->fkTipoDeuda == 1) {
                $cantidadesDeudas->cantidadDeudasOtros += $req->cantidadMovimiento;
            } elseif ($req->fkTipoDeuda == 2) {
                $cantidadesDeudas->cantidadDeudasUsuario += $req->cantidadMovimiento;
            }
            $cantidadesDeudas->save();

            $deuda = new Deuda();
            $deuda->fkMovimientos = $movimiento->pkMovimientos;
            $deuda->nombrePersona = $req->nombrePersona;
            $deuda->cantidadAbonoRestante = $movimiento->cantidadMovimiento;
            $deuda->fkTipoDeuda = $req->fkTipoDeuda;
            $deuda->fkCantidadesDeudas = $cantidadesDeudas->pkCantidadesDeudas;
            $deuda->estatusDeuda = 1;
            $deuda->save();
        }

        if ($movimiento->pkMovimientos) {
            return back()->with('success', 'Movimiento registrado');
        } else {
            return back()->with('error', 'Hubo un problema al registrar el movimiento');
        }
    }

    public function mostrarMovimientos(){
        $PKUSUARIO = session('pkUsuario');
        if ($PKUSUARIO) {
            $datosMovimientos=Movimientos::where('fkUsuario', $PKUSUARIO)->get();
            return view('listaMovimientos', compact('datosMovimientos'));
        } else {
            return redirect('/');
        }
    }
}
