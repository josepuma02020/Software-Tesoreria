<?php
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $type = $_POST['type'];
    $clasificacion = $_POST['clasificacion'];
    $comentario = $_POST['comentario'];
    $usuario = $_SESSION['usuario'];
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    $fecha_actual = date("Y-m-j");
    $hora = date('h:i a');
    $usuario = $_SESSION['usuario'];
    $consultaconsecutivo = "select count(idregistro) 'consecutivo' from registrosdenota where idregistro like '%$ano$mes$dia%'";
    $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
    $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
    $consecutivo = $filaconsecutivo['consecutivo'] + 1;
    $idnota = $ano . $mes . $dia . $consecutivo;

    //ingresarnota
    $consultaingresonota = "INSERT INTO `notascontables`(`idnota`, `idusuario`, `idtipodocumento`, `idclasificacion`, `batch`, `comentario`, `fecha`, `hora`) VALUES 
    ('$idnota','$usuario','$type','$clasificacion','$batch','$comentario','$fecha_actual','$hora')";
    echo $querynota = mysqli_query($link, $consultaingresonota) or die($consultaingresonota);
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
