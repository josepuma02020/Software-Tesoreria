<?php
session_start();
if (time() - $_SESSION['tiempo'] > 500) {
    //session_destroy();
    /* Aquí redireccionas a la url especifica */
    session_destroy();
    header('Location: ' . "index.php?m=5");
    //die();
} else {
    $_SESSION['tiempo'] = time();
}
if ($_SESSION['usuario'] && $_SESSION['rol'] == 1) {
    include_once('conexion/conexion.php');
    setlocale(LC_ALL, "es_CO");
    date_default_timezone_set('America/Bogota');
    if (isset($_GET['desde'])) {
        $desde = $_GET['desde'];
    } else {
        $desde = date("Y-m-01");
    }
    if (isset($_GET['hasta'])) {
        $hasta = $_GET['hasta'];
    } else {
        $hasta = date("Y-m-d");
    }
    $fechahoyval = date("Y") . '-' . date("m") . '-' . date("j");

    //consultanotas
    if (isset($_GET['m'])) {
        $mostrar = $_GET['m'];
    } else {
        $mostrar = 't';
    }

    switch ($mostrar) {
        case 't':
            $consultanotas = "SELECT SUM(e.debe)-sum(e.haber) 'importe',a.*,b.nombre,c.documento,d.clasificacion FROM notascontables a 
            INNER JOIN usuarios b on a.idusuario = b.idusuario INNER JOIN tiposdocumento c on c.idtipo=a.idtipodocumento 
            INNER JOIN clasificaciones d on d.idclasificacion=a.idclasificacion INNER JOIN registrosdenota e on e.idnota=a.idnota where a.fecha between '$desde' and '$hasta' GROUP by a.idnota;";
            break;
        case 'a':
            $consultanotas = "SELECT SUM(e.debe)-sum(e.haber) 'importe',a.*,b.nombre,c.documento,d.clasificacion FROM notascontables a 
            INNER JOIN usuarios b on a.idusuario = b.idusuario INNER JOIN tiposdocumento c on c.idtipo=a.idtipodocumento 
            INNER JOIN clasificaciones d on d.idclasificacion=a.idclasificacion INNER JOIN registrosdenota e on e.idnota=a.idnota where a.batch IS NULL and a.fecha between '$desde' and '$hasta' GROUP by a.idnota;";
            break;
        case 'c':
            $consultanotas = "SELECT SUM(e.debe)-sum(e.haber) 'importe',a.*,b.nombre,c.documento,d.clasificacion FROM notascontables a 
            INNER JOIN usuarios b on a.idusuario = b.idusuario INNER JOIN tiposdocumento c on c.idtipo=a.idtipodocumento 
            INNER JOIN clasificaciones d on d.idclasificacion=a.idclasificacion INNER JOIN registrosdenota e on e.idnota=a.idnota where a.batch IS NOT NULL  and a.fecha between '$desde' and '$hasta' GROUP by a.idnota;";
            break;
    }

?>
    <HTML>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./librerias/alertify/css/alertify.css" />
        <link rel="stylesheet" type="text/css" href="./librerias/alertify/css/themes/default.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link type="text/css" href="./librerias/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel=" Stylesheet" />
        <link rel="stylesheet" href="./css/configuracion/desktop.css">
        <SCRIPT lang="javascript" type="text/javascript" src="notascontables/notascontables.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <title>Revisión de notas</title>
    </head>

    <body>
        <header>
            <?php
            include_once($_SESSION['menu']);
            ?>

        </header>
        <main style="max-width:90% ;" class=" container container-md">


            <div class="tabla-registros">
                <div class="titulo-tabla">
                    <h2>Cuentas</h2>
                </div>
                <section class="parametros">
                    <span class="btn btn-primary boton-parametro" data-toggle="modal" data-target="#nuevousuario">
                        <b> Nuevo Usuario</b>
                    </span>
                </section>
                <table id="registrosnotas" class="table table-striped  table-responsive-lg usuarios ">
                    <thead>
                        <tr>
                            <th> Cuenta Contable </th>
                            <th> Descripcion </th>
                            <th> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $consultausuarios = "select * from cuentas";
                        $queryusuarios = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                        while ($filasusuarios = mysqli_fetch_array($queryusuarios)) {
                        ?>
                            <tr>
                                <td> <?php echo $filasusuarios['idcuenta'] ?> </td>
                                <td> <?php echo $filasusuarios['descripcion'] ?> </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editar"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
        </footer>
    </body>

    </HTML>
<?php
} else {
    // header('Location: ' . "usuarios/cerrarsesion.php");
}
?>

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
                info: "",
                //info: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
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
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {


        $('#buscar').click(function() {
            a = 0;
            desde = $('#desde').val();
            hasta = $('#hasta').val();
            mostrar = $('#mostrar').val();
            location.href = `revisionnotas.php?desde=${desde}&hasta=${hasta}&m=${mostrar}`;
        });
        $('#detalles').click(function() {
            a = 0;
            desde = $('#desde').val();
            hasta = $('#hasta').val();
            location.href = `prestamoscerrados.php?desde=${desde}&hasta=${hasta}`;
        });
    });
</script>