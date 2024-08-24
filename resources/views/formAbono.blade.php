<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('img/CA_imagotipo.ico') }}" rel="icon">
    <title>Registrar abono</title>
</head>
<body>

    @include('header')

    <div class="container">
        <center>
            <form action="{{ route('deuda.abono', $datosDeuda->pkDeuda) }}" method="post">
                @csrf
                @method('put')

                <h2>REALIZAR ABONO</h2>
                <br>

                <input type="text" name="cantidadAbono" placeholder="Cantidad a abonar" autocomplete="off" required>

                <input type="hidden" name="cantidadMovimiento" value="{{ $datosDeuda->movimientos->cantidadMovimiento }}">

                <input type="submit" value="Realizar abono">

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