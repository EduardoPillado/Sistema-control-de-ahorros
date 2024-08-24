<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('img/CA_imagotipo.ico') }}" rel="icon">
    <title>Movimientos</title>
</head>
<body>

    @include('header')

    <div class="container list-container">
        <center>
            <h2>MOVIMIENTOS REALIZADOS</h2>
        </center>
        <br>

        <input id="busqueda" class="" type="text" placeholder="Buscar"/>

        <table id="movimientos">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Descripción del movimiento</th>
                    <th>Tipo de movimiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datosMovimientos as $dato )
                    <tr>
                        <td>{{ $dato->fechaMovimiento }}</td>
                        <td>
                            @if ($dato->cantidadMovimiento !== null)
                                ${{ $dato->cantidadMovimiento }}
                            @else
                                No disponible
                            @endif
                        </td>
                        <td>{{ $dato->descripcion }}</td>
                        <td>{{ $dato->tipoMovimiento->nombreTipoMovimiento }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            var table = $('#movimientos').DataTable({
                responsive: true,
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ movimientos",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún movimiento registrado",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ movimientos registrados",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 movimientos registrados",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ movimientos registrados)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });

            $('#busqueda').on('keyup', function (e) {
                var filtroBusqueda = $('#busqueda').val();
                table.search(filtroBusqueda).draw();
            });
        });
    </script>
    
</body>
</html>