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
    $type = $_POST['type'];
    $clasificacion = $_POST['clasificacion'];
    $comentario = $_POST['comentario'];
    $usuario = $_SESSION['idusuario'];
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    $fecha_actual = date("Y-m-d");
    $hora = date('h:i a');
    echo $consultaconsecutivo = "select count(idnota) 'consecutivo' from notascontables where idnota like '%$ano$mes$dia%'";
    $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
    $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
    $consecutivo = $filaconsecutivo['consecutivo'] + 1;
    echo $idnota = $ano . $mes . $dia . $consecutivo;

    //ingresarnota
    $consultaingresonota = "INSERT INTO `notascontables`(`idnota`, `idusuario`, `idtipodocumento`, `idclasificacion`, `batch`, `comentario`, `fecha`, `hora`) VALUES 
    ('$idnota','$usuario','$type','$clasificacion','','$comentario','$fecha_actual','$hora')";
    $querynota = mysqli_query($link, $consultaingresonota) or die($consultaingresonota);
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
