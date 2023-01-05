<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
    <link type="text/css" href="./librerias/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel=" Stylesheet" />
    <link rel="stylesheet" href="./css/facturas/desktop.css">
    <SCRIPT lang="javascript" type="text/javascript" src="notascontables/notascontables.js"></script>
    <SCRIPT src="librerias/alertify/alertify.js"></script>
    <title>Notas Contables</title>
    <?php
    include('./conexion/conexion.php');
    $fecha_actual = date("Y-m-j");
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    $hora = date('h:i a');
    //consulta idnota
    if (isset($_GET['id'])) {
        $idnota = $_GET['id'];
        $consultanotacreada = "select * from notascontables where idnota = '$idnota'";
        $querynotacreada = mysqli_query($link, $consultanotacreada) or die($consultanotacreada);
        $filanotacreada = mysqli_fetch_array($querynotacreada);
        if (isset($filanotacreada)) {
            $creado = 1;
        } else {
            $creado = 0;
        }
    } else {
        $consultaconsecutivo = "select count(idnota) 'consecutivo' from notascontables where fecha = '$fecha_actual'";
        $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
        $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
        if (isset($filaconsecutivo)) {
            $consecutivo = $filaconsecutivo['consecutivo'] + 1;
        } else {
            $consecutivo = 1;
        }
        $idnota = $ano . $mes . $dia . $consecutivo;
        $creado = 0;
    }
    //consulta area
    $consultaarea = "SELECT c.area FROM procesos a inner join equipos b on b.idequipo=a.idequipo INNER join areas c on c.idarea=b.idarea where idproceso = $_SESSION[idproceso]";
    $queryarea = mysqli_query($link, $consultaarea) or die($consultaarea);
    $filaarea = mysqli_fetch_array($queryarea);
    $area  = $filaarea['area'];
    //consulta datos notas
    $consultadatosnota = "SELECT a.*,b.nombre,c.documento,d.clasificacion,e.nombre 'aprobador',a.fechaaprobacion,a.horaaprobacion,f.nombre 'autoriza' FROM notascontables a left join usuarios f on f.idusuario = a.idautoriza
    INNER JOIN usuarios b on a.idusuario = b.idusuario INNER JOIN tiposdocumento c on c.idtipo=a.idtipodocumento left JOIN clasificaciones d on d.idclasificacion=a.idclasificacion
     left join usuarios e on e.idusuario=a.idaprobador where a.idnota = $idnota";
    $querydatosnota = mysqli_query($link, $consultadatosnota) or die($consultadatosnota);
    $filadatosnota = mysqli_fetch_array($querydatosnota);
    if (isset($filadatosnota)) {
        $usuario = $filadatosnota['nombre'];
        $idusuario = $filadatosnota['idusuario'];
        $tipodocumento = $filadatosnota['idtipodocumento'];
        $clasificacion = $filadatosnota['idclasificacion'];
        $comentario = $filadatosnota['comentario'];
        $batch = $filadatosnota['batch'];
        if ($batch == 0) {
            $batch = '';
        }

        $fecha = $filadatosnota['fecha'];
        $hora = $filadatosnota['hora'];
        $proceso = $filadatosnota['tipo'];
        if ($filadatosnota['aprobador'] != '') {
            $nombreaprobador = $filadatosnota['aprobador'] . ':';
        } else {
            $nombreaprobador = $filadatosnota['aprobador'];
        }
        if ($filadatosnota['autoriza'] != '') {
            $nombreautorizador = $filadatosnota['autoriza'] . ':';
        } else {
            $nombreautorizador = $filadatosnota['autoriza'];
        }

        $fechaaprobacion = $filadatosnota['fechaaprobacion'];
        $horaaprobacion = $filadatosnota['horaaprobacion'];
        $fechaautorizacion = $filadatosnota['fechaautorizacion'];
        $horaautorizacion = $filadatosnota['horaautorizacion'];
        $revision = $filadatosnota['revision'];
        $creado = 1;
        $importe =  number_format($filadatosnota['importe']);
    } else {
        $idusuario = $_SESSION['idusuario'];
        $usuario = $_SESSION['nombre'];
        $tipodocumento = '';
        $clasificacion = '';
        $comentario = '';
        $batch = '';
        $proceso = '';
        $hora = '';
        $fecha = '';
        $nombreaprobador = '';
        $fechaaprobacion = '';
        $horaaprobacion = '';
        $nombreautorizador = '';
        $fechaautorizacion = '';
        $horaautorizacion = '';
        $revision = 0;
        $creado = 0;
        $importe = 0;
    }
    ?>
