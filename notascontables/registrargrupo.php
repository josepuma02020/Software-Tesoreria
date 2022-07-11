<?php
session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $id = $_POST['iddoc'];
    $cuenta = $_POST['cuentas'];
    $debe = $_POST['debes'];
    $haber = $_POST['habers'];
    $lm = $_POST['lms'];
    $an = $_POST['ans'];
    $fechas = $_POST['dates'];


    //consultaconsecutivo
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    $consultaconsecutivo = "select count(idregistro) 'consecutivo' from registrosdenota where idregistro like '%$ano$mes$dia%'";
    $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
    $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
    $consecutivo = $filaconsecutivo['consecutivo'] + 1;


    $cuenta = explode(',', $cuenta);
    $debe = explode(',', $debe);
    $haber = explode(',', $haber);
    $lm = explode(',', $lm);
    $an = explode(',', $an);
    $fechas = explode(',', $fechas);

    $n =  count($cuenta) - 1;
    for ($i = 0; $i <= $n; $i++) {
        $idregistro = $ano . $mes . $dia . $consecutivo;
        $consecutivo++;
        if ($lm[$i] != 0) {
            $tipo = 'A';
        } else {
            $tipo = '';
        }

        //ingresarregistro
        $consultaingresoregistro = "INSERT INTO `registrosdenota`(`idregistro`, `idnota`, `fecha`, `debe`, `haber`, `lm`, `an`, `tipolm`, `idcuenta`) VALUES 
         ('$idregistro','$id','$fechas[$i]','$debe[$i]','$haber[$i]','$lm[$i]','$an[$i]','$tipo','$cuenta[$i]')";
        echo $queryregistro = mysqli_query($link, $consultaingresoregistro) or die($consultaingresoregistro);
    }
} else {
    header('Location: ' . "../usuarios/cerrarsesion.php");
}
