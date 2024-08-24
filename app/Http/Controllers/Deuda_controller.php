<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deuda;
use App\Models\Movimientos;
use App\Models\Ahorro;
use App\Models\CantidadesDeudas;

class Deuda_controller extends Controller
{
    public function mostrarDeudas(){
        $PKUSUARIO = session('pkUsuario');
        if ($PKUSUARIO) {
            $datosDeuda = Movimientos::where('fkUsuario', $PKUSUARIO)
                ->with('deuda', 'deuda.cantidadesDeudas')
                ->get()
                ->pluck('deuda')
                ->flatten();
    
            $sumDeudasOtros = Deuda::whereHas('movimientos', function ($query) use ($PKUSUARIO) {
                $query->where('fkUsuario', $PKUSUARIO);
            })
            ->join('cantidadesDeudas', 'deuda.pkDeuda', '=', 'cantidadesDeudas.fkUsuario')
            ->sum('cantidadesDeudas.cantidadDeudasOtros');
    
            $sumDeudasUsuario = Deuda::whereHas('movimientos', function ($query) use ($PKUSUARIO) {
                $query->where('fkUsuario', $PKUSUARIO);
            })
            ->join('cantidadesDeudas', 'deuda.pkDeuda', '=', 'cantidadesDeudas.fkUsuario')
            ->sum('cantidadesDeudas.cantidadDeudasUsuario');
    
            return view('listaDeudas', compact('datosDeuda', 'sumDeudasOtros', 'sumDeudasUsuario'));
        } else {
            return redirect('/');
        }
    }
    
    public function obtenerMovimientoDeuda($fkMovimientos){
        $movimiento = Movimientos::findOrFail($fkMovimientos);
        return view('detallesMovimiento', compact('movimiento'));
    }

    public function mostrarDeudaAbono($pkDeuda){
        $PKUSUARIO = session('pkUsuario');
        if ($PKUSUARIO) {
            $ahorroExistente = Ahorro::where('fkUsuario', $PKUSUARIO)->exists();
            $movimientosDelUsuario = Movimientos::where('fkUsuario', $PKUSUARIO)->pluck('pkMovimientos');

            $deudaExistente = Deuda::whereIn('fkMovimientos', $movimientosDelUsuario)->exists();

            if (!$ahorroExistente) {
                return redirect()->back()->with('warning', 'Registra un ahorro primero');
            } elseif (!$deudaExistente) {
                return redirect()->back()->with('warning', 'Registra una deuda primero');
            } else {
                $estatusDeuda = Deuda::where('estatusDeuda', '1');
                if ($estatusDeuda) {
                    $datosDeuda = Deuda::findOrFail($pkDeuda);
                    return view('formAbono', compact('datosDeuda'));
                } else {
                    return back()->with('warning', 'La deuda ya fue saldada');
                }
            }
        } else {
            return redirect('/');
        }
    }

    public function abono(Request $req, $pkDeuda){
        $datosDeuda = Deuda::findOrFail($pkDeuda);
        $cantidadAbono = $req->input('cantidadAbono');
        $cantidadMovimiento = $req->input('cantidadMovimiento');
        $cantidadAbonoRestante = $datosDeuda->cantidadAbonoRestante;

        $req->validate([
            'cantidadAbono' => 'required|numeric|max:' . min($cantidadMovimiento, $cantidadAbonoRestante)
        ], [
            'cantidadAbono.required' => 'La cantidad a abonar es requerida.',
            'cantidadAbono.numeric' => 'La cantidad a abonar debe ser un valor numérico.',
            'cantidadAbono.max' => 'La cantidad a abonar no puede ser mayor a la cantidad restante.',
        ]);
    
        $tipoDeuda = $datosDeuda->tipoDeuda->nombreTipoDeuda;
    
        if ($tipoDeuda == 'Deuda') {
            $cantidadDeuda = CantidadesDeudas::findOrFail($datosDeuda->fkCantidadesDeudas);
            $nuevaCantidadDeuda = $cantidadDeuda->cantidadDeudasOtros - $cantidadAbono;
            $cantidadDeuda->update(['cantidadDeudasOtros' => $nuevaCantidadDeuda]);
        } else if ($tipoDeuda == 'Deudor') {
            $cantidadDeuda = CantidadesDeudas::findOrFail($datosDeuda->fkCantidadesDeudas);
            $nuevaCantidadDeuda = $cantidadDeuda->cantidadDeudasUsuario - $cantidadAbono;
            $cantidadDeuda->update(['cantidadDeudasUsuario' => $nuevaCantidadDeuda]);
        }

        $cantidadAbonada = $cantidadMovimiento - $cantidadAbonoRestante;
        $nuevaCantidadAbonoRestante = max(0, $cantidadAbonoRestante - $cantidadAbono);

        if ($nuevaCantidadAbonoRestante == 0) {
            $datosDeuda->estatusDeuda = 0;
        } else {
            if ($cantidadAbonada == $cantidadMovimiento) {
                $datosDeuda->estatusDeuda = 0;
            } else {
                $datosDeuda->estatusDeuda = 2;
            }
        }

        $datosDeuda->save();            

        $cantidadAbonoRestante -= $cantidadAbono;
        $datosDeuda->update(['cantidadAbonoRestante' => $cantidadAbonoRestante]);
        
        $PKUSUARIO = session('pkUsuario');
        $ahorro = Ahorro::where('fkUsuario', $PKUSUARIO)->first();
        if ($ahorro) {
            if ($tipoDeuda == 'Deuda') {
                $ahorro->update(['cantidadAhorro' => $ahorro->cantidadAhorro + $cantidadAbono]);
            } else if ($tipoDeuda == 'Deudor') {
                $ahorro->update(['cantidadAhorro' => $ahorro->cantidadAhorro - $cantidadAbono]);
            }
        }
    
        if ($datosDeuda->pkDeuda) {
            return redirect('/deudas')->with('success', 'Abono registrado');
        } else {
            return back()->with('error', 'Hubo un problema al registrar el abono');
        }
    }
}
