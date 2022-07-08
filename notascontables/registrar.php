<?php
session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $id = $_POST['idnota'];
    $fecha = $_POST['fecha'];
    $cuenta = $_POST['cuenta'];
    $debe = $_POST['debe'];
    $haber = $_POST['haber'];
    $lm = $_POST['lm'];
    $an = $_POST['an'];
    $tipolm = $_POST['tipolm'];

    //consultaidregistro
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    echo $consultaconsecutivo = "select count(idregistro) 'consecutivo' from registrosdenota where idregistro like '%$ano$mes$dia%'";
    $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
    $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
    $consecutivo = $filaconsecutivo['consecutivo'] + 1;
    $idregistro = $ano . $mes . $dia . $consecutivo;

    //ingresarregistro
    $consultaingresoregistro = "INSERT INTO `registrosdenota`(`idregistro`, `idnota`, `fecha`, `debe`, `haber`, `lm`, `an`, `tipolm`, `idcuenta`) VALUES 
    ('$idregistro','$id','$fecha','$debe','$haber','$lm','$an','$tipolm','$cuenta')";
    echo $queryregistro = mysqli_query($link, $consultaingresoregistro) or die($consultaingresoregistro);
} else {
    header('Location: ' . "../usuarios/cerrarsesion.php");
}
