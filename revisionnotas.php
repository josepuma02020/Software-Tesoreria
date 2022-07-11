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
        <link rel="stylesheet" href="./css/revisionnotas/desktop.css">
        <SCRIPT src="librerias/alertify/alertify.js"></script>
    </head>

    <body>
        <header>
            <?php
            include_once($_SESSION['menu']);
            ?>
            <section class="titulo-pagina">
                <h3>Notas Registradas</h3>
            </section>
        </header>

        <main class=" container container-md">
            <form action="" method="post">
                <div class="form-row formulario">
                    <div class="form-group mediano">
                        <label for="desde">Desde:</label>
                        <input value="<?php echo $desde ?>" style="text-align:center" class=" form-control " id=" desde" name="desde" type="date">
                    </div>
                    <div class="form-group mediano">
                        <label for="hasta">Hasta:</label>
                        <input value="<?php echo $hasta ?>" style="text-align:center" class="form-control " id="hasta" name="hasta" type="date" value="<?php  ?>">
                    </div>
                    <div class="form-group pequeno">
                        <label for="mostrar">Mostrar</label>
                        <select style="text-align: center;" id="mostrar" class="form-control col-md-8 ">
                            <option value="0" selected>Todo</option>
                            <option value="1">Cerradas</option>
                            <option value="2">Abiertas</option>
                        </select>
                    </div>
                    <button type="button" id="buscar" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="tabla-registros">
                <table id="registrosnotas" class="table table-striped  table-responsive-lg ">
                    <THEAD>
                        <tr>
                            <th> Fecha </th>
                            <th> Usuario </th>
                            <th> Tipo</th>
                            <th> Clasificación </th>
                            <th> Batch </th>
                            <th> Comentario </th>
                            <th> Acciones </th>
                        </tr>
                    </THEAD>
                    <TBODY>
                        <?php
                        $consultanotas = "SELECT a.*,b.nombre,c.documento,d.clasificacion FROM notascontables a INNER JOIN usuarios b on a.idusuario = b.idusuario 
                    INNER JOIN tiposdocumento c on c.idtipo=a.idtipodocumento INNER JOIN clasificaciones d on d.idclasificacion=a.idclasificacion";
                        $query = mysqli_query($link, $consultanotas) or die($consultanotas);
                        while ($filas1 = mysqli_fetch_array($query)) {
                        ?>
                            <TR>
                                <TD><?php echo $filas1['fecha'] . ' ' . $filas1['hora']; ?> </TD>
                                <TD><?php echo $filas1['nombre']; ?> </TD>
                                <TD><?php echo $filas1['documento']; ?> </TD>
                                <TD><?php echo $filas1['clasificacion']; ?> </TD>
                                <TD><?php echo $filas1['batch']; ?> </TD>
                                <TD><?php echo $filas1['comentario']; ?> </TD>
                                <TD>
                                    <!-- <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script> -->
                                    <a href="home.php?id=<?php echo "$filas1[idnota]" ?>">
                                        <button onclick="" type="button" id="detalles" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </a>
                                </TD>
                            </TR>
                        <?php } ?>
                    </tbody>
                </table>
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
            location.href = `prestamoscerrados.php?desde=${desde}&hasta=${hasta}`;
        });
        $('#detalles').click(function() {
            a = 0;
            desde = $('#desde').val();
            hasta = $('#hasta').val();
            location.href = `prestamoscerrados.php?desde=${desde}&hasta=${hasta}`;
        });
    });
</script>