</head>

<body>
    <header>
        <?php
        $des = '';
        if ($creado == 1) {
            if ((($_SESSION['idusuario'] == $idusuario && $filadatosnota['revision'] == 0) || ($filadatosnota['tipo'] == $_SESSION['idproceso'] && $filadatosnota['revision'] == 0 && $_SESSION['idusuario'] == $idusuario))) {
                $des = '';
            } else {
                $des = 'disabled';
            }
        } else {
            if ($_SESSION['creacion'] == 1) {
                $des = '';
            } else {
                $des = 'disabled';
            }
        }
        ?>
        <?php
        if ($batch != '') {
            $estado = 'disabled';
        } else {
            $estado = '';
        }
        ?>
        <div class="form-row formulario">
            <div class="form-group pequeno">
                <label for="iddocumento">ID.Documento:</label>
                <input value="<?php echo $creado  ?>" style="text-align:center" class="form-control " id="creado" name="creado" type="hidden" disabled>
                <input <?php echo $estado ?> value="<?php echo $idnota  ?>" style="text-align:center" class="form-control " id="iddoc" name="iddoc" type="text" disabled>
            </div>
            <div class="form-group mediano-pequeno">
                <label for="user">Fecha creación</label>
                <input <?php echo $des; ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $fecha . ' ' . $hora; ?>">
            </div>
            <div class="form-group pequeno">
                <label for="batch">Batch</label>
                <?php
                $estado = 'disabled';
                if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                } ?>
                <input <?php echo $estado ?> min="0" value="<?php echo $batch ?>" style="text-align:center;background-color:<?php echo $colorbatch ?>" class="form-control " id="batch" name="batch" type="text">
                <?php if ($batch != '') {
                    $estado = 'disabled';
                } else {
                    $estado = '';
                }
                ?>
            </div>

        </div>
        <div class="form-row formulario tabla-registros">
            <h5 class="subtitulo-formulario">Información del empleado</h5>
            <div class="form-group mediano-pequeno">
                <label for="user">Nombre</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $usuario; ?>">
            </div>
            <div class="form-group mediano-grande">
                <label for="user">Correo</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $_SESSION['correo']; ?>">
            </div>
            <div class="form-group mediano">
                <label for="user"> Nombre dependencia</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo  $area; ?>">
            </div>
        </div>
        <div class="form-row formulario tabla-registros">
            <h5 class="subtitulo-formulario">Información del registro contable</h5>
            <div class="form-group mediano-pequeno">
                <label for="desde">Proceso*</label>
                <select style="text-align: center;" id="proceso" name="proceso" class="form-control col-md-8 ">
                    <?php
                    $consultaequipos = "select a.*,b.equipo,c.area from procesos a inner join equipos b on b.idequipo=a.idequipo inner join areas c on c.idarea = b.idarea where idproceso=1 or idproceso=4";
                    $query = mysqli_query($link, $consultaequipos) or die($consultaequipos);
                    ?> <option value="0">Seleccionar</option>
                    <?php
                    $estado = '';
                    while ($filas1 = mysqli_fetch_array($query)) {

                        if ($proceso == $filas1['idproceso']) {
                            $estado = 'selected';
                        }
                    ?>
                        <option <?php echo $estado ?> value="<?php echo $filas1['idproceso'] ?>"><?php echo  $filas1['proceso'] ?></option>
                    <?php
                        if ($proceso == $filas1['idproceso']) {
                            $estado = '';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mediano-pequeno">
                <label for="type">Tipo de nota*</label>
                <select <?php echo $estado ?> style="text-align: center;" id="tiponota" class="form-control col-md-8 ">
                    <?php
                    $selected = '';
                    $consultausuarios = "select * from tiposdocumento order by documento";
                    $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                    ?> <option value="0">Seleccionar</option>
                    <?php
                    while ($filas1 = mysqli_fetch_array($query)) {
                        if ($filas1['idtipo'] == $filadatosnota['idtipodocumento']) {
                            $selected = 'selected';
                        }
                    ?>
                        <option <?php echo $selected ?> value="<?php echo $filas1['idtipo'] ?>"><?php echo  $filas1['idtipo'] . '-' . $filas1['documento'] ?></option>
                    <?php
                        $selected = '';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mediano-pequeno">
                <label for="fechafactura">Fecha nota*</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="fechanota" value="<?php echo $fecha ?>" name="fechanota" type="date">
            </div>
            <div class="form-group mediano-pequeno">
                <label for="importe">Importe($)*</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control number " id="importe" value="<?php echo $importe ?>" name="importe" type="text">
            </div>
            <div class="form-group mediano-grande ">
                <label for="comment">Comentario</label>
                <input <?php echo $des; ?> <?php echo $estado ?> value="<?php echo $comentario ?>" style="text-align:center" class="form-control " id="comment" name="comment" type="text">
            </div>
        </div>


    </header>
    <main id="registrosdenota" class=" form-row    tabla-registros ">
        <h5 class="subtitulo-formulario">Evidencias del registro contable</h5>
        <div class="form-row formulario">
            <div class="form-group mediano-grande">
                <input <?php echo $estado ?> style="text-align:center" accept="image/gif,image/jpg,img/jpeg,image/png,.pdf" class="form-control " id="soporte" name="soporte" type="file">
            </div>
            <button title="Enviar nota contable a revisión." id="subirsoporte" name="subirsoporte" class="btn btn-primary boton">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                </svg>
            </button>
        </div>
        <table class="table table-striped  table-responsive-lg ">
            <thead>
                <tr>
                    <th> Archivo </th>
                    <th> Acciones </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $consultacuentas = "select * from cuentas where idproceso = 4";
                $querycuentas = mysqli_query($link, $consultacuentas) or die($consultacuentas);
                $dir = 'notascontables/' . $idnota;
                //$directorio = opendir($dir);
                if (is_dir($dir)) {
                    $soportes = scandir($dir);
                    for ($i = 2; $i < sizeof($soportes); $i++) {
                ?>
                        <tr>
                            <td><a target="blank" href="<?php echo './' . $dir . '/' . $soportes[$i] ?>"><?php echo $soportes[$i] ?> </a> </td>
                            <td>
                                <SCRIPT lang="javascript" type="text/javascript" src="./cuentas/cuentas.js"></script>
                                <button type="button" title="Eliminar archivo" onclick="eliminarsoporte('<?php echo $soportes[$i] ?>','<?php echo $idnota ?>')" id="borrararchivo" class="btn btn-danger">
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
    </main>
    <footer>
        <div class="form-row formulario tabla-registros">
            <h5 class="subtitulo-formulario">Información del empleado</h5>
            <div class="form-group mediano-grande ">
                <label for="comment">Aprobado por</label>
                <input <?php echo $des; ?> value=" <?php echo $nombreaprobador  . $fechaaprobacion . ' ' . $horaaprobacion; ?>" style="text-align:center" class="form-control " id="user" name="user" type="text" disabled>
            </div>
            <div class="form-group mediano-grande ">
                <label for="comment">Autorizado por</label>
                <input <?php echo $des; ?> value=" <?php echo $nombreautorizador  . $fechaautorizacion . ' ' . $horaautorizacion; ?>" style="text-align:center" class="form-control " id="user" name="user" type="text" disabled>
            </div>
            <input <?php echo $estado ?> style="text-align:center" class="form-control " id="valido" name="valido" type="hidden">
            <hr>
            <div class="form-row formulario">
                <button title="Enviar nota contable a revisión." id="save" name="save" class="btn btn-primary boton"> Guardar </button>
                <?php
                if ($creado == 1) {
                ?>
                    <button title="Enviar nota contable a revisión." id="revision" name="revision" class="btn btn-warning boton">Enviar a Revisión </button>
                <?php
                }
                ?>
            </div>
        </div>
    </footer>
</body>

</html>
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
        $('#subirsoporte').click(function() {
            a = 0;
            iddoc = $('#iddoc').val();
            soporte = $('#soporte').val();
            if (soporte == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Debe subir soporte de la factura.', function() {
                    alertify.success('Ok');
                });
            } else {
                filesize = $('#soporte')[0].files[0].size;
                if (filesize > 55000000000000) {
                    a = 1;
                    alertify.alert('ATENCION!!', 'El soporte es demasiado pesado. ', function() {
                        alertify.success('Ok');
                    });
                }
            }
            if (a == 0) {
                soporte = $('#soporte').prop('files')[0];
                datosForm = new FormData;
                datosForm.append("soporte", soporte);
                ruta = 'notascontables/subirsoportes.php?iddoc=' + iddoc;
                $.ajax({
                    type: "POST",
                    url: ruta,
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: datosForm,
                    success: function(r) {
                        if (r == 1) {
                            // console.log(r);
                            // debugger;
                        } else {
                            // console.log(r);
                            // debugger;
                        }
                    }
                });
                setTimeout(function() {
                    window.location.href = "./home.php?id=" + iddoc + "&n=5"
                }, 1500);
                alertify.success('Operación exitosa. ');
            }
        });
        $('#save').click(function() {
            a = 0;
            iddocumento = $('#iddoc').val();
            tiponota = $('#tiponota').val();
            comentario = $('#comment').val();
            proceso = $('#proceso').val();
            fechanota = $('#fechanota').val();
            importe = $('#importe').val();
            if (tiponota == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor seleccionar un tipo de documento', function() {
                    alertify.success('Ok');
                });
            }
            if (fechanota == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor seleccionar fecha de nota contable.', function() {
                    alertify.success('Ok');
                });
            }
            if (proceso == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor seleccionar el proceso al cual se enviara la nota.', function() {
                    alertify.success('Ok');
                });
            }
            if (importe == '0' || importe == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'El valor del importe debe ser mayor a 0(cero).', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                guardarnotacontableadjunto(iddocumento, tiponota, proceso, fechanota, importe);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);

            }

            // alertify.confirm('Envio a revisión', 'Esta seguro de enviar esta nota contable para revisión?', function() {
            //     revision(iddocumento);
            //     setTimeout(function() {
            //         window.location.reload();
            //     }, 1000);
            //     alertify.success('Operación exitosa. ');
            // }, function() {

            // }).set('labels', {
            //     ok: 'Continuar',
            //     cancel: 'Cancelar'
            // });
        });
        $('#cuenta').change(function() {
            cuenta = $('#cuenta').val();
            verificarbanco(cuenta);
        });
        const number = document.querySelector('.number');

        function formatNumber(n) {
            n = String(n).replace(/\D/g, "");
            return n === '' ? n : Number(n).toLocaleString();
        }
        number.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
            element.value = formatNumber(value);

        });
        $('#revision').click(function() {
            a = 0;
            iddocumento = $('#iddoc').val();
            alertify.confirm('Envio a revisión', 'Esta seguro de enviar esta nota contable para revisión?', function() {
                revision(iddocumento);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
                alertify.success('Operación exitosa. ');
            }, function() {

            }).set('labels', {
                ok: 'Continuar',
                cancel: 'Cancelar'
            });
        });
        $('#an').change(function() {
            an = $('#an').val();
            verificaran(an);
        });
        $('#aprobar').click(function() {
            a = 0;
            iddocumento = $('#iddocumento').val();
            totalhaber = $('#totalhaber').val();
            alertify.confirm('Aprobación de nota contable', 'Esta seguro que desea aprobar esta nota contable con valor de $' + totalhaber, function() {
                aprobarnota(iddocumento);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
                alertify.success('Operación exitosa. ');
            }, function() {

            }).set('labels', {
                ok: 'Continuar',
                cancel: 'Cancelar'
            });
        });
        $('#confirmardesaprobar').click(function() {
            a = 0;
            iddocumento = $('#iddocumento').val();
            comentariodesaprobacion = $('#comentariodesaprobacion').val();
            noaprobarnota(iddocumento, comentariodesaprobacion);
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        });

    });
</script>