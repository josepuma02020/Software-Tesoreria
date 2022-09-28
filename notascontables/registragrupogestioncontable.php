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
    $id = $_POST['iddoc'];
    $conceptos = $_POST['conceptos'];
    $fechas = $_POST['fechas'];
    $importes = $_POST['importes'];
    $an = $_POST['ans'];
    $tm = $_POST['tms'];
    //consultaconsecutivo
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    $consultaconsecutivo = "select count(idregistro) 'consecutivo' from registrosdenota where idregistro like '%$ano$mes$dia%'";
    $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
    $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
    $consecutivo = $filaconsecutivo['consecutivo'] + 1;
    $conceptos = explode(',', $conceptos);
    $importe = explode(',', $importes);
    $an = explode(',', $an);
    $fecha = explode(',', $fechas);
    $tm = explode(',', $tm);
    $n =  count($conceptos) - 1;
    for ($i = 0; $i <= $n; $i++) {
        $idregistro = $ano . $mes . $dia . $consecutivo;
        $consecutivo++;
        if ($tm[$i] != 0) {
            $tipo = 'A';
        } else {
            $tipo = '';
        }
        //consultar cuentas de conceptos
        $consultacuentas = "select * from cuentas where concepto = '$conceptos[$i]'";
        $querycuentas = mysqli_query($link, $consultacuentas) or die($consultacuentas);
        if (mysqli_num_rows($querycuentas) > 0) {
            while ($filascuentas = mysqli_fetch_array($querycuentas)) {
                $consultaconsecutivo = "select max(consecutivo) 'consecutivo' from registrosdenota where idregistro like '%$ano$mes$dia%'";
                $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
                $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
                if (mysqli_num_rows($queryconsecutivo) == 0) {
                    $consecutivo = 0;
                } else {
                    $consecutivo = $filaconsecutivo['consecutivo'];
                }
                $idregistro = $ano . $mes . $dia . $consecutivo;
                $consecutivo++;
                if ($filascuentas['tipo'] == 'c') {
                    $consultaingresoregistro = "INSERT INTO `registrosdenota`(`idregistro`, `idnota`, `fecha`, `debe`, `haber`, `lm`, `an`, `tipolm`, `idcuenta`,`consecutivo`) VALUES 
                ('$idregistro','$id','$fecha[$i]','0','$importe[$i]','$tm[$i]','$an[$i]','$tipo','$filascuentas[idcuenta]','$consecutivo')";
                    echo   $queryregistro = mysqli_query($link, $consultaingresoregistro) or die($consultaingresoregistro);
                } else {
                    $consultaingresoregistro = "INSERT INTO `registrosdenota`(`idregistro`, `idnota`, `fecha`, `debe`, `haber`, `lm`, `an`, `tipolm`, `idcuenta`,`consecutivo`) VALUES 
                ('$idregistro','$id','$fecha[$i]','$importe[$i]','0','$tm[$i]','$an[$i]','$tipo','$filascuentas[idcuenta]','$consecutivo')";
                    echo   $queryregistro = mysqli_query($link, $consultaingresoregistro) or die($consultaingresoregistro);
                }
            }
        } else {
            $consultaconsecutivo = "select count(idregistro) 'consecutivo' from registrosdenota where idregistro like '%$ano$mes$dia%'";
            $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
            $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
            $consecutivo = $filaconsecutivo['consecutivo'] + 1;
            $idregistro = $ano . $mes . $dia . $consecutivo;
            $consecutivo++;
            $consultaingresoregistro = "INSERT INTO `registrosdenota`(`idregistro`, `idnota`, `fecha`, `debe`, `haber`, `lm`, `an`, `tipolm`, `idcuenta`, `consecutivo`) VALUES 
            ('$idregistro','$id','$fecha[$i]','0','$importe[$i]','$tm[$i]','$an[$i]','$tipo','$conceptos[$i]','$consecutivo')";
            echo $queryregistro = mysqli_query($link, $consultaingresoregistro) or die($consultaingresoregistro);
            $consultaingresoregistro = "UPDATE `notascontables` SET `seleccion`='1' WHERE idnota = '$id'";
            $queryregistro = mysqli_query($link, $consultaingresoregistro) or die($consultaingresoregistro);
        }
    }
} else {
    header('Location: ' . "../usuarios/cerrarsesion.php");
}
