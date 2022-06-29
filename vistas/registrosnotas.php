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
    <main class="completo">
        <table id="registrosnotas" class="table table-striped  table-responsive-lg">
            <thead>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Cuenta</th>
                <th>Debe</th>
                <th>Haber</th>
                <th>Importe</th>
                <th>Tipo LM</th>
                <th>LM</th>
                <th>AN8</th>
            </thead>
        </table>
    </main>
    <footer></footer>
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