<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Ahorro;
use App\Models\Movimientos;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Usuario_controller extends Controller
{
    use ValidatesRequests;
    
    public function login(Request $req){
        $this->validate($req, [
            'nombreUsuario' => 'required',
            'contraseña' => 'required',
        ]);

        $credentials = $req->only('nombreUsuario', 'contraseña');

        $usuario = $this->obtenerUsuarioPorNombre($credentials['nombreUsuario']);

        if ($usuario && password_verify($credentials['contraseña'], $usuario->contraseña)) {
            if ($usuario->estatusUsuario == 1) {
                session(['pkUsuario' => $usuario->pkUsuario, 'nombreUsuario' => $usuario->nombreUsuario]);

                $ahorro = Ahorro::where('fkUsuario', $usuario->pkUsuario)->first();
                if (!$ahorro) {
                    return redirect()->route('realizarAhorro')->with('info', 'Registra tu cantidad de ahorro actual');
                }

                return redirect('/inicio')->with('success', 'Bienvenido Usuario');
            } else {
                return redirect('/')->with('error', 'El usuario no es válido');
            }
        } else {
            return redirect('/')->with('error', 'Datos incorrectos');
        }
    }

    private function obtenerUsuarioPorNombre($nombreUsuario){
        $usuario = Usuario::where('nombreUsuario', $nombreUsuario)->first();
        return $usuario;
    }

    public function logout() {
        session()->forget(['pkUsuario', 'nombreUsuario']);
        return redirect('/')->with('success', 'Sesión cerrada');
    }

    public function insertar(Request $req){
        $req->validate([
            'nombreUsuario' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9 ]+$/', 'max:255'],
            'correo' => ['required', 'regex:/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', 'email', 'max:255'],
            'contraseña' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9 ]+$/', 'min:8', 'max:255'],
        ], [
            'nombreUsuario.required' => 'El nombre de usuario es obligatorio.',
            'nombreUsuario.regex' => 'El nombre de usuario solo puede contener letras, números y espacios.',
            'nombreUsuario.max' => 'El nombre de usuario no puede tener más de :max caracteres.',
    
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.regex' => 'El correo electrónico no tiene un formato válido.',
            'correo.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'correo.max' => 'El correo electrónico no puede tener más de :max caracteres.',
    
            'contraseña.required' => 'La contraseña es obligatoria.',
            'contraseña.regex' => 'La contraseña solo puede contener letras, números y espacios.',
            'contraseña.min' => 'La contraseña debe tener al menos :min caracteres.',
            'contraseña.max' => 'La contraseña no puede tener más de :max caracteres.',
        ]);

        $usuario=new Usuario();
        
        $usuario->nombreUsuario=$req->nombreUsuario;
        $usuario->correo=$req->correo;
        $pass = $req->input('contraseña');
        $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 10]);
        $usuario->contraseña=$hash;
        $usuario->estatusUsuario=1;

        $usuario->save();
        
        if ($usuario->pkUsuario) {
            return redirect('/')->with('success', 'Registro exitoso');
        } else {
            return back()->with('error', 'Hay algún problema con la información');
        }
    }

    public function mostrarAhorro_Movimientos() {
        $PKUSUARIO = session('pkUsuario');
        if ($PKUSUARIO) {
            $datosAhorro=Ahorro::where('fkUsuario', $PKUSUARIO)->pluck('cantidadAhorro');
            $datosMovimientos = Movimientos::where('fkUsuario', $PKUSUARIO)
                ->orderBy('fechaMovimiento', 'desc')
                ->limit(5)
                ->get();
            return view('inicio', compact('datosAhorro', 'datosMovimientos'));
        } else {
            return redirect('/');
        }
    }
}
