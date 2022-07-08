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

    $consultaconsecutivo = "select count(idnota) 'consecutivo' from notascontables where fecha = '$fecha_actual'";
    $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
    $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
    if (isset($filaconsecutivo)) {
        $consecutivo = $filaconsecutivo['consecutivo'] + 1;
    } else {
        $consecutivo = 1;
    }
    echo $consecutivo;
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
