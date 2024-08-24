<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuario_controller;
use App\Http\Controllers\Movimientos_controller;
use App\Http\Controllers\Ahorro_controller;
use App\Models\Ahorro;
use App\Http\Controllers\Deuda_controller;

Route::get('/', function () {
    $PKUSUARIO = session('pkUsuario');
    if ($PKUSUARIO) {
        return redirect()->back()->with('warning', 'Ya has iniciado sesión');
    } else {
        return view('login');
    }
})->name('login');

Route::get('/inicio', function () {
    $PKUSUARIO = session('pkUsuario');
    if ($PKUSUARIO) {
        return view('inicio');
    } else {
        return redirect('/');
    }
})->name('inicio');

// Usuario ----------------------------------------------------------------------------------------------------

Route::get('/registro', function () {
    $PKUSUARIO = session('pkUsuario');
    if ($PKUSUARIO) {
        return redirect()->back()->with('warning', 'Cierra sesión para acceder');
    } else {
        return view('registro');
    }
})->name('registro');

Route::post('/iniciandoSesión', [Usuario_controller::class, 'login'])->name('usuario.login');
Route::get('/cerrandoSesión', [Usuario_controller::class, 'logout'])->name('usuario.logout');

Route::post('/registrando', [Usuario_controller::class, 'insertar'])->name('usuario.insertar');

Route::get('/inicio', [Usuario_controller::class, 'mostrarAhorro_Movimientos'])->name('usuario.mostrarAhorro_Movimientos');


// ------------------------------------------------------------------------------------------------------------

// Ahorro ----------------------------------------------------------------------------------------------------

Route::get('/realizarAhorro', function () {
    $PKUSUARIO = session('pkUsuario');
    if ($PKUSUARIO) {
        $ahorroExistente = Ahorro::where('fkUsuario', $PKUSUARIO)->exists();
        if ($PKUSUARIO && !$ahorroExistente) {
            return view('formAhorro');
        } else {
            return redirect()->back()->with('warning', 'Ya hay un ahorro registrado');
        }
    } else {
        return redirect('/');
    }
})->name('realizarAhorro');

Route::get('/ahorro', [Ahorro_controller::class, 'mostrarAhorro'])->name('ahorro.mostrar');
Route::post('/registrandoAhorro', [Ahorro_controller::class, 'insertar'])->name('ahorro.insertar');

// -----------------------------------------------------------------------------------------------------------

// Movimientos ----------------------------------------------------------------------------------------------------

Route::get('/movimientos', function () {
    $PKUSUARIO = session('pkUsuario');
    if ($PKUSUARIO) {
        return view('listaMovimientos');
    } else {
        return redirect('/');
    }
})->name('movimientosRealizados');

Route::get('/realizarMovimiento', function () {
    $PKUSUARIO = session('pkUsuario');
    if ($PKUSUARIO) {
        $ahorroExistente = Ahorro::where('fkUsuario', $PKUSUARIO)->exists();
        if ($PKUSUARIO && !$ahorroExistente) {
            return redirect()->back()->with('warning', 'Registra un ahorro primero');
        } else {
            return view('formMovimiento');
        }
    } else {
        return redirect('/');
    }
})->name('realizarMovimiento');

Route::get('/movimientos', [Movimientos_controller::class, 'mostrarMovimientos'])->name('movimientos.mostrar');
Route::post('/registrandoMovimiento', [Movimientos_controller::class, 'insertar'])->name('movimientos.insertar');

// ----------------------------------------------------------------------------------------------------------------

// Deudas ----------------------------------------------------------------------------------------------------

Route::get('/deudas', function () {
    $PKUSUARIO = session('pkUsuario');
    if ($PKUSUARIO) {
        return view('listaDeudas');
    } else {
        return redirect('/');
    }
})->name('deudasRegistradas');

Route::get('/abono/deuda/{pkDeuda}', [Deuda_controller::class, 'mostrarDeudaAbono'])->name('deuda.mostrarDeudaAbono');
Route::put('/abonando/deuda/{pkDeuda}', [Deuda_controller::class, 'abono'])->name('deuda.abono');

Route::get('/deudas', [Deuda_controller::class, 'mostrarDeudas'])->name('deuda.mostrar');
Route::get('/obtener-movimiento-deuda/{pkMovimientos}', [Deuda_controller::class, 'obtenerMovimientoDeuda'])->name('deuda.mostrarMovimientoDeuda');

// ----------------------------------------------------------------------------------------------------------------
