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
    include('../Tesoreria/conexion/conexion.php');
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

    //consulta datos notas
    $consultadatosnota = "SELECT a.*,b.nombre,c.documento,d.clasificacion,e.nombre 'aprobador',a.fechaaprobacion,a.horaaprobacion,f.nombre 'autoriza' FROM notascontables a left join usuarios f on f.idusuario = a.idautoriza
    INNER JOIN usuarios b on a.idusuario = b.idusuario INNER JOIN tiposdocumento c on c.idtipo=a.idtipodocumento INNER JOIN clasificaciones d on d.idclasificacion=a.idclasificacion
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
        $fecha = $filadatosnota['fecha'];
        $hora = $filadatosnota['hora'];
        $proceso = $filadatosnota['tipo'];
        $nombreaprobador = $filadatosnota['aprobador'];
        $fechaaprobacion = $filadatosnota['fechaaprobacion'];
        $horaaprobacion = $filadatosnota['horaaprobacion'];
        $nombreautorizador = $filadatosnota['autoriza'];
        $fechaautorizacion = $filadatosnota['fechaautorizacion'];
        $horaautorizacion = $filadatosnota['horaautorizacion'];
        $revision = $filadatosnota['revision'];
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
    }

    if ($batch == '' && $revision == 1) {
        $batch = 'En revisión';
        $colorbatch = '#FED323';
    } else {
        $colorbatch = '';
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
                <input <?php echo $estado ?> value="<?php echo $idnota  ?>" style="text-align:center" class="form-control " id="iddocumento" name="iddocumento" type="text" disabled>
            </div>
            <div class="form-group mediano-pequeno">
                <label for="user">Usuario:</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $usuario; ?>">
            </div>
            <div class="form-group mediano-pequeno">
                <label for="desde">Proceso:</label>
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
            <div class="form-group mediano-pequeno">
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
                <input <?php echo $estado ?> min="0" value="<?php echo $batch ?>" style="text-align:center;background-color:<?php echo $colorbatch ?>" class="form-control " id="batch" name="batch" type="text">
                <?php if ($batch != '') {
                    $estado = 'disabled';
                } else {
                    $estado = '';
                }
                ?>
            </div>
            <div class="form-group mediano-pequeno">
                <label for="user">Fecha creación:</label>
                <input <?php echo $des; ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $fecha . ' ' . $hora; ?>">
            </div>
            <div class="form-group mediano-grande ">
                <label for="comment">Aprobado por:</label>
                <input <?php echo $des; ?> value=" <?php echo $nombreaprobador . ' : ' . $fechaaprobacion . ' ' . $horaaprobacion; ?>" style="text-align:center" class="form-control " id="user" name="user" type="text" disabled>
            </div>
            <div class="form-group mediano-grande ">
                <label for="comment">Autorizado por:</label>
                <input <?php echo $des; ?> value=" <?php echo $nombreautorizador . ' : ' . $fechaautorizacion . ' ' . $horaautorizacion; ?>" style="text-align:center" class="form-control " id="user" name="user" type="text" disabled>
            </div>
            <div class="form-row formulario">
                <div class="form-group completo ">
                    <label for="comment">Comentario:</label>
                    <input <?php echo $des; ?> <?php echo $estado ?> value="<?php echo $comentario ?>" style="text-align:center" class="form-control " id="comment" name="comment" type="text">
                </div>
                <button class="btn btn-info" onclick="openMsg()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                        <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                    </svg>
                </button>

            </div>

        </div>
        <div id="mensajes" class="sidenav mensajes" style="width:0;">
            <div>
                <a class="cerrar" href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            </div>
            <div>
                <?php
                $consultamensajes = "select a.*,b.nombre from mensajes a inner JOIN usuarios b on b.idusuario=a.idusuario where a.idnota= $idnota";
                $querymensajes = mysqli_query($link, $consultamensajes) or die($consultamensajes);
                while ($filasmensajes = mysqli_fetch_array($querymensajes)) {
                ?>
                    <div class="form-group completo">
                        <h6 for="desde"><?php echo $filasmensajes['nombre'] . ' - ' . $filasmensajes['fecha'] . ' ' . $filasmensajes['hora']  ?></h6>
                        <textarea disabled class="form-control" name="comentariodesaprobacion" id="comentariodesaprobacion" rows="4"><?php echo $filasmensajes['mensaje']  ?></textarea>
                    </div>
                <?php
                }
                ?>
                <div class="form-group completo">
                    <h6 style="display:contents" for="desde"><?php echo $_SESSION['nombre'] ?></h6>
                    <button type="button" id="enviarmensaje" class="btn btn-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                        </svg>
                    </button>
                    <textarea class="form-control" name="comentariomensaje" id="comentariomensaje" rows="4"></textarea>
                </div>

            </div>
        </div>
    </header>
    <main id="tegistrosdenota" class="tabla-registros">
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

                if ($batch == '' && $des != 'disabled') {
                    echo $des;
                ?>
                    <th>Acciones</th>
                <?php
                }
                ?>

            </thead>
            <tbody>
                <?php
                $consultaregistros = "SELECT a.*,b.descripcion FROM `registrosdenota` a left JOIN cuentas b on b.idcuenta=a.idcuenta WHERE a.idnota='$idnota'";
                $queryregistros = mysqli_query($link, $consultaregistros) or die($consultaregistros);
                $totaldebe = 0;
                $totalhaber = 0;
                $totalimporte = 0;
                $a = 0;
                while ($filasregistros = mysqli_fetch_array($queryregistros)) {
                    $a = 0;
                    $totaldebe = $totaldebe + $filasregistros['debe'];
                    $totalhaber = $totalhaber + $filasregistros['haber'];
                ?>
                    <tr>
                        <TD><?php echo $filasregistros['fecha']; ?> </TD>
                        <?php
                        if ($filasregistros['descripcion'] == '') {
                            $color = "#F57272";
                            $valido = 1;
                            $a++;
                        } else {
                            $color = '';
                        }
                        ?>
                        <TD style="background-color: <?php echo $color; ?> ;"><?php echo $filasregistros['idcuenta']; ?> </TD>
                        <TD><?php echo $filasregistros['descripcion']; ?> </TD>
                        <TD><?php echo number_format($filasregistros['debe']); ?> </TD>
                        <TD><?php echo number_format($filasregistros['haber']); ?> </TD>
                        <TD><?php echo number_format($filasregistros['debe'] -  $filasregistros['haber']); ?> </TD>
                        <TD><?php echo $filasregistros['tipolm']; ?> </TD>
                        <TD><?php echo $filasregistros['lm']; ?> </TD>
                        <?php
                        $consultaan = "select * from listaan where idan = $filasregistros[an]";
                        $queryan = mysqli_query($link, $consultaan) or die($consultaan);
                        $numan = mysqli_num_rows($queryan);
                        if ($numan == 0) {

                            $color = "#F57272";
                            $a++;
                            $valido = 1;
                        } else {
                            $color = '';
                        }
                        if ($a == 0) {
                            $totalimporte = $totalimporte + $filasregistros['haber'];
                        }
                        ?>
                        <td style="background-color: <?php echo $color; ?> ;"><?php echo $filasregistros['an']; ?> </td>

                        <?php
                        if ($batch == '' && $des != 'disabled') {
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
                if ($batch == '' && $des != 'disabled' && $_SESSION['idusuario'] == $idusuario) {

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
                                <button title="Registrar" style="height:25px;padding:0;width:40px" onclick="" type="button" id="registrar" class="btn btn-primary" data-toggle="modal" data-target="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                                    </svg>
                                </button>
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
                    $color = '#CDFC9A';
                }
                ?>
                <input style="text-align:center;background-color:<?php echo $color ?>" class="form-control " id="totalimporte" name="totalimporte" type="text" value="<?php echo number_format($totaldebe - $totalhaber) ?>" disabled>
            </div>
        </div>
        <section class="botones">
            <?php
            if ($batch == '' || $batch == 'En revisión') {
                $estado = "";
                if ($totalimporte == 0 && $a == 0 && $revision == 0 && $_SESSION['idusuario'] == $idusuario) {
            ?>
                    <button title="Enviar nota contable a revisión." id="revision" name="revision" class="btn btn-primary boton">Revisión</button>
                    <?php
                } else {
                }
                $estado = "";
                $consultaequiponota = "select b.idequipo from usuarios a inner join  procesos b on b.idproceso=a.idproceso where a.idusuario = $idusuario";
                $queryequiponota = mysqli_query($link, $consultaequiponota) or die($consultaequiponota);
                $filaequiponota = mysqli_fetch_array($queryequiponota);
                $consultaequipousuario = "select b.idequipo from usuarios a inner join  procesos b on b.idproceso=a.idproceso where a.idusuario = $_SESSION[idusuario] ";
                $qeryrquipousuario = mysqli_query($link, $consultaequipousuario) or die($consultaequipousuario);
                $filaequipousuario = mysqli_fetch_array($qeryrquipousuario);
                $consultaminimo = "SELECT * FROM `general`";
                $queryminimo = mysqli_query($link, $consultaminimo) or die($consultaminimo);
                $filaminimo = mysqli_fetch_array($queryminimo);
                $filaminimo['salariominimo'] * 500;
                if ($_SESSION['aprobacion'] == 1) {
                    if ($filaequiponota['idequipo'] == $filaequipousuario['idequipo'] && ($filaminimo['salariominimo'] * 500) < $totalhaber && $nombreaprobador == '' && $revision == 1) {
                    ?>
                        <button <?php echo $estado ?> title="Aprobar Nota" id="aprobar" name="aprobar" class="btn btn-success boton">Aprobar</button>
                        <button <?php echo $estado ?> title="No aprobar nota contable." id="noaprobar" name="noaprobar" class="btn btn-danger boton" data-toggle="modal" data-target="#desaprobar">No aprobar</button>
                    <?php
                    } else {
                    }
                }
                if ($_SESSION['autorizacion'] == 1) {
                    if (($filaminimo['salariominimo'] * 500) < $totalhaber && $filadatosnota['autoriza'] == '') {
                    ?>
                        <button <?php echo $estado ?> title="Autorizar Nota" id="autorizar" name="autorizar" class="btn btn-warning boton">Autorizar</button>
                    <?php
                    }
                }
                if ($des != 'disabled' && $_SESSION['idusuario'] == $idusuario) {
                    ?>

                    <button <?php echo $estado ?> title="Guardar Nota" id="save" name="save" class="btn btn-info boton">Guardar</button>
                    <!-- // <button title="Cancelar Nota" id="cancel" name="cancel" class="btn btn-secondary boton">Cancelar</button> -->
                    <button title="Borrar Nota" id="delete" name="delete" class="btn btn-secondary boton">Limpiar</button>
            <?php
                }
            }
            ?>
            <div class="modal fade" id="desaprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Desaprobación de nota contable</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="">
                                <div class="form-row formulario">
                                    <div class="form-group completo">
                                        <h6 for="desde">Escriba el motivo de la desaprobación:</h6>
                                        <textarea class="form-control" name="comentariodesaprobacion" id="comentariodesaprobacion" rows="4"></textarea>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="confirmardesaprobar" class="btn btn-danger">No aprobar</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
    </footer>
</body>

</html>
<script>
    function openMsg() {
        document.getElementById("mensajes").style.width = "25%";
    }

    function closeNav() {
        document.getElementById("mensajes").style.width = "0";
    }
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#enviarmensaje').click(function() {
            a = 0;
            iddocumento = $('#iddocumento').val();
            comentariomensaje = $('#comentariomensaje').val();
            enviarmensaje(iddocumento, comentariomensaje);
            setTimeout(function() {
                //  window.location.reload();
            }, 1000);
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
        $('#revision').click(function() {
            a = 0;
            iddocumento = $('#iddocumento').val();
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
            creado = $('#creado').val();
            proceso = $('#proceso').val();
            if (creado == 0) {
                a = 0;
                if (type == 0) {
                    a = 1;
                    alertify.alert('ATENCION!!', 'Favor seleccionar un tipo de documento', function() {
                        alertify.success('Ok');
                    });
                }
                if (proceso == 0) {
                    a = 1;
                    alertify.alert('ATENCION!!', 'Debe seleccionar el proceso al que sera enviado la nota contable.', function() {
                        alertify.success('Ok');
                    });
                }
                if (proceso != 4) {
                    if (clasificacion == 0) {
                        a = 1;
                        alertify.alert('ATENCION!!', 'Favor seleccionar una clasificación para el documento', function() {
                            alertify.success('Ok');
                        });
                    }
                }

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
                    console.log('creado');
                    registrarnota(type, clasificacion, comentario, batch, proceso);
                    registrargrupo(iddoc, cuentas, dates, debes, habers, lms, ans);
                    setTimeout(function() {
                        //     window.location.href = "./home.php?id=" + iddoc + "&n=1"
                    }, 1000 + (cuentas.length * 10));
                } else {
                    //individual
                    cuenta = $('#cuenta').val();
                    fecha = $('#date').val();
                    debe = $('#debe').val();
                    haber = $('#haber').val();
                    lm = $('#lm').val();
                    an = $('#an').val();
                    tipolm = $('#tipolm').val();
                    if (debe <= 0 && haber <= 0) {
                        a = 1;
                        alertify.alert('ATENCIÓN!!', 'Debe llenar el campo de Debe o Haber(Los dos no pueden registrarse en valor menor o igual a cero). ', function() {
                            alertify.success('Ok');
                        });
                    }
                    if (cuenta == '') {
                        a = 1;
                        alertify.alert('ATENCIÓN!!', 'El campo de Cuenta se encuentra vacío', function() {
                            alertify.success('Ok');
                        });
                    }
                    if (fecha == '') {
                        a = 1;
                        alertify.alert('ATENCIÓN!!', 'El campo fecha se encuentra vacío', function() {
                            alertify.success('Ok');
                        });
                    }
                    if (a == 0) {
                        console.log('creado');
                        registrarnota(type, clasificacion, comentario, batch, proceso);
                        registrar(iddoc, cuenta, fecha, debe, haber, lm, an, tipolm);
                        setTimeout(function() {
                            //      window.location.href = "./home.php?id=" + iddoc + "&n=1"
                        }, 1000);
                    }
                }


            } else {
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
                        window.location.href = "./home.php?id=" + iddoc + "&n=1"
                    }, 1000 + (cuentas.length * 10));
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
                            //  window.location.href = "./home.php?id=" + iddoc + "&n=1"
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
            proceso = $('#proceso').val();
            if (creado == 1) {
                iddocumento = $('#iddocumento').val();
                totaldebe = $('#totaldebe').val();
                totalhaber = $('#totalhaber').val();
                usuario = $('#user').val();
                batch = '';
                a = 0;
                if (a == 0) {
                    editarnota(iddocumento, usuario, type, clasificacion, comentario, batch, proceso);
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
                    if (proceso != 4) {
                        if (clasificacion == 0) {
                            a = 1;
                            alertify.alert('ATENCION!!', 'Favor seleccionar una clasificación para el documento', function() {
                                alertify.success('Ok');
                            });
                        }
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
            //  elminarregistro(idu);
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