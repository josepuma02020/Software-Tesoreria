<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
    <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
    <SCRIPT src="librerias/alertify/alertify.js"></script>
    <title>Document</title>
</head>

<body>
    <header></header>
    <main class="tabla-registros">
        <table id="registrosnotas" class="table table-striped  table-responsive-lg">
            <thead>
                <th>Fecha</th>
                <th>Cuenta</th>
                <th>Descripción</th>
                <th>Debe</th>
                <th>Haber</th>
                <th>Importe</th>
                <th>T.LM</th>
                <th>LM</th>
                <th>AN8</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                <form action="#" method="POST" class="form-registros">
                    <tr>
                        <td>
                            <input class="form-control" type="date" required id="date" name="date">
                        </td>
                        <td style="width: 13%;">
                            <input class="form-control" type="text" required id="cuenta" name="cuenta">
                        </td>
                        <td style="width: 15% ;">
                            <input class="form-control" type="text" required id="descripcion" name="descripcion" disabled>
                        </td>
                        <td style="width:8%">
                            <input class="form-control" type="number" required id="debe" name="debe">
                        </td>
                        <td style="width:8%">
                            <input class="form-control" type="number" required id="haber" name="haber">
                        </td>
                        <td style="width:10%">
                            <input class="form-control" type="number" required id="importe" name="importe" disabled>
                        </td>
                        <td>
                            <input class="form-control" type="text" required id="tipolm" name="tipolm" disabled>
                        </td>
                        <td style="width:10%">
                            <input class="form-control" type="text" required id="lm" name="lm" required>
                        </td>
                        <td style="width:10%">
                            <input class="form-control" type="text" required id="an" name="an" required>
                        </td>
                        <td style="width: 8%;">
                            <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
                            <button onclick="" type="button" id="actualiza" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                    <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z" />
                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
                                </svg>
                            </button>
                            <!-- <button onclick="" type="button" id="eeeee" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                                    <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z" />
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                </svg>
                            </button> -->
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>

    </main>
    <footer>
        <button id="save" name="save" class="btn btn-primary">Guardar</button>
        <button id="save" name="save" class="btn btn-secondary">Cancelar</button>
        <button id="save" name="save" class="btn btn-danger">Eliminar</button>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            tabla = $('#registrosnotas').DataTable({
                language: {
                    url: '../vendor/datatables/es-ar.json',
                    lengthMenu: "Mostrar _MENU_ Registros",
                    loadingRecords: "Cargando...",
                    search: "Buscar:",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                    infoEmpty: "No se encontraron registros",
                    zeroRecords: "Sin Resultados",
                    paginate: {
                        first: "Primera pagina",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Ultima"
                    },
                }
            });
        });
    </script>
</body>

</html>