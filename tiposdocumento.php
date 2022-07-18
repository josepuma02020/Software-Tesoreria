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
        <SCRIPT lang="javascript" type="text/javascript" src="./tiposdocumento/tiposdocumento.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <title>Tipos de documento</title>
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
                    <h2>Tipos de documento</h2>
                </div>
                <section class="parametros">
                    <span class="btn btn-primary boton-parametro" data-toggle="modal" data-target="#nuevacuenta">
                        <b> Nuevo Tipo</b>
                    </span>
                </section>
                <div class="modal fade" id="nuevacuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo tipo de documento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="desde">ID.Tipo:</label>
                                            <input style="text-align:center" class=" form-control " id="idn" name="idn" type="text">
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Tipo de documento:</label>
                                            <input style="text-align:center" class="form-control " id="tipon" name="tipon" type="text">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="registrar" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="registrosnotas" class="table table-striped  table-responsive-lg usuarios ">
                    <thead>
                        <tr>
                            <th> ID</th>
                            <th> Tipo de Documento </th>
                            <th> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $consultatipos = "select * from tiposdocumento";
                        $query = mysqli_query($link, $consultatipos) or die($consultatipos);
                        while ($filas = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td> <?php echo $filas['idtipo'] ?> </td>
                                <td> <?php echo $filas['documento'] ?> </td>
                                <td>
                                    <button onclick="datostipo('<?php echo $filas['idtipo'] ?>','<?php echo $filas['documento'] ?>')" type="button" title="Editar tipo de documento" id="detalles" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                        </svg>
                                    </button>
                                    <button onclick="datostipo('<?php echo $filas['idtipo'] ?>','<?php echo $filas['documento'] ?>')" type="button" title="Eliminar tipo de documento" id="delete" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="modal fade" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Eliminar tipo de documento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h6>Esta seguro que desea eliminar este tipo de documento?</h6>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="eliminar" class="btn btn-danger">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar tipo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="desde">Cuenta contable:</label>
                                            <input disabled style="text-align:center" class=" form-control " id="id" name="id" type="text">
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Descipcion de Cuenta:</label>
                                            <input style="text-align:center" class="form-control " id="tipodocumento" name="tipodocumento" type="text">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
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
        $('#registrar').click(function() {
            a = 0;
            id = $('#idn').val();
            tipo = $('#tipon').val();
            if (id == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de descripcion de cuenta. ', function() {
                    alertify.success('Ok');
                });
            }
            if (tipo == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de cuenta contable. ', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                registrartipo(id, tipo);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }

        });
        $('#guardar').click(function() {
            a = 0;
            id = $('#id').val();
            tipodocumento = $('#tipodocumento').val();
            if (tipodocumento == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de descripcion de cuenta. ', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                editartipo(id, tipodocumento);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }

        });
        $('#eliminar').click(function() {

            id = $('#id').val();
            eliminartipo(id);
            setTimeout(function() {
                window.location.reload();
            }, 1000);

        });
    });
</script>