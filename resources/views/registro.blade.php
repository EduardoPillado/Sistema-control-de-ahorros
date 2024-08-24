<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('img/CA_imagotipo.ico') }}" rel="icon">
    <title>Registro</title>
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

        <form id="form-register" action="{{ route('usuario.insertar') }}" method="post">
            @csrf

            <h1 class="tittle">
                Regístrate
            </h1>

            <input type="text" name="nombreUsuario" placeholder="Usuario" autocomplete="off" required>

            <input type="email" id="correo" name="correo" placeholder="Correo" autocomplete="off" required>

            <input type="email" id="conf_correo" name="conf_correo" placeholder="Confirmar correo" autocomplete="off" required>

            <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>

            <input type="password" id="conf_contraseña" name="conf_contraseña" placeholder="Confirmar contraseña" required>

            <center>
                <input type="submit" value="Registrarse">
            </center>

            <p>¿Ya cuentas con una cuenta?, <a href="{{ route('login') }}">inicia sesión</a>.</p>

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <script>
                        function showErrorToast(message) {
                            Swal.fire({
                                title: message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                icon: 'error',
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer);
                                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                                }
                            });
                        }
                        showErrorToast('{{ $error }}');
                    </script>
                @endforeach
            @endif
            
            <script>
                document.getElementById('form-register').addEventListener('submit', function(event) {
                    var correo = document.getElementById('correo').value;
                    var confirmar_correo = document.getElementById('conf_correo').value;
                    var contraseña = document.getElementById('contraseña').value;
                    var confirmar_contraseña = document.getElementById('conf_contraseña').value;
            
                    if (correo !== confirmar_correo) {
                        Swal.fire({
                            title: 'Los correos no coinciden.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            icon: 'error',
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                        event.preventDefault();
                    }

                    if (contraseña !== confirmar_contraseña) {
                        Swal.fire({
                            title: 'Las contraseñas no coinciden.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            icon: 'error',
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                        event.preventDefault();
                    }
                });
            </script>

        </form>
        
    </div>
    
</body>
</html>