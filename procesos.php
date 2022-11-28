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
        <link rel="stylesheet" href="./css/configuracionprocesos/desktop.css">
        <SCRIPT lang="javascript" type="text/javascript" src="./procesos/procesos.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <title>Configuración de procesos</title>
    </head>

    <body>
        <header>
            <?php
            include_once($_SESSION['menu']);
            ?>

        </header>
        <main style="max-width:90% ; display:grid" class=" container container-md">
            <div class="tabla-procesos">
                <div class="titulo-tabla">
                    <h2>Configuración de procesos</h2>
                </div>
                <section class="parametros">
                    <span class="btn btn-primary boton-parametro" data-toggle="modal" data-target="#nuevoproceso">
                        <b> Registrar proceso </b>
                    </span>
                </section>
                <div class="modal fade" id="nuevoproceso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo proceso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Equipo:</label>
                                            <select style="text-align: center;" id="equipon" name="equipon" class="form-control col-md-8 ">
                                                <?php
                                                $consultaequipos = "select a.*,b.area from equipos a inner join areas b on a.idarea=b.idarea order by equipo";
                                                $query = mysqli_query($link, $consultaequipos) or die($consultaequipos);
                                                ?> <option value="0">Seleccionar</option>
                                                <?php
                                                while ($filas1 = mysqli_fetch_array($query)) {
                                                ?>
                                                    <option value="<?php echo $filas1['idequipo'] ?>"><?php echo  $filas1['area'] . '-' . $filas1['equipo'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Proceso:</label>
                                            <input style="text-align:center" class="form-control " id="proceson" name="proceson" type="text">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="registrarproceso" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="procesos" class="table table-striped  table-responsive-lg usuarios ">
                    <thead>
                        <tr>
                            <th> Área </th>
                            <th> Equipo </th>
                            <th> Proceso </th>
                            <th> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $consultatipos = "SELECT a.idproceso,a.proceso ,b.equipo,c.area FROM procesos a inner join equipos b on a.idequipo=b.idequipo inner join areas c on c.idarea=b.idarea";
                        $query = mysqli_query($link, $consultatipos) or die($consultatipos);
                        while ($filas = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td> <?php echo $filas['area'] ?> </td>
                                <td> <?php echo $filas['equipo'] ?> </td>
                                <td> <?php echo $filas['proceso'] ?> </td>
                                <td>
                                    <button onclick="datosproceso('<?php echo $filas['idproceso'] ?>')" type="button" title="Eliminar clasificación de documento" id="delete" class="btn btn-danger" data-toggle="modal" data-target="#eliminarproceso">
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
                <div class="modal fade" id="eliminarproceso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Eliminar clasificacion de documento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input id="iduproceso" type="hidden">
                                <h6>Esta seguro que desea eliminar este proceso?</h6>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="confirmaeliminarproceso" class="btn btn-danger">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tabla-procesos">
                <div class="titulo-tabla">
                    <h2>Equipos de trabajo</h2>
                </div>
                <section class="parametros">
                    <span class="btn btn-primary boton-parametro" data-toggle="modal" data-target="#nuevoequipo">
                        <b> Registrar equipo </b>
                    </span>
                </section>
                <div class="modal fade" id="nuevoequipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo equipo de trabajo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Área:</label>
                                            <select style="text-align: center;" id="areanequipo" name="areanequipo" class="form-control col-md-8 ">
                                                <?php
                                                $consultaequipos = "select a.* from areas a order by area";
                                                $query = mysqli_query($link, $consultaequipos) or die($consultaequipos);
                                                ?> <option value="0">Seleccionar</option>
                                                <?php
                                                while ($filas1 = mysqli_fetch_array($query)) {
                                                ?>
                                                    <option value="<?php echo $filas1['idarea'] ?>"><?php echo  $filas1['area'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Equipo:</label>
                                            <input style="text-align:center" class="form-control " id="nequipo" name="nequipo" type="text">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="registrarequipo" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="areas" class="table table-striped  table-responsive-lg  ">
                    <thead>
                        <tr>

                            <th> Área </th>
                            <th> Equipo </th>
                            <th> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $consultaequipos = "select a.*,b.area from equipos a inner join areas b on a.idarea=b.idarea";
                        $queryequipos = mysqli_query($link, $consultaequipos) or die($consultaequipos);
                        while ($filasequipos = mysqli_fetch_array($queryequipos)) {
                        ?>
                            <tr>
                                <td> <?php echo $filasequipos['area'] ?> </td>
                                <td> <?php echo $filasequipos['equipo'] ?> </td>
                                <td> <button onclick="datosequipo('<?php echo $filasequipos['idequipo'] ?>')" type="button" title="Eliminar clasificación de documento" id="delete" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
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
                                <h5 class="modal-title" id="exampleModalLabel">Eliminar equipo de trabjo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input id="iduequipo" type="hidden">
                                <h6>Esta seguro que desea eliminar este equipo de trabajo?</h6>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="eliminarequipo" class="btn btn-danger">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tabla-procesos
            ">
                <div class="titulo-tabla">
                    <h2>Áreas de trabajo</h2>
                </div>
                <section class="parametros">
                    <span class="btn btn-primary boton-parametro" data-toggle="modal" data-target="#nuevacuenta">
                        <b> Registrar área</b>
                    </span>
                </section>
                <div class="modal fade" id="nuevacuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Registrar nueva área de trabajo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-row formulario">
                                        <div class="form-group grande">
                                            <label for="hasta">Área:</label>
                                            <input style="text-align:center" class="form-control " id="narea" name="narea" type="text">
                                        </div>
                                    </div>
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Cod.Área:</label>
                                            <input style="text-align:center" class="form-control " id="ncodarea" name="ncodarea" type="text">
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Compañia:</label>
                                            <input style="text-align:center" class="form-control " id="ncompania" name="ncompania" type="text">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="registrararea" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="equipos" class="table table-striped  table-responsive-lg usuarios ">
                    <thead>
                        <tr>

                            <th> Área </th>
                            <th> Cod.Área </th>
                            <th> Compañia </th>
                            <th> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $consultatipos = "select * from areas";
                        $query = mysqli_query($link, $consultatipos) or die($consultatipos);
                        while ($filas = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td> <?php echo $filas['area'] ?> </td>
                                <td> <?php echo $filas['codarea'] ?> </td>
                                <td> <?php echo $filas['codclasificacion'] ?> </td>
                                <td>
                                    <button onclick="datosarea('<?php echo $filas['idarea'] ?>')" type="button" title="Eliminar clasificación de documento" id="delete" class="btn btn-danger" data-toggle="modal" data-target="#eliminararea">
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
                <div class="modal fade" id="eliminararea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Eliminar clasificacion de documento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="iduarea" id="iduarea">
                                <h6>Esta seguro que desea eliminar esta área de trabajo?</h6>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="celiminararea" class="btn btn-danger">Eliminar</button>
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
        tabla = $('#areas').DataTable({
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
        tabla = $('#procesos').DataTable({
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
        tabla = $('#equipos').DataTable({
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
        $('#registrarproceso').click(function() {
            a = 0;
            equipo = $('#equipon').val();
            proceso = $('#proceson').val();
            if (proceso == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de proceso', function() {
                    alertify.success('Ok');
                });
            }
            if (equipo == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor seleccionar un equipo de trabajo para el proceso.', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                registrarproceso(equipo, proceso);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        });
        $('#eliminarproceso').click(function() {

            id = $('#iduproceso').val();
            eliminarproceso(id);
            setTimeout(function() {
                window.location.reload();
            }, 1000);

        });
        $('#registrarequipo').click(function() {
            a = 0;
            equipo = $('#nequipo').val();
            area = $('#areanequipo').val();
            if (equipo == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de equipo', function() {
                    alertify.success('Ok');
                });
            }
            if (area == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor seleccionar un área para el equipo.', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                registrarequipo(equipo, area);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        });
        $('#eliminarequipo').click(function() {
            id = $('#iduequipo').val();
            eliminarequipo(id);

        });
        $('#registrararea').click(function() {
            a = 0;
            area = $('#narea').val();
            codarea = $('#ncodarea').val();
            compania = $('#ncompania').val();
            if (area == '' || area.length < 4) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de área.Debe tener mas de 5 carácteres.', function() {
                    alertify.success('Ok');
                });
            }
            if (codarea == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de área.Debe tener mas de 5 carácteres.', function() {
                    alertify.success('Ok');
                });
            }
            if (compania == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de área.Debe tener mas de 5 carácteres.', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                registrararea(area, codarea, compania);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        });
        $('#celiminararea').click(function() {
            id = $('#iduarea').val();
            eliminararea(id);
        });
    });
</script>