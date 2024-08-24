<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Ahorro;

class VerificarAhorroMiddleware
{
    // public function handle($request, Closure $next)
    // {
    //     $usuario = $request->session()->get('pkUsuario');
        
    //     // Verificar si el usuario tiene un registro de ahorro asociado
    //     $ahorro = Ahorro::where('fkUsuario', $usuario)->first();

    //     if (!$ahorro) {
    //         return redirect('/realizarAhorro')->with('warning', 'Registra un ahorro primero');
    //     }

    //     return $next($request);
    // }
}
