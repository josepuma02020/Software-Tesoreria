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
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $iddocumento = $_POST['iddocumento'];
    $comentario = $_POST['comentario'];
    $fecha_actual = date("Y-m-d");
    $hora = date('h:i a');
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    $hora = date('h:i a');
    // $consulta = "UPDATE `notascontables` SET `revision`= '0'
    //     WHERE idnota = '$iddocumento'";
    // echo $query = mysqli_query($link, $consulta) or die($consulta);
    //mensaje
    $consultaidmensaje = "select count(idmensaje) 'consecutivo' from mensajes where fecha = ' $fecha_actual'";
    $query = mysqli_query($link, $consultaidmensaje) or die($consultaidmensaje);
    $filaconsecutivo = mysqli_fetch_array($query);
    if (isset($filaconsecutivo)) {
        $idregistro = $ano . $mes . $dia . ($filaconsecutivo['consecutivo'] + 1);
    } else {
        $idregistro = $ano . $mes . $dia . 1;
    }
    $consultanuevomensaje = "INSERT INTO `mensajes`(`idmensaje`, `mensaje`, `idnota`, `fecha`, `hora`, `idusuario`) VALUES ('$idregistro','$comentario','$iddocumento','$fecha_actual','$hora','$_SESSION[idusuario]')";
    echo $query = mysqli_query($link, $consultanuevomensaje) or die($consultanuevomensaje);
}
