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
        <SCRIPT lang="javascript" type="text/javascript" src="./cuentas/cuentas.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <title>Cuentas</title>
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
                    <span class="btn btn-primary boton-parametro" data-toggle="modal" data-target="#nuevacuenta">
                        <b> Nueva cuenta</b>
                    </span>
                </section>
                <?php
                switch ($_SESSION['idproceso']) {
                    case 1:
                ?>
                        <div class="modal fade" id="nuevacuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Nueva cuenta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="">
                                            <div class="form-row formulario">
                                                <div class="form-group mediano-grande">
                                                    <label for="desde">Cuenta contable:</label>
                                                    <input style="text-align:center" class=" form-control " id="cuentan" name="cuentan" type="text">
                                                </div>
                                                <div class="form-group mediano-grande">
                                                    <label for="hasta">Descipción de Cuenta:</label>
                                                    <input style="text-align:center" class="form-control " id="descripcionn" name="descripcionn" type="text">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerar</button>
                                        <button type="button" id="registrar" class="btn btn-primary">Registrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="registrosnotas" class="table table-striped  table-responsive-lg usuarios ">
                            <thead>
                                <tr>
                                    <th> Cuenta Contable </th>
                                    <th> Descripcion de cuenta </th>
                                    <th> Acciones </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $consultacuentas = "select * from cuentas where idproceso = 1";
                                $querycuentas = mysqli_query($link, $consultacuentas) or die($consultacuentas);
                                while ($filascuentas = mysqli_fetch_array($querycuentas)) {
                                ?>
                                    <tr>
                                        <td> <?php echo $filascuentas['idcuenta'] ?> </td>
                                        <td> <?php echo $filascuentas['descripcion'] ?> </td>
                                        <td>
                                            <SCRIPT lang="javascript" type="text/javascript" src="./cuentas/cuentas.js"></script>
                                            <button onclick="datoscuenta('<?php echo $filascuentas['idcuenta'] ?>','<?php echo $filascuentas['descripcion'] ?>')" type="button" title="Editar cuenta" id="detalles" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                                </svg>
                                            </button>
                                            <button onclick="datoscuenta('<?php echo $filascuentas['idcuenta'] ?>','<?php echo $filascuentas['descripcion'] ?>')" type="button" title="Eliminar cuenta" id="delete" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
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
                        <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar cuenta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="">
                                            <div class="form-row formulario">
                                                <div class="form-group mediano-grande">
                                                    <label for="desde">Cuenta contable:</label>
                                                    <input disabled style="text-align:center" class=" form-control " id="cuenta" name="cuenta" type="text">
                                                </div>
                                                <div class="form-group mediano-grande">
                                                    <label for="hasta">Descipcion de Cuenta:</label>
                                                    <input style="text-align:center" class="form-control " id="descripcion" name="descripcion" type="text">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerar</button>
                                        <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        break;
                    case 4:
                    ?>
                        <div class="modal fade" id="nuevacuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Nueva cuenta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="">
                                            <div class="form-row formulario">
                                                <div class="form-group mediano-grande">
                                                    <label for="desde">Concepto:</label>
                                                    <input style="text-align:center" class=" form-control " id="concepton" name="concepton" type="text">
                                                </div>
                                                <div class="form-group mediano-grande">
                                                    <label for="desde">Cuenta contable:</label>
                                                    <input style="text-align:center" class=" form-control " id="cuentan" name="cuentan" type="text">
                                                </div>
                                                <div class="form-group mediano-grande">
                                                    <label for="hasta">Tipo de Cuenta:</label>
                                                    <select style="text-align:center ;" class="form-control " name="tipocuentan" id="tipocuentan">
                                                        <option value="0">Seleccionar</option>
                                                        <option value="c">Crédito</option>
                                                        <option value="d">Débito</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mediano-grande">
                                                    <label for="hasta">Descipción de Cuenta:</label>
                                                    <input style="text-align:center" class="form-control " id="descripcionn" name="descripcionn" type="text">
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerar</button>
                                        <button type="button" id="registrarcuentagestioncontable" class="btn btn-primary">Registrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="registrosnotas" class="table table-striped  table-responsive-lg usuarios ">
                            <thead>
                                <tr>
                                    <th> Concepto </th>
                                    <th> Cuenta </th>
                                    <th> Tipo </th>
                                    <th> Descripción </th>
                                    <th> Acciones </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $consultacuentas = "select * from cuentas where idproceso = 4";
                                $querycuentas = mysqli_query($link, $consultacuentas) or die($consultacuentas);
                                while ($filascuentas = mysqli_fetch_array($querycuentas)) {
                                ?>
                                    <tr>
                                        <td> <?php echo $filascuentas['concepto'] ?> </td>
                                        <td> <?php echo $filascuentas['idcuenta'] ?> </td>
                                        <td> <?php
                                                if ($filascuentas['tipo'] == 'c') {
                                                    echo 'Crédito';
                                                } else {
                                                    echo 'Débito';
                                                }
                                                ?> </td>
                                        <td> <?php echo $filascuentas['descripcion'] ?> </td>
                                        <td>
                                            <SCRIPT lang="javascript" type="text/javascript" src="./cuentas/cuentas.js"></script>
                                        
                                            <button onclick="datoscuenta('<?php echo $filascuentas['idcuenta'] ?>','<?php echo $filascuentas['descripcion'] ?>')" type="button" title="Eliminar cuenta" id="delete" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
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
                <?php
                        break;
                }
                ?>

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
                                <h6>Esta seguro que desea eliminar esta cuenta contable?</h6>
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
        $('#eliminar').click(function() {
            a = 0;
            cuenta = $('#cuenta').val();
            eliminarcuenta(cuenta);
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        });
        $('#registrarcuentagestioncontable').click(function() {
            a = 0;
            descripcion = $('#descripcionn').val();
            cuenta = $('#cuentan').val();
            concepto = $('#concepton').val();
            tipo = $('#tipocuentan').val();
            if (descripcion == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de descripcion de cuenta. ', function() {
                    alertify.success('Ok');
                });
            }
            if (cuenta == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de cuenta contable. ', function() {
                    alertify.success('Ok');
                });
            }
            if (tipo == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger el tipo de cuenta. ', function() {
                    alertify.success('Ok');
                });
            }
            if (String(concepto).length < 4) {
                a = 1;
                alertify.alert('ATENCION!!', 'EL valor de concepto debe tener al menos 4 letras.', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                registrarcuentagestioncontable(cuenta, descripcion, tipo, concepto);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }

        });
        $('#registrar').click(function() {
            a = 0;
            descripcion = $('#descripcionn').val();
            cuenta = $('#cuentan').val();
            if (descripcion == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de descripcion de cuenta. ', function() {
                    alertify.success('Ok');
                });
            }
            if (cuenta == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de cuenta contable. ', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                registrarcuenta(cuenta, descripcion);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }

        });
        $('#guardar').click(function() {
            a = 0;
            descripcion = $('#descripcion').val();
            cuenta = $('#cuenta').val();
            if (descripcion == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de descripcion de cuenta. ', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                editarcuenta(cuenta, descripcion);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }

        });
    });
</script>