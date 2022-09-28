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
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    $id = $_POST['iddoc'];
    $fecha = $_POST['fecha'];
    $concepto = $_POST['concepto'];
    $importe = $_POST['importe'];
    $tm = $_POST['tm'];
    $lmauxiliar = $_POST['lmauxiliar'];
    $an = $_POST['an'];
    // consecutivo
    $consultaconsecutivo = "select count(idregistro) 'consecutivo' from registrosdenota where idregistro like '%$ano$mes$dia%'";
    $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
    $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
    $consecutivo = $filaconsecutivo['consecutivo'] + 1;
    $idregistro = $ano . $mes . $dia . $consecutivo;
    //consulta cuentas-conceptos
    $consultacuentas = "select * from cuentas where concepto = '$concepto'";
    $querycuentas = mysqli_query($link, $consultacuentas) or die($consultacuentas);
    if (mysqli_num_rows($querycuentas) > 0) {
        while ($filascuentas = mysqli_fetch_array($querycuentas)) {
            $consultaconsecutivo = "select count(idregistro) 'consecutivo' from registrosdenota where idregistro like '%$ano$mes$dia%'";
            $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
            $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
            $consecutivo = $filaconsecutivo['consecutivo'] + 1;
            $idregistro = $ano . $mes . $dia . $consecutivo;
            if ($filascuentas['tipo'] == 'c') {
                $consultaingresoregistro = "INSERT INTO `registrosdenota`(`idregistro`, `idnota`, `fecha`, `debe`, `haber`, `lm`, `an`, `tipolm`, `idcuenta`) VALUES 
            ('$idregistro','$id','$fecha','0','$importe','$tm','$an','$lmauxiliar','$filascuentas[idcuenta]')";
                echo   $queryregistro = mysqli_query($link, $consultaingresoregistro) or die($consultaingresoregistro);
            } else {
                $consultaingresoregistro = "INSERT INTO `registrosdenota`(`idregistro`, `idnota`, `fecha`, `debe`, `haber`, `lm`, `an`, `tipolm`, `idcuenta`) VALUES 
            ('$idregistro','$id','$fecha','$importe','0','$tm','$an','$lmauxiliar','$filascuentas[idcuenta]')";
                echo   $queryregistro = mysqli_query($link, $consultaingresoregistro) or die($consultaingresoregistro);
            }
        }
    } else {
        $consultaconsecutivo = "select max(consecutivo) 'consecutivo' from registrosdenota where idregistro like '%$ano$mes$dia%'";
        $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
        $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
        if (isset($filaconsecutivo)) {
            $consecutivo = $filaconsecutivo['consecutivo'] + 1;
        } else {
            $consecutivo = 0;
        }
        $consecutivo++;
        $idregistro = $ano . $mes . $dia . $consecutivo;
        $consecutivo++;
        $consultaingresoregistro = "INSERT INTO `registrosdenota`(`idregistro`, `idnota`, `fecha`, `debe`, `haber`, `lm`, `an`, `tipolm`, `idcuenta`,`consecutivo`) VALUES 
        ('$idregistro','$id','$fecha','0','$importe','$tm','$an','$lmauxiliar','$concepto','$consecutivo')";
        echo $queryregistro = mysqli_query($link, $consultaingresoregistro) or die($consultaingresoregistro);
        $consultaingresoregistro = "UPDATE `notascontables` SET `seleccion`='1' WHERE idnota = '$id'";
        echo $queryregistro = mysqli_query($link, $consultaingresoregistro) or die($consultaingresoregistro);
    }
} else {
    header('Location: ' . "../usuarios/cerrarsesion.php");
}
