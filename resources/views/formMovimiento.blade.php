<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('img/CA_imagotipo.ico') }}" rel="icon">
    <title>Realizar movimiento</title>
</head>
<body>

    @include('header')
    @php
        use Carbon\Carbon;

        $PKUSUARIO = session('pkUsuario');

        use App\Models\TipoMovimiento;
        $datosTipoMovimiento=TipoMovimiento::all();

        use App\Models\TipoDeuda;
        $datosTipoDeuda=TipoDeuda::all();
    @endphp

    <div class="container">
        <center>
            <form action="{{ route('movimientos.insertar') }}" method="post">
                @csrf

                <h2>REALIZAR MOVIMIENTO</h2>
                <br>

                <input type="text" name="cantidadMovimiento" placeholder="Cantidad de dinero" autocomplete="off" required>

                <textarea name="descripcion" placeholder="Descripción del movimiento" cols="30" autocomplete="off" required></textarea>

                <select name="fkTipoMovimiento" required>
                    <option value="">Selecciona el tipo de movimiento a realizar</option>
                    @foreach ($datosTipoMovimiento as $dato)
                        <option value="{{$dato->pkTipoMovimiento}}">{{$dato->nombreTipoMovimiento}}</option>
                    @endforeach
                </select>

                <input type="datetime-local" name="fechaMovimiento" value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>

                <div class="checkbox-deuda">
                    <label id="esDeudaLabel" for="esDeuda">
                        <input type="checkbox" name="esDeuda" id="esDeuda"> ¿Es una deuda?
                    </label>
                    <a href="#" id="detallesDeuda"><i class="bi bi-info-circle"></i></a>
                </div>

                <div id="camposDeuda">
                    <div class="input-icon-info">
                        <input type="text" name="nombrePersona" placeholder="Nombre de la persona" autocomplete="off"> 
                        <a href="#" id="detallesPersona"><i class="bi bi-info-circle"></i></a>
                    </div>

                    <div class="input-icon-info">
                        <select name="fkTipoDeuda">
                            <option value="">Selecciona que tipo de deuda es</option>
                            @foreach ($datosTipoDeuda as $dato)
                                <option value="{{$dato->pkTipoDeuda}}">{{$dato->nombreTipoDeuda}}</option>
                            @endforeach
                        </select> 
                        <a href="#" id="detallesTipoDeuda"><i class="bi bi-info-circle"></i></a>
                    </div>
                </div>

                <input type="hidden" name="fkUsuario" value="{{ $PKUSUARIO }}">

                <input type="submit" value="Registrar movimiento">

            </form>

        </center>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkbox = document.getElementById('esDeuda');
            var camposDeuda = document.getElementById('camposDeuda');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    camposDeuda.style.display = 'block';
                } else {
                    camposDeuda.style.display = 'none';
                }
            });
        });

        document.getElementById('detallesDeuda').addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                text: "Seleccione la casilla en caso de que su movimiento sea una deuda, ya sea de usted a otra persona/institución o le deban a usted."
            });
        });

        document.getElementById('detallesPersona').addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                text: "Escriba el nombre de la persona a la que le debe o la persona que el debe a usted."
            });
        });

        document.getElementById('detallesTipoDeuda').addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                text: "'Deuda' si una persona/institución le debe a usted. 'Deudor' si usted le debe a una persona/institución."
            });
        });
    </script>

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