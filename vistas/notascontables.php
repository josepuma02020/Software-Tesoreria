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
    $consulta = "SELECT `idcuenta`  FROM `cuentas` ";
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
                <div class="form-group mediano-grande">
                    <label for="type">Tipo de Documento</label>
                    <select <?php echo $estado ?> style="text-align: center;" id="type" class="form-control col-md-8 ">
                        <?php
                        $selected = '';
                        $consultausuarios = "select * from tiposdocumento order by documento";
                        $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                        ?> <option value="0"></option>
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
                <div class="form-group mediano-grande">
                    <label for="type">Clasificación de Documento</label>
                    <select <?php echo $estado ?> style="text-align: center;" id="clasificacion" class="form-control col-md-8 ">
                        <?php
                        $consultausuarios = "select * from clasificaciones order by clasificacion";
                        $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                        ?> <option value="0"></option>
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
                        $estado = '';
                    } ?>
                    <input <?php echo $estado ?> value="<?php echo $batch ?>" style="text-align:center" class="form-control " id="batch" name="batch" type="number">
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
                <div class="form-group grande ">
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
                <th>Cuenta</th>
                <th>Descripción</th>
                <th>Debe</th>
                <th>Haber</th>
                <th>Importe</th>
                <th>T.LM</th>
                <th>LM</th>
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
                $consultaregistros = "SELECT a.*,b.descripcion FROM `registrosdenota` a INNER JOIN cuentas b on b.idcuenta=a.idcuenta WHERE a.idnota='$idnota'";
                $queryregistros = mysqli_query($link, $consultaregistros) or die($consultaregistros);
                $totaldebe = 0;
                $totalhaber = 0;
                while ($filasregistros = mysqli_fetch_array($queryregistros)) {
                    $totaldebe = $totaldebe + $filasregistros['debe'];
                    $totalhaber = $totalhaber + $filasregistros['haber'];
                ?>
                    <tr>
                        <TD><?php echo $filasregistros['fecha']; ?> </TD>
                        <TD><?php echo $filasregistros['idcuenta']; ?> </TD>
                        <TD><?php echo $filasregistros['descripcion']; ?> </TD>
                        <TD><?php echo number_format($filasregistros['debe']); ?> </TD>
                        <TD><?php echo number_format($filasregistros['haber']); ?> </TD>
                        <TD><?php echo number_format($filasregistros['debe'] -  $filasregistros['haber']); ?> </TD>
                        <TD><?php echo $filasregistros['tipolm']; ?> </TD>
                        <TD><?php echo $filasregistros['lm']; ?> </TD>
                        <td><?php echo $filasregistros['an']; ?> </td>
                        <?php
                        if ($batch == '') {
                        ?>
                            <td>
                                <button style="height:1.5rem;padding-top:0 " onclick="agregaridregistro(<?php echo $filasregistros['idregistro'] ?>)" id="eliminarregistro" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
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
                                <input class="  form-control-register" type="text" required id="date" name="date">
                            </td>
                            <td style="width: 13%;padding:5">
                                <input class="  form-control-register" type="text" required id="cuenta" name="cuenta">
                            </td>
                            <td style="width: 15% ;padding:5">
                                <input class="  form-control-register" type="text" required id="descripcion" name="descripcion" disabled>
                            </td>
                            <td style="width:8%">
                                <input style="text-align:center;padding:5" min="0" class="  form-control-register" type="text" required id="debe" name="debe">
                            </td>
                            <td style="width:8%">
                                <input style="text-align:center;padding:5" min="0" class="  form-control-register" type="text" required id="haber" name="haber">
                            </td>
                            <td style="width:10%">
                                <input style="text-align:center;padding:5" class="  form-control-register" type="number" required id="importe" name="importe" disabled>
                            </td>
                            <td>
                                <input style="text-align:center;padding:5" class="  form-control-register" type="text" required id="tipolm" name="tipolm" disabled>
                            </td>
                            <td style="width:10%">
                                <input style="text-align:center;padding:5" class="  form-control-register" type="text" required id="lm" name="lm" required>
                            </td>
                            <td style="width:10%">
                                <input style="text-align:center;padding:5" class="  form-control-register" type="text" required id="an" name="an" required>
                            </td>
                            <td style="width: 8%">
                                <SCRIPT lang="javascript" type="text/javascript" src="  "></script>
                                <button style="height:25px;padding:0;width:40px" onclick="" type="button" id="registrar" class="btn btn-primary" data-toggle="modal" data-target="">
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
                <label for="comment">Total Debe:</label>
                <input style="text-align:center" class="form-control " id="totaldebe" name="totaldebe" type="text" value="<?php echo number_format($totaldebe) ?>" disabled>
            </div>
            <div class="form-group mediano ">
                <label for="comment">Total Haber:</label>
                <input style="text-align:center" class="form-control " id="totalhaber" name="totalhaber" type="text" value="<?php echo number_format($totalhaber) ?>" disabled>
            </div>
            <div class="form-group mediano ">
                <label for="comment">Total Importe:</label>
                <?php
                $totalimporte = $totaldebe - $totalhaber;
                if ($totalimporte != 0) {
                    $color = '#FC9999';
                } else {
                    $color = '#8FFE6E';
                }

                ?>
                <input style="text-align:center;background-color:<?php echo $color ?>" class="form-control " id="totalimporte" name="totalimporte" type="text" value="<?php echo number_format($totaldebe - $totalhaber) ?>" disabled>
            </div>
        </div>
        <section class="botones">
            <?php
            if ($batch == '') {
            ?>
                <button id="save" name="save" class="btn btn-primary boton">Guardar</button>
                <button id="cancel" name="cancel" class="btn btn-secondary boton">Cancelar</button>
                <button id="delete" name="delete" class="btn btn-danger boton">Eliminar</button>
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
        $('#lm').change(function() {
            lm = $('#lm').val();
            if (lm.length > 0) {
                $('#tipolm').val("A");
            } else {
                $('#tipolm').val("");
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
            cuenta = $('#cuenta').val();
            const cuentas = cuenta.split(' ');
            date = $('#date').val();
            const dates = date.split(' ');
            debe = $('#debe').val();
            const debes = debe.split(' ');
            haber = $('#haber').val();
            const habers = haber.split(' ');
            lm = $('#lm').val();
            const lms = lm.split(' ');
            an = $('#an').val();
            const ans = an.split(' ');
            // console.log(dates);
            // console.log(cuentas);
            // console.log(debes);
            // console.log(habers);
            // console.log(lms);
            // console.log(ans);
            if (cuentas.length > 1) {
                ///grupo
                for (var i = 0; i < cuentas.length; i++) {
                    cuenta = cuentas[i];
                    if (debes[i] == '-' || debes[i] == '- ' || debes[i] == ' -' || debes[i] == undefined) {
                        debes[i] = '0';
                    }
                    if (habers[i] == '-' || habers[i] == '- ' || habers[i] == ' -' || habers[i] == undefined) {
                        habers[i] = '0';
                    }

                    totaldebe = totaldebe + parseFloat(debes[i]);
                    totalhaber = totalhaber + parseFloat(habers[i]);

                    // console.log('debes' + debes);
                    // console.log('habers' + habers);

                }
                totalimporte = totaldebe - totalhaber;

                function separator(numb) {
                    var str = numb.toString().split(".");
                    str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    return str.join(".");
                }
                $('#totaldebe').val((separator(totaldebe)));
                $('#totalhaber').val(separator(totalhaber));
                $('#totalimporte').val(separator(totalimporte));
                registrargrupo(iddoc, cuentas, dates, debes, habers, lms, ans);
                setTimeout(function() {
                    window.location.reload();
                }, 1000 + (cuentas.length * 50));
            } else {
                //individual
                a = 0;
                cuenta = $('#cuenta').val();
                fecha = $('#date').val();
                debe = $('#debe').val();
                haber = $('#haber').val();
                lm = $('#lm').val();
                an = $('#an').val();
                tipolm = $('#tipolm').val();
                if (debe <= 0 && haber <= 0) {
                    a = 1;
                    alertify.alert('ATENCION!!', 'Debe llenar el campo de Debe o Haber(Los dos no pueden registrarse en valor menor o igual a cero). ', function() {
                        alertify.success('Ok');
                    });
                }
                if (cuenta == '') {
                    a = 1;
                    alertify.alert('ATENCION!!', 'El campo de Cuenta se encuentra vacío', function() {
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
                    //registrarnota(type, clasificacion, comentario, batch);
                    registrar(iddoc, cuenta, fecha, debe, haber, lm, an, tipolm);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
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
                batch = $('#batch').val();
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
                    console.log(totalimporte);
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
                        registrarnota(type, clasificacion, comentario, batch);
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
        $('#eliminarregistro').click(function() {
            idu = $('#idu').val();
            elminarregistro(idu);
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        });
        disponible = (<?php echo $relleno ?>);
        $("#cuenta").autocomplete({
            source: disponible,
            lookup: disponible,
            minLength: 4
        });
        $("#cuenta").autocomplete("option", "appendTo", ".eventInsForm");
    });
</script>