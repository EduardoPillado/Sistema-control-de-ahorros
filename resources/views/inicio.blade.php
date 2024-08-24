<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('img/CA_imagotipo.ico') }}" rel="icon">
    <title>Inicio</title>
</head>
<body>

    @include('header')

    <div class="inicio-container">
        <div class="inicio-column">

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Movimientos recientes</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        @if ($datosMovimientos->isEmpty())
                                            <h2>No hay ningún movimiento registrado</h2>
                                        @else
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Movimiento</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($datosMovimientos as $dato )
                                                    <tr>
                                                        <td>{{ $dato->fechaMovimiento }}</td>
                                                        <td>{{ $dato->tipoMovimiento->nombreTipoMovimiento }}</td>
                                                        <td>${{$dato->cantidadMovimiento}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <a href="{{ route('movimientos.mostrar') }}" title="Ver todos los movimientos"><i class="bi bi-card-list bi-custom"></i></a>
            
        </div>
        <div class="inicio-column">

            @if ($datosAhorro->isEmpty())
                <h2>No hay ningún ahorro registrado</h2>
            @else
                @foreach ( $datosAhorro as $dato )
                    <h2 class="cant-ahorro">${{ $dato }}</h2>
                @endforeach
                <br>
                <a href="{{ route('realizarMovimiento') }}" title="Realizar movimiento"><i class="bi bi-cash-stack bi-custom"></i></a>
            @endif

        </div>
    </div>
    
</body>
</html>