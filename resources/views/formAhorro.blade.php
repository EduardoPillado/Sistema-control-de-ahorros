<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('img/CA_imagotipo.ico') }}" rel="icon">
    <title>Registrar ahorro</title>
</head>
<body>

    @include('header')
    @php
        use Carbon\Carbon;

        $PKUSUARIO = session('pkUsuario');
    @endphp

    <div class="container">
        <center>
            <form action="{{ route('ahorro.insertar') }}" method="post">
                @csrf

                <h2>REGISTRAR AHORRO</h2>
                <br>

                <input type="text" name="cantidadAhorro" placeholder="Cantidad de dinero" autocomplete="off" required>

                <input type="datetime-local" name="fechaIngreso" value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>

                <input type="hidden" name="fkUsuario" value="{{ $PKUSUARIO }}">

                <input type="submit" value="Registrar ahorro">

            </form>

        </center>
    </div>

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
    
</body>
</html>