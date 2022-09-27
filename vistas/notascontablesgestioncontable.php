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
    <link rel="stylesheet" href="./css/notas/desktop.css">
    <SCRIPT lang="javascript" type="text/javascript" src="notascontables/notascontables.js"></script>
    <SCRIPT src="librerias/alertify/alertify.js"></script>
    <title>Notas Contables</title>
    <?php
    include('../NotasdePago/conexion/conexion.php');
    $fecha_actual = date("Y-m-j");
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    //autocompletar cliente
    $consulta = "SELECT distinct(concepto)  FROM `cuentas` where concepto != '' ";
    $queryt = mysqli_query($link, $consulta) or die($consulta);
    $productos[] = array();
    while ($arregloproductos = mysqli_fetch_row($queryt)) {
        $productos[] = $arregloproductos[0];
    }
    array_shift($productos);
    $relleno = json_encode($productos);
    //consulta idnota
    if (isset($_GET['id'])) {
        $idnota = $_GET['id'];
        $creado = 1;
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

    //consulta datos notas
    $consultadatosnota = "SELECT a.*,b.nombre,c.documento,d.clasificacion FROM notascontables a INNER JOIN usuarios b on a.idusuario = b.idusuario 
    INNER JOIN tiposdocumento c on c.idtipo=a.idtipodocumento INNER JOIN clasificaciones d on d.idclasificacion=a.idclasificacion where a.idnota = $idnota";
    $querydatosnota = mysqli_query($link, $consultadatosnota) or die($consultadatosnota);
    $filadatosnota = mysqli_fetch_array($querydatosnota);
    if (isset($filadatosnota)) {
        $usuario = $filadatosnota['nombre'];
        $tipodocumento = $filadatosnota['idtipodocumento'];
        $clasificacion = $filadatosnota['idclasificacion'];
        $comentario = $filadatosnota['comentario'];
        $batch = $filadatosnota['batch'];
        $fecha = $filadatosnota['fecha'];
        $hora = $filadatosnota['hora'];
    } else {
        $usuario = $_SESSION['nombre'];
        $tipodocumento = '';
        $clasificacion = '';
        $comentario = '';
        $batch = '';
        $hora = '';
        $fecha = '';
    }
    ?>
</head>

<body>
    <header>
        <form action="" method="post">
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
                    <input <?php echo $estado ?> value="<?php echo $idnota  ?>" style="text-align:center" class="form-control " id="iddocumento" name="iddocumento" type="text" disabled>
                </div>
                <div class="form-group mediano-pequeno">
                    <label for="user">Usuario:</label>
                    <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $usuario; ?>">
                </div>

                <div class="form-group mediano">
                    <label for="type">Tipo de Documento</label>
                    <select <?php echo $estado ?> style="text-align: center;" id="type" class="form-control col-md-8 ">
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
                <div class="form-group mediano">
                    <label for="type">Clasificación de Documento</label>
                    <select <?php echo $estado ?> style="text-align: center;" id="clasificacion" class="form-control col-md-8 ">
                        <?php
                        $consultausuarios = "select * from clasificaciones order by clasificacion";
                        $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                        ?> <option value="0">Seleccionar</option>
                        <?php
                        while ($filas1 = mysqli_fetch_array($query)) {
                            if ($filas1['idclasificacion'] == $filadatosnota['idclasificacion']) {
                                $selected = 'selected';
                            }
                        ?>
                            <option <?php echo $selected ?> value="<?php echo $filas1['idclasificacion'] ?>"><?php echo  $filas1['clasificacion'] ?></option>
                        <?php
                        }
                        $selected = '';
                        ?>
                    </select>
                </div>

            </div>
            <div class="form-row formulario">
                <div class="form-group pequeno">
                    <label for="batch">Batch:</label>
                    <?php
                    $estado = 'disabled';
                    if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                    } ?>
                    <input <?php echo $estado ?> min="0" value="<?php echo $batch ?>" style="text-align:center" class="form-control " id="batch" name="batch" type="number">
                    <?php if ($batch != '') {
                        $estado = 'disabled';
                    } else {
                        $estado = '';
                    }
                    ?>
                </div>
                <div class="form-group mediano-pequeno">
                    <label for="user">Fecha creación:</label>
                    <input style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $fecha . ' ' . $hora; ?>">
                </div>
                <div class="form-group mediano">
                    <label for="user">Aprobado por:</label>
                    <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled>
                </div>
                <div class="form-group mediano ">
                    <label for="comment">Comentario:</label>
                    <input <?php echo $estado ?> value="<?php echo $comentario ?>" style="text-align:center" class="form-control " id="comment" name="comment" type="text">
                </div>
            </div>
        </form>
    </header>
    <main id="tegistrosdenota" class="tabla-registros ">
        <table id="registrosnotas" class="table table-striped  table-responsive-lg">
            <thead>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Importe</th>
                <th>L.M Auxiliar</th>
                <th>T.M</th>
                <th>AN8</th>
                <?php
                if ($batch == '') {
                ?>
                    <th>Acciones</th>
                <?php
                }
                ?>

            </thead>
            <tbody>
                <?php
                $consultaregistros = "SELECT  a.idcuenta,a.idregistro, a.fecha,b.concepto,a.haber,a.tipolm,a.lm,a.an FROM `registrosdenota` a left JOIN cuentas b on b.idcuenta=a.idcuenta WHERE a.idnota='$idnota'  and  (a.idcuenta = 0 or a.haber > 0);";
                $queryregistros = mysqli_query($link, $consultaregistros) or die($consultaregistros);
                $totaldebe = 0;
                $totalhaber = 0;
                $totalimporte = 0;
                while ($filasregistros = mysqli_fetch_array($queryregistros)) {
                    $a = 0;
                ?>
                    <tr>
                        <TD><?php echo $filasregistros['fecha']; ?> </TD>
                        <?php
                        if ($filasregistros['concepto'] == '') {
                            $concepto = $filasregistros['idcuenta'];
                            $color = "#F57272";
                            $a++;
                        } else {
                            $concepto = $filasregistros['concepto'];
                            $color = '';
                        }
                        ?>
                        <TD style="background-color: <?php echo $color; ?> ;"><?php echo $concepto; ?> </TD>
                        <TD><?php echo number_format($filasregistros['haber']); ?> </TD>
                        <TD><?php echo $filasregistros['tipolm']; ?> </TD>
                        <TD><?php echo $filasregistros['lm']; ?> </TD>
                        <?php
                        $consultaan = "select * from listaan where idan = $filasregistros[an]";
                        $queryan = mysqli_query($link, $consultaan) or die($consultaan);
                        $numan = mysqli_num_rows($queryan);
                        if ($numan == 0) {

                            $color = "#F57272";
                            $a++;
                        } else {
                            $color = '';
                        }
                        if ($a == 0) {
                            $totalimporte = $totalimporte + $filasregistros['haber'];
                        }
                        ?>
                        <td style="background-color: <?php echo $color; ?> ;"><?php echo $filasregistros['an']; ?> </td>
                        <?php
                        if ($batch == '') {
                        ?>
                            <td>
                                <button title="Eliminar Registro" style="height:1.5rem;padding-top:0 " onclick="elminarregistro(<?php echo $filasregistros['idregistro'] ?>)" id="eliminarregistro" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                    </svg>
                                </button>
                            </td>
                        <?php
                        }
                        ?>

                    </tr>
                <?php }
                if ($batch == '') {

                ?>
                    <form id="registros" action="#" method="POST" class="form-registros">
                        <tr>
                            <td style="width: 13%;padding:5">
                                <input class="form-control" type="hidden" required id="idnota" name="idnota" value="0">
                                <input style="text-align:center;padding:5" class="  form-control-register" type="text" required id="date" name="date">
                            </td>
                            <td>
                                <input style="text-align:center;padding:5" class="  form-control-register" type="text" required id="concepto" name="concepto">
                            </td>
                            <td style="width:10%">
                                <input style="text-align:center;padding:5" class="  form-control-register" type="text" required id="importe" name="importe">
                            </td>
                            <td>
                                <input style="text-align:center;padding:5" class="  form-control-register" type="text" required id="lmauxiliar" name="lmauxiliar" disabled>
                            </td>
                            <td style="width:10%">
                                <input style="text-align:center;padding:5" class="  form-control-register" type="text" required id="tm" name="tm">
                            </td>
                            <td style="width:10%">
                                <input style="text-align:center;padding:5" class="  form-control-register" type="text" required id="an" name="an" required>
                            </td>
                            <td style="width: 8%">
                                <button title="Registrar" style="height:25px;padding:0;width:40px" onclick="" type="button" id="registrar" class="btn btn-primary" data-toggle="modal" data-target="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
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
                <?php } ?>
            </tbody>
        </table>
        <input type="hidden" id="idu" name="idu">
        <div class="form-row formulario">
            <div class="form-group mediano ">
                <label for="comment">Total Importe:</label>
                <?php
                ?>
                <input style="text-align:center;background-color:<?php echo "white" ?>" class="form-control " id="totalimporte" name="totalimporte" type="text" value="<?php echo number_format($totalimporte) ?>" disabled>
            </div>
        </div>
        <section class="botones">
            <?php
            if ($batch == '') {
                $estado = "";
            ?>
                <button <?php echo $estado ?> title="Guardar Nota" id="save" name="save" class="btn btn-primary boton">Guardar</button>
                <!-- // <button title="Cancelar Nota" id="cancel" name="cancel" class="btn btn-secondary boton">Cancelar</button> -->
                <button title="Borrar Nota" id="delete" name="delete" class="btn btn-secondary boton">Limpiar</button>
                <?php
            } else {
                if ($_SESSION['rol'] == 1) {
                ?>
                    <button id="edit" name="edit" class="btn btn-primary boton">Editar</button>
            <?php
                }
            }
            ?>
        </section>
    </main>
    <footer>

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
        $('#debe').change(function() {
            debe = $('#debe').val();
            haber = $('#haber').val();
            importe = debe - haber;
            $('#importe').val(importe);
        });
        $('#haber').change(function() {
            debe = $('#debe').val();
            haber = $('#haber').val();
            importe = debe - haber;
            $('#importe').val(importe);
        });
        $('#tm').change(function() {
            tm = $('#tm').val();
            if (tm.length > 0) {
                $('#lmauxiliar').val("A");
            } else {
                $('#lmauxiliar').val("");
            }
        });
        $('#cuenta').change(function() {
            // $.ajax({
            //     type: "POST",
            //     url: "notascontables/obtenerdescripcion.php",
            //     data: "cuenta=" + $('#cuenta').val(),
            //     success: function(r) {
            //         dato = jQuery.parseJSON(r);
            //         console.log(r)
            //         $('#descripcion').val(dato['descripcion']);

            //     }
            // });

        });
        $('#registrar').click(function() {
            iddoc = $('#iddocumento').val();
            type = $('#type').val();
            batch = $('#batch').val();
            clasificacion = $('#clasificacion').val();
            comentario = $('#comment').val();
            totaldebe = 0;
            totalhaber = 0;
            //grupo
            concepto = $('#concepto').val();
            const conceptos = concepto.split(' ');
            fecha = $('#date').val();
            const fechas = fecha.split(' ');
            importe = $('#importe').val();
            const importes = importe.split(' ');
            tm = $('#tm').val();
            const tms = tm.split(' ');
            an = $('#an').val();
            const ans = an.split(' ');

            if (conceptos.length > 1) {
                ///grupo
                for (var i = 0; i < conceptos.length; i++) {
                    conceptos[i] = conceptos[i].replace(/-/g, " ");
                    // console.log('debes' + debes);
                    // console.log('habers' + habers);
                }
                console.log(conceptos);
                console.log(importes);
                console.log(ans);
                //debugger;
                registrargrupogestioncontable(iddoc, conceptos, fechas, importes, ans, tms);
                setTimeout(function() {
                    window.location.reload();
                }, 1000 + (conceptos.length * 10));
            } else {
                //individual
                a = 0;
                concepto = $('#concepto').val();
                fecha = $('#date').val();
                importe = $('#importe').val();
                tm = $('#tm').val();
                an = $('#an').val();
                lmauxiliar = $('#lmauxiliar').val();
                if (an == '') {
                    a = 1;
                    alertify.alert('ATENCION!!', 'Debe ingresar valor de AN8.', function() {
                        alertify.success('Ok');
                    });
                }
                if (importe == 0) {
                    a = 1;
                    alertify.alert('ATENCION!!', 'El importe debe ser mayor a 0.', function() {
                        alertify.success('Ok');
                    });
                }
                if (concepto == '') {
                    a = 1;
                    alertify.alert('ATENCION!!', 'El campo concepto es obligatorio.', function() {
                        alertify.success('Ok');
                    });
                }
                if (fecha == '') {
                    a = 1;
                    alertify.alert('ATENCION!!', 'El campo fecha se encuentra vacío', function() {
                        alertify.success('Ok');
                    });
                }
                if (a == 0) {
                    b = 0
                    creado = $('#creado').val();
                    if (creado == 0) {
                        if (type == 0) {
                            b = 1;
                            alertify.alert('ATENCION!!', 'Favor seleccionar un tipo de documento', function() {
                                alertify.success('Ok');
                            });
                        }
                        if (clasificacion == 0) {
                            b = 1;
                            alertify.alert('ATENCION!!', 'Favor seleccionar una clasificación para el documento', function() {
                                alertify.success('Ok');
                            });
                        }
                        if (b == 0) {
                            registrarnota(type, clasificacion, comentario, '', 4);
                            registrogestioncontable(iddoc, concepto, fecha, importe, tm, an, lmauxiliar);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    } else {
                        registrogestioncontable(iddoc, concepto, fecha, importe, tm, an, lmauxiliar);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }

                }
            }
        });
        $('#save').click(function() {
            type = $('#type').val();
            clasificacion = $('#clasificacion').val();
            comentario = $('#comment').val();
            creado = $('#creado').val();


            if (creado == 1) {
                iddocumento = $('#iddocumento').val();
                totaldebe = $('#totaldebe').val();
                totalhaber = $('#totalhaber').val();
                usuario = $('#user').val();
                batch = '';
                a = 0;
                if (a == 0) {
                    editarnota(iddocumento, usuario, type, clasificacion, comentario, batch);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            } else {
                totaldebe = $('#totaldebe').val();
                totalhaber = $('#totalhaber').val();
                totalimporte = parseInt(totaldebe) - parseInt(totalhaber);
                //grupo
                cuenta = $('#cuenta').val();
                const cuentas = cuenta.split(' ');
                date = $('#date').val();
                const dates = date.split(' ');
                debe = $('#debe').val();
                const debes = debe.split(' ');
                haber = $('#haber').val();
                const habers = haber.split(' ');
                if (cuentas.length >= 1) {
                    for (var i = 0; i < cuentas.length; i++) {
                        cuenta = cuentas[i];
                        if (debes[i] == '-' || debes[i] == '- ' || debes[i] == ' -' || debes[i] == undefined) {
                            debes[i] = '0';
                        }
                        if (habers[i] == '-' || habers[i] == '- ' || habers[i] == ' -' || habers[i] == undefined) {
                            habers[i] = '0';
                        }

                    }
                    a = 0;
                    if (type == 0) {
                        a = 1;
                        alertify.alert('ATENCION!!', 'Favor seleccionar un tipo de documento', function() {
                            alertify.success('Ok');
                        });
                    }
                    if (clasificacion == 0) {
                        a = 1;
                        alertify.alert('ATENCION!!', 'Favor seleccionar una clasificación para el documento', function() {
                            alertify.success('Ok');
                        });
                    }
                    if (totalimporte != 0) {
                        a = 1;
                        alertify.alert('ATENCION!!', 'Favor verificar valores en los registros.El valor total del importe debe ser 0.', function() {
                            alertify.success('Ok');
                        });
                    }
                    if (a == 0) {
                        registrarnota(type, clasificacion, comentario, '');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }

                } else {
                    alertify.alert('ATENCION!!', 'Debe ingresar al menos 1 registro de nota', function() {
                        alertify.success('Ok');
                    });
                }
            }
        });
        $('#delete').click(function() {
            a = 0;
            iddocumento = $('#iddocumento').val();
            alertify.confirm('Confirmación', 'Esta seguro que desea limpiar los registros de esta nota?', function() {
                limpiarnota(iddocumento)
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
        $('#eliminarregistro').click(function() {
            idu = $('#idu').val();
            elminarregistro(idu);
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        });
        disponible = (<?php echo $relleno ?>);
        $("#concepto").autocomplete({
            source: disponible,
            lookup: disponible,
            minLength: 4
        });
        $("#cuenta").autocomplete("option", "appendTo", ".eventInsForm");
    });
</script>