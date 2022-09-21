<?php
session_start();
if (time() - $_SESSION['tiempo'] > 500) {
    //session_destroy();
    /* Aquí redireccionas a la url especifica */
    session_destroy();
    header('Location: ' . "index.php?m=6");
    //die();
} else {
    $_SESSION['tiempo'] = time();
}
if ($_SESSION['usuario'] && $_SESSION['rol'] == 1) {
    include_once('conexion/conexion.php');
    setlocale(LC_ALL, "es_CO");
    date_default_timezone_set('America/Bogota');

    if (isset($_GET['b'])) {
        $buscar = $_GET['b'];
    } else {
        $buscar = "";
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
        <SCRIPT lang="javascript" type="text/javascript" src="./an/an.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <title>Configuración AN8</title>
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
                    <h2>Lista de AN8</h2>
                </div>
                <section class="parametros">
                    <span class="btn btn-primary boton-parametro" data-toggle="modal" data-target="#nuevacuenta">
                        <b> Registrar AN8</b>
                    </span>
                    <div class="form-group buscador-mediano">
                        <input placeholder="Buscar" style="text-align:center;margin-right:5%" class=" form-control" id="textobuscar" name="textobuscar" type="text">
                        <button title="Buscar" type="button" id="buscar" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>
                </section>
                <div class="modal fade" id="nuevacuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Registro de AN8</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="desde">Id.AN8:</label>
                                            <input style="text-align:center" class=" form-control " id="idn" name="idn" type="number">

                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="desde">Nombre:</label>
                                            <input style="text-align:center" class=" form-control " id="nombren" name="nombren" type="text">
                                        </div>
                                        <div class="form-row formulario">

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <p>Favor verificar que no exista un AN8 con este id, de lo contrario no se completará el registro.</p>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerar</button>
                                <button type="button" id="registrar" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="registrosnotas" class="table table-striped  table-responsive-lg usuarios ">
                    <thead>
                        <tr>
                            <th> Id.An8 </th>
                            <th> Descripción </th>
                            <th> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($buscar == "") {
                            $consultacuentas = "select * from listaan where idan < 1000";
                            $querycuentas = mysqli_query($link, $consultacuentas) or die($consultacuentas);
                            while ($filascuentas = mysqli_fetch_array($querycuentas)) {
                        ?>
                                <tr>
                                    <td> <?php echo $filascuentas['idan'] ?> </td>
                                    <td> <?php echo $filascuentas['nombre'] ?> </td>
                                    <td>
                                        <SCRIPT lang="javascript" type="text/javascript" src="./cuentas/cuentas.js"></script>
                                        <button onclick="datosan('<?php echo $filascuentas['idan'] ?>')" type="button" title="Eliminar cuenta" id="delete" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            $consultacuentas = "select * from listaan where idan like '$buscar%'";
                            $querycuentas = mysqli_query($link, $consultacuentas) or die($consultacuentas);
                            $filascuentas = mysqli_num_rows($querycuentas);
                            if ($filascuentas == 0) {
                                $consultacuentas = "select * from listaan where nombre like '$buscar%'";
                                $querycuentas = mysqli_query($link, $consultacuentas) or die($consultacuentas);
                                $filascuentas = mysqli_num_rows($querycuentas);
                            }
                            while ($filascuentas = mysqli_fetch_array($querycuentas)) {
                            ?>
                                <tr>
                                    <td> <?php echo $filascuentas['idan'] ?> </td>
                                    <td> <?php echo $filascuentas['nombre'] ?> </td>
                                    <td>
                                        <SCRIPT lang="javascript" type="text/javascript" src="./cuentas/cuentas.js"></script>
                                        <button onclick="datosan('<?php echo $filascuentas['idan'] ?>')" type="button" title="Eliminar cuenta" id="delete" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <div class="modal fade" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Eliminar cuenta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h6>Esta seguro que desea eliminar este AN8?</h6>
                                <input type="hidden" name="idane" id="idane">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="eliminar" class="btn btn-danger">Eliminar</button>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#registrar').click(function() {
            a = 0;
            id = $('#idn').val();
            nombre = $('#nombren').val();
            if (id <= 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'El valor del id debe ser mayor a cero.', function() {
                    alertify.success('Ok');
                });
            }
            if (nombre.length < 4) {
                a = 1;
                alertify.alert('ATENCION!!', 'El nombre de AN8 debe de tener mas de 3 caracteres.', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                registraan(id, nombre);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        });
        $('#buscar').click(function() {
            buscar = $('#textobuscar').val();
            if (buscar.length > 0 && buscar.length < 4) {
                alertify.alert('ATENCION!!', 'El valor a buscar debe tener mas de 3 caracteres.', function() {
                    alertify.success('Ok');
                });
            } else {
                location.href = `listaan.php?b=${buscar}`;
            }

        });
        $('#eliminar').click(function() {
            id = $('#idane').val();

            eliminaran(id);
            setTimeout(function() {
                window.location.reload();
            }, 1000);

        });
    });
</script>
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