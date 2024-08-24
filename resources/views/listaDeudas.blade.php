<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('img/CA_imagotipo.ico') }}" rel="icon">
    <title>Deudas</title>
</head>
<body>

    @include('header')

    <div class="container list-container">
        <center>
            <h2>DEUDAS</h2>
        </center>
        <br>

        <div class="deudas-container">
            <div class="cantidad-en-deudas">
                <h2>Deudas al usuario</h2>
                <h3>${{ $sumDeudasOtros }}</h3>
            </div>
            <div class="cantidad-en-deudas">
                <h2>Deudas del usuario</h2>
                <h3>${{ $sumDeudasUsuario }}</h3>
            </div>
        </div>

        <input id="busqueda" class="" type="text" placeholder="Buscar"/>

        <table id="deudas">
            <thead>
                <tr>
                    <th>Persona que debe/se le debe</th>
                    <th>Deuda o Deudor</th>
                    <th>Cantidad en deuda</th>
                    <th>Datos del movimiento</th>
                    <th>Realizar abono</th>
                    <th>Estatus de deuda</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datosDeuda as $dato )
                    <tr class="{{ ($dato->estatusDeuda == 1) ? 'deudaSinPagar' : (($dato->estatusDeuda == 0) ? 'deudaPagada' : 'deudaParcial') }}">
                        <td>{{ $dato->nombrePersona }}</td>
                        <td>{{ $dato->tipoDeuda->nombreTipoDeuda }}</td>
                        <td>
                            @if ($dato->cantidadAbonoRestante !== null)
                                ${{ $dato->cantidadAbonoRestante }}
                            @else
                                No disponible
                            @endif
                        </td>
                        <td>
                            <center>
                                <a title="Datos del movimiento" href="#" class="mostrar-movimiento-deuda" data-id="{{ $dato->fkMovimientos }}" data-bs-toggle="modal" data-bs-target="#movimientoDeudaModal">
                                    <i class="bi bi-file-earmark-text action-icons"></i>
                                </a>                                
                            </center>
                        </td>
                        <td>
                            <center>
                                <a title="Realizar abono" href="{{ route('deuda.mostrarDeudaAbono', $dato->pkDeuda) }}" class="abono-icon">
                                    <i class="bi bi-credit-card-2-back action-icons"></i>
                                </a> 
                            </center>
                        </td>
                        <td>
                            <center>
                                @if ($dato->estatusDeuda == 1)
                                    <span class="badge bg-danger">Sin pagar</span>
                                @elseif ($dato->estatusDeuda == 2)
                                    <span class="badge bg-warning">Parcialmente pagada</span>
                                @elseif ($dato->estatusDeuda == 0)
                                    <span class="badge bg-success">Pagada</span>
                                @endif
                            </center>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            var table = $('#deudas').DataTable({
                responsive: true,
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ deudas",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún movimiento registrado",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ deudas registradas",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 deudas registradas",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ deudas registradas)",
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

        $(document).on('click', '.mostrar-movimiento-deuda', function(e) {
            e.preventDefault();
            
            var movimientoId = $(this).data('id');

            $.ajax({
                url: '/obtener-movimiento-deuda/' + movimientoId,
                type: 'GET',
                success: function(response) {
                    $('#detallesMovimiento').html(response);
                    $('#movimientoDeudaModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>

    <div class="modal fade" id="movimientoDeudaModal" tabindex="-1" aria-labelledby="movimientoDeudaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="movimientoDeudaModalLabel">Detalles del movimiento de deuda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="detallesMovimiento"></div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>