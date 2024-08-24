<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('img/CA_imagotipo.ico') }}" rel="icon">
    <title>Inicio de sesión</title>
    {{-- Iconos --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- CSS --}}
    <link rel="stylesheet" href="css/estilo.css?=2">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body oncopy="return false" onpaste="return false">

    @include('mensaje')

    <div class="form-container">

        <form action="{{ route('usuario.login') }}" method="post">
            @csrf

            <h1 class="tittle">¡BIENVENIDO USUARIO!</h1>
            <center><i class="bi bi-person-square"></i></center>

            <input type="text" name="nombreUsuario" placeholder="Usuario" autocomplete="off" required>

            <input type="password" name="contraseña" placeholder="Contraseña" required>

            <center>
                <input type="submit" value="Iniciar Sesión">
            </center>

            <p>¿Aún no tienes cuentas?, <a href="{{ route('registro') }}">registrate aquí</a>.</p>

            {{-- <p>¿Olvidaste tu contraseña?, <a href="{{ route('usuario.recuperarContraseña') }}">recuperala aquí</a>.</p> --}}

        </form>
        
    </div>
    
</body>
</html